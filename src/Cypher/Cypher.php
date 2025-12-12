<?php

namespace Neo4jQueryBuilder\Cypher;

use Stringable;

abstract class Cypher implements Stringable {

    private static int $parameterCounter = 0;

    private array $parameters;

    public function __construct() {

        $this->parameters = [];
    }

    public final function __toString(): string {

        return $this->getQueryString();
    }

    public final function addParameter(string $name, mixed $value): void {

        $this->parameters[$name] = $value;
    }

    public function getParameters(): array {

        return $this->parameters;
    }

    public abstract function getQueryString(): string;

    protected static final function newParameter(): string {

        return 'param_' . (++self::$parameterCounter);
    }
}
