<?php

namespace Neo4jQueryBuilder\Clauses;

use Stringable;

class Set implements Stringable {

    private array $expressions;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('SET %s', implode(', ', $this->expressions));
    }

    public function reset(): void {

        $this->expressions = [];
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
