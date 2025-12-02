<?php

namespace Neo4jQueryBuilder;

class ConditionBuilder extends ParameterGenerator {

    private ?string $lhs;
    
    private ?string $operator;
    
    private mixed $rhs;
    
    private ?string $rhsParam;

    private ?ConditionBuilder $and;

    private ?ConditionBuilder $or;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return implode('', [
            sprintf('%s %s %s%s', $this->lhs, $this->operator, is_null($this->rhsParam) ? '' : '$', $this->rhsParam),
            $this->and ? ' AND ' . $this->and : '',
            $this->or  ? ' OR '  . $this->or  : '',
        ]);
    }

    public function reset(): void {

        $this->lhs      = null;
        $this->operator = null;
        $this->rhs      = null;
        $this->rhsParam = null;
        $this->and      = null;
        $this->or       = null;
    }

    public final function getParameters(): array {

        if (is_null($this->rhsParam)) {

            $parameters = [];
        } else {

            $parameters = [ $this->rhsParam => $this->rhs ];
        }

        return array_merge(
            $parameters,
            $this->and?->getParameters() ?? [],
            $this->or?->getParameters() ?? [],
        );
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
        $this->rhsParam = static::generateParameterName();

        return $this;
    }

    public final function and(): self {

        return $this->and = new ConditionBuilder();
    }

    public final function or(): self {

        return $this->or = new ConditionBuilder();
    }
}
