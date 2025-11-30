<?php

namespace Neo4jQueryBuilder;

use Stringable;

class ConditionBuilder implements Stringable {

    private ?string $lhs;
    
    private ?string $operator;
    
    private mixed $rhs;

    private ?ConditionBuilder $and;

    private ?ConditionBuilder $or;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        $lhs      = $this->lhs;
        $operator = $this->operator;
        $rhs      = $this->rhs;

        if (is_string($rhs)) {
            $rhs = "'" . $rhs . "'";
        } elseif (is_bool($rhs)) {
            $rhs = $rhs ? 'true' : 'false';
        } elseif ($rhs === null) {
            $rhs = 'null';
        }

        return implode('', [
            sprintf('%s %s %s', $lhs, $operator, $rhs),
            $this->and ? ' AND ' . $this->and : '',
            $this->or  ? ' OR '  . $this->or  : '',
        ]);
    }

    public function reset(): void {

        $this->lhs      = null;
        $this->operator = null;
        $this->rhs      = null;
        $this->and      = null;
        $this->or       = null;
    }

    public final function name(string $lhs): self {

        $this->lhs = $lhs;

        return $this;
    }

    public final function operator(string $operator): self {

        $this->operator = $operator;

        return $this;
    }

    public final function value(mixed $rhs): self {

        $this->rhs = $rhs;

        return $this;
    }

    public final function and(): self {

        return $this->and = new ConditionBuilder();
    }

    public final function or(): self {

        return $this->or = new ConditionBuilder();
    }
}
