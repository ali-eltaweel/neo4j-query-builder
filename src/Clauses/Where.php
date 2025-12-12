<?php

namespace Neo4jQueryBuilder\Clauses;

use Closure;
use Neo4jQueryBuilder\ConditionBuilder;
use Neo4jQueryBuilder\HasParameters;

class Where implements IClause {

    use HasParameters;

    private ?ConditionBuilder $condition;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return "WHERE {$this->condition}";
    }

    public function reset(): void {

        $this->condition  = null;
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return array_merge($this->parameters, $this->condition->getParameters());
    }

    public final function condition(?Closure $callback = null): ConditionBuilder {

        return $this->and($callback);
    }

    public final function name(string $name): ConditionBuilder {

        return $this->condition()->name($name);
    }

    public final function and(?Closure $callback = null): ConditionBuilder {
        
        if (is_null($this->condition)) {
            
            $condition = new ConditionBuilder();
            $this->condition = $condition;
        } else {

            $condition = $this->condition->and();
        }

        if (!is_null($callback)) {
            
            $callback($condition);
        }

        return $condition;
    }

    public final function or(?Closure $callback = null): ConditionBuilder {
        
        if (is_null($this->condition)) {
            
            $condition = new ConditionBuilder();
            $this->condition = $condition;
        } else {

            $condition = $this->condition->or();
        }

        if (!is_null($callback)) {
            
            $callback($condition);
        }

        return $condition;
    }

    public final function andNot(?Closure $callback = null): ConditionBuilder {
        
        if (is_null($this->condition)) {
            
            $this->condition = new ConditionBuilder();
            $condition = $this->condition->not();
        } else {

            $condition = $this->condition->and()->not();
        }

        if (!is_null($callback)) {
            
            $callback($condition);
        }

        return $condition;
    }

    public final function orNot(?Closure $callback = null): ConditionBuilder {
        
        if (is_null($this->condition)) {
            
            $this->condition = new ConditionBuilder();
            $condition = $this->condition->not();
        } else {

            $condition = $this->condition->or()->not();
        }

        if (!is_null($callback)) {
            
            $callback($condition);
        }

        return $condition;
    }
}
