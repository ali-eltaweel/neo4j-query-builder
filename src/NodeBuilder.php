<?php

namespace Neo4jQueryBuilder;

use Stringable;

class NodeBuilder implements Stringable {

    private ?string $alias;
    
    private array $labels;
    
    private array $properties;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        $labels = array_map(fn (string $label): string => sprintf(':%s', $label), $this->labels);

        $properties = [];

        foreach ($this->properties as $k => $v) {

            if (is_string($v)) {

                $v = sprintf('"%s"', $v);
            }

            $properties[] = sprintf('%s: %s', $k, $v);
        }

        $properties = implode(', ', $properties);

        return sprintf(
            '(%s%s%s)',
            $this->alias,
            implode('', $labels),
            strlen($properties) ? " { {$properties} }" : ''
        );
    }

    public function reset(): void {

        $this->alias      = null;
        $this->labels     = [];
        $this->properties = [];
    }

    public final function alias(string $alias): self {

        $this->alias = $alias;

        return $this;
    }

    public final function label(string $label): self {

        $this->labels[] = $label;

        return $this;
    }

    public final function property(string $key, mixed $value): self {

        $this->properties[$key] = $value;

        return $this;
    }

    public final function properties(array $properties): self {

        foreach ($properties as $key => $value) {

            $this->properties[$key] = $value;
        }

        return $this;
    }
}