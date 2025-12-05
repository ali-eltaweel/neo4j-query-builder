<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\HasParameters;

class Return_ implements IClause {

    use HasParameters;

    private array $elements;

    private bool $distinct;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        $distinct = $this->distinct ? 'DISTINCT ' : '';

        return sprintf('RETURN %s%s', $distinct, implode(', ', $this->elements));
    }

    public function reset(): void {

        $this->elements = [];
        $this->distinct = false;
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

    public final function distinct(bool $distinct = true): self {

        $this->distinct = $distinct;

        return $this;
    }
}
