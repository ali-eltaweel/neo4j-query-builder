<?php

namespace Neo4jQueryBuilder\Clauses;

class OrderBy implements IClause {

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
    }

    public final function getParameters(): array {

        return [];
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
