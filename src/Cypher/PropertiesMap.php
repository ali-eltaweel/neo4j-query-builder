<?php

namespace Neo4jQueryBuilder\Cypher;

final class PropertiesMap extends Cypher {

    private array $properties;

    public final function __construct(array $properties = []) {

        parent::__construct();

        $this->properties = [];

        $this->addAll($properties);
    }

    public final function getQueryString(): string {

        if (empty($this->properties)) {

            return '';
        }

        $properties = [];

        foreach ($this->properties as $k => $v) {

            $properties[] = sprintf('%s: %s', $k, $v);
        }

        $properties = implode(', ', $properties);

        return sprintf('{ %s }', $properties);
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->properties,
            fn (array $parameters, mixed $value) => array_merge($parameters, $value instanceof RawCypher ? $value->getParameters() : []),
            parent::getParameters()
        );
    }

    public final function add(string $name, mixed $value): self {

        if ($value instanceof RawCypher) {

            $this->properties[ $name ] = $value;
        } else {

            $parameter = self::newParameter();
    
            $this->properties[ $name ] = $parameter;
    
            $this->addParameter($parameter, $value);
        }

        return $this;
    }

    public final function addAll(array $properties): self {

        foreach ($properties as $name => $value) {

            $this->add($name, $value);
        }

        return $this;
    }
}
