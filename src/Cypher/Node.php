<?php

namespace Neo4jQueryBuilder\Cypher;

final class Node extends Cypher {

    public readonly PropertiesMap $properties;

    public final function __construct(
        private ?string $alias      = null,
        private array   $labels     = [],
                array   $properties = [],
    ) {

        parent::__construct();

        $this->properties = new PropertiesMap($properties);
    }

    public final function getQueryString(): string {

        $node = "{$this->alias}";

        $node .= implode('', array_map(fn (string $label) => ":{$label}", $this->labels));

        if (strlen($properties = strval($this->properties))) {

            $node .= " {$properties}";
        }

        return sprintf('(%s)', $node);
    }

    public final function getParameters(): array {

        return array_merge(
            parent::getParameters(),
            $this->properties->getParameters()
        );
    }

    public final function alias(string $alias): self {

        $this->alias = $alias;
        
        return $this;
    }

    public final function addLabel(string $label): self {

        if (!in_array($label, $this->labels)) {

            $this->labels[] = $label;
        }
        
        return $this;
    }
}
