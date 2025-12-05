<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\Expressions\Expression;
use Neo4jQueryBuilder\Expressions\PropertySet;

class Set implements IClause {

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

    public final function getParameters(): array {

        return array_merge(
            ...array_map(
                fn (string|Expression $e) => is_string($e) ? [] : $e->getParameters(),
                $this->expressions
            )
        );
    }

    public final function rawExpression(string $expression): self {

        $this->expressions[] = $expression;

        return $this;
    }

    public final function property(): PropertySet {

        return $this->expressions[] = new PropertySet();
    }
}
