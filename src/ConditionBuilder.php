<?php

namespace Neo4jQueryBuilder;

use Closure;

class ConditionBuilder extends ParameterGenerator {

    use HasParameters;

    private ?string $type;

    private array $conditions;

    private ?string $name;
    
    private ?string $operator;
    
    private bool $valueSet;
    
    private mixed $value;
    
    private ?string $param;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        switch ($this->type) {

            case null:

                if (is_null($this->name)) {

                    return '';
                }

                $condition = $this->name;

                if (!is_null($this->operator)) {

                    $condition .= " {$this->operator}";
                }

                if ($this->valueSet) {

                    if (is_null($this->param)) {

                        $condition .= " {$this->value}";

                    } else {

                        $condition .= " \${$this->param}";
                    }
                }

                return $condition;

            case 'and':
            case 'or':

                $conditions = array_values(array_filter(
                    $this->conditions,
                    fn (self $condition) => !is_null($condition->type) || !is_null($condition->name)
                ));

                if (count($conditions) === 1) {

                    return $conditions[0];
                }

                return implode(' ' . strtoupper($this->type) . ' ', array_filter(array_map(
                    fn (self $condition) => count($condition->conditions) < 2 ? $condition : "({$condition})",
                    $this->conditions
                ), strlen(...)));

            case 'not':

                $condition = $this->conditions[0] . '';

                return strlen($condition) === 0 ? '' : "NOT {$condition}";
        }
        
        return '';
    }

    public function reset(): void {

        $this->type = null;
        $this->conditions = [];

        $this->name       = null;
        $this->operator   = null;
        $this->value      = null;
        $this->param      = null;
        $this->valueSet   = false;
        $this->parameters = [];
    }

    public final function getParameters(): array {

        switch ($this->type) {

            case null:

                return is_null($this->param) ? [] : [ $this->param => $this->value ];

            case 'and':
            case 'or':

                return array_reduce(
                    $this->conditions,
                    fn (array $prarameters, self $condition) => array_merge($prarameters, $condition->getParameters()),
                    []
                );

            case 'not':

                return $this->conditions[0]->getParameters();
        }

        return [];
    }

    public final function and(?Closure $callback = null): self {

        switch ($this->type) {

            case 'and':

                $newCondition = clone $this;
                $newCondition->reset();

                $this->conditions[] = $newCondition;

                if (!is_null($callback)) {
                    
                    $callback($newCondition);
                }
        
                return $newCondition;

            default:

                $oldCondition = clone $this;

                $this->reset();

                $this->type = 'and';

                $newCondition = clone $this;
                $newCondition->reset();

                $this->conditions = [ $oldCondition, $newCondition ];
        
                if (!is_null($callback)) {
                    
                    $callback($newCondition);
                }
        
                return $newCondition;
        }
    }

    public final function or(?Closure $callback = null): self {

        switch ($this->type) {

            case 'or':

                $newCondition = clone $this;
                $newCondition->reset();

                $this->conditions[] = $newCondition;

                if (!is_null($callback)) {
                    
                    $callback($newCondition);
                }
        
                return $newCondition;

            default:

                $oldCondition = clone $this;

                $this->reset();

                $this->type = 'or';

                $newCondition = clone $this;
                $newCondition->reset();

                $this->conditions = [ $oldCondition, $newCondition ];
        
                if (!is_null($callback)) {
                    
                    $callback($newCondition);
                }
        
                return $newCondition;
        }
    }

    public final function not(?Closure $callback = null): self {

        $newCondition = clone $this;
        $newCondition->reset();

        $this->type = 'not';

        $this->conditions = [ $newCondition ];
        
        if (!is_null($callback)) {
                    
            $callback($newCondition);
        }

        return $newCondition;
    }

    public final function name(string $name): self {

        $this->name = $name;

        return $this;
    }

    public final function operator(string $operator): self {

        $this->operator = $operator;

        return $this;
    }

    public final function value(mixed $value): self {

        $this->value = $value;
        $this->param = static::generateParameterName();
        $this->valueSet = true;

        return $this;
    }

    public final function rawValue(mixed $value, bool $quoteStrings = true): self {

        if (is_string($value)) {

            $value = sprintf('"%s"', $value);
        }

        if (is_null($value)) {

            $value = 'null';
        }

        $this->value = $value;
        $this->param = null;
        $this->valueSet = true;

        return $this;
    }
}
