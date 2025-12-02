<?php

namespace Neo4jQueryBuilder\Clauses;

use Closure;
use Neo4jQueryBuilder\ConditionBuilder;

class Where implements IClause {

    /** @var ConditionBuilder[] */
    private array $conditions;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf(
            'WHERE %s',
            implode(' AND ', array_map(
                fn (string $condition) => sprintf('(%s)', $condition),
                $this->conditions
            ))
        );
    }

    public function reset(): void {

        $this->conditions = [];
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->conditions,
            fn(array $carry, ConditionBuilder $builder) => array_merge($carry, $builder->getParameters()),
            []
        );
    }

    public final function condition(?Closure $callback = null): ConditionBuilder {

        $condition = $this->conditions[] = new ConditionBuilder();

        if (!is_null($callback)) {
            
            $callback($condition);
        }

        return $condition;
    }
}
