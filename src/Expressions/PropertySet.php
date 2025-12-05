<?php

namespace Neo4jQueryBuilder\Expressions;

use Neo4jQueryBuilder\HasParameters;

class PropertySet extends Expression {

    use HasParameters;

    private ?string $property;
    
    private ?string $valueParameter;
    
    private mixed $value;

    public final function __toString(): string {

        if (is_null($this->property)) {

            throw new \RuntimeException('Property name is not set for PropertySet expression.');
        }

        $value = is_null($this->valueParameter) ? $this->value : '$' . $this->valueParameter;

        return sprintf('%s = %s', $this->property, $value);
    }

    public final function getParameters(): array {

        return is_null($this->valueParameter)
            ? $this->parameters
            : [ ...$this->parameters, $this->valueParameter => $this->value ];
    }
    
    public final function reset(): void {

        $this->property   = null;
        $this->value      = null;
        $this->parameters = [];
    }

    public final function name(string $property): self {
        
        $this->property = $property;
        
        return $this;
    }

    public final function value(mixed $value): self {

        $this->value = $value;
        $this->valueParameter = static::generateParameterName();

        return $this;
    }

    public final function rawValue(mixed $value): self {

        $this->value = $value;
        $this->valueParameter = null;

        return $this;
    }
}
