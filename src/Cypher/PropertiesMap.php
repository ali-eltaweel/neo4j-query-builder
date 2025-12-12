<?php

namespace Neo4jQueryBuilder\Cypher;

final class PropertiesMap extends Cypher {

    private array $properties;

    private string $mapParameter;

    public final function __construct(array $properties = []) {

        parent::__construct();

        $this->properties = [];

        $this->addAll($properties);

        $this->mapParameter = self::newParameter();
    }

    public final function getQueryString(): string {

        if (!$this->hasRawCypher()) {

            return sprintf('$%s', $this->mapParameter);
        }

        if (empty($this->properties)) {

            return '';
        }

        $properties = [];

        foreach ($this->properties as $k => $v) {

            $properties[] = sprintf('%s: %s', $k, $v instanceof RawCypher ? $v : "\${$v}");
        }

        $properties = implode(', ', $properties);

        return sprintf('{ %s }', $properties);
    }

    public final function getParameters(): array {

        if (!$this->hasRawCypher()) {

            $params = parent::getParameters();

            return [
                $this->mapParameter => array_map(fn (string $param) => $params[$param], $this->properties)
            ];
        }

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

    public final function hasRawCypher(): bool {

        foreach ($this->properties as $value) {

            if ($value instanceof RawCypher) {

                return true;
            }
        }

        return false;
    }
}
