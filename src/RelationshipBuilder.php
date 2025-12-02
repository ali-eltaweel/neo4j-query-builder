<?php

namespace Neo4jQueryBuilder;

class RelationshipBuilder extends ParameterGenerator {

    private ?string $alias;

    private ?NodeBuilder $fromNode;

    private ?NodeBuilder $toNode;

    private array $labels;
    
    private array $properties;

    private array $parameters;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        $labels = array_map(fn (string $label): string => sprintf(':%s', $label), $this->labels);

        $properties = [];

        foreach ($this->properties as $k => $v) {

            $properties[] = sprintf('%s: %s', $k, $v);
        }

        $properties = implode(', ', $properties);

        return sprintf(
            '%s-[%s%s%s]->%s',
            $this->fromNode ?? new NodeBuilder(),
            $this->alias,
            implode('', $labels),
            strlen($properties) ? " { {$properties} }" : '',
            $this->toNode ?? new NodeBuilder()
        );
    }

    public function reset(): void {

        $this->alias      = null;
        $this->fromNode   = null;
        $this->toNode     = null;
        $this->labels     = [];
        $this->properties = [];
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return $this->parameters;
    }

    public final function alias(string $alias): self {

        $this->alias = $alias;

        return $this;
    }

    public final function from(): NodeBuilder {

        return $this->fromNode = new NodeBuilder();
    }

    public final function to(): NodeBuilder {

        return $this->toNode = new NodeBuilder();
    }

    public final function label(string $label): self {

        $this->labels[] = $label;

        return $this;
    }

    public final function property(string $key, mixed $value): self {

        $param = self::generateParameterName();

        $this->properties[$key] = '$' . $param;
        $this->parameters[$param] = $value;

        return $this;
    }

    public final function properties(array $properties): self {

        foreach ($properties as $key => $value) {

            $this->property($key, $value);
        }

        return $this;
    }
}
