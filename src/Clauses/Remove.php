<?php

namespace Neo4jQueryBuilder\Clauses;

class Remove implements IClause {

    private array $expressions;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('REMOVE %s', implode(', ', $this->expressions));
    }

    public function reset(): void {

        $this->expressions = [];
    }

    public final function getParameters(): array {

        throw new \RuntimeException('Not implemented yet.');
    }

    public final function expression(string $expression): self {

        $this->expressions[] = $expression;

        return $this;
    }

    public final function expressions(array $expressions): self {

        foreach ($expressions as $expression) {

            $this->expressions[] = $expression;
        }

        return $this;
    }
}
