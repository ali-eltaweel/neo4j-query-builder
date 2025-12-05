<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\HasParameters;

class Remove implements IClause {

    use HasParameters;

    private array $expressions;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('REMOVE %s', implode(', ', $this->expressions));
    }

    public function reset(): void {

        $this->expressions = [];
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return $this->parameters;
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
