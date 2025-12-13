<?php

namespace Neo4jQueryBuilder\Cypher;

final class Relationship extends Cypher {

    public readonly PropertiesMap $properties;

    public readonly Node $left, $right;

    public final function __construct(
        private ?string $alias       = null,
        private array   $labels      = [],
                array   $properties  = [],
        private bool    $directed    = true,
        private bool    $leftToRight = true,
    ) {

        parent::__construct();

        $this->properties = new PropertiesMap($properties);

        $this->left  = new Node();
        $this->right = new Node();
    }

    public final function getQueryString(): string {

        $relationship = "{$this->alias}";
        
        $relationship .= implode('', array_map(fn (string $label) => ":{$label}", $this->labels));

        if (strlen($properties = strval($this->properties))) {

            $relationship .= " {$properties}";
        }

        $format = '-[%s]-';

        if ($this->directed) {

            if ($this->leftToRight) {

                $format .= '>';
            } else {

                $format = '<' . $format;
            }
        }

        return $this->left . sprintf($format, $relationship) . $this->right;
    }

    public final function getParameters(): array {

        return array_merge(
            parent::getParameters(),
            $this->properties->getParameters(),
            $this->left->getParameters(),
            $this->right->getParameters(),
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

    public final function leftToRight(bool $value = true): self {

        $this->leftToRight = $value;

        return $this;
    }

    public final function rightToLeft(): self {

        return $this->leftToRight(false);
    }

    public final function directed(bool $value = true): self {

        $this->directed = $value;

        return $this;
    }

    public final function undirected(): self {

        return $this->directed(false);
    }
}
