<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\HasParameters;

class OrderBy implements IClause {

    use HasParameters;

    private array $elements;

    private bool $ascending;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('ORDER BY %s%s', implode(', ', $this->elements), $this->ascending ? ' ASC' : ' DESC');
    }

    public function reset(): void {

        $this->elements  = [];
        $this->ascending = true;
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return $this->parameters;
    }

    public final function elements(string ...$elements): self {

        foreach ($elements as $element) {
            
            $this->elements[] = $element;
        }

        return $this;
    }

    public final function descending(): self {

        $this->ascending = false;

        return $this;
    }
}
