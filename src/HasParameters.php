<?php

namespace Neo4jQueryBuilder;

trait HasParameters {

    private array $parameters;

    public final function addParameter(string $key, mixed $value): void {

        $this->parameters[$key] = $value;
    }
}
