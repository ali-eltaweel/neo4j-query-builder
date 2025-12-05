<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\HasParameters;

class With implements IClause {

    use HasParameters;

    private array $elements;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('WITH %s', implode(', ', $this->elements));
    }

    public function reset(): void {

        $this->elements   = [];
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return $this->parameters;
    }

    public final function element(string $alias): self {

        $this->elements[] = $alias;

        return $this;
    }

    public final function elements(array $aliases): self {

        foreach ($aliases as $alias) {

            $this->elements[] = $alias;
        }

        return $this;
    }
}
