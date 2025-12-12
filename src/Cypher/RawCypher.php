<?php

namespace Neo4jQueryBuilder\Cypher;

final class RawCypher extends Cypher {

    public final function __construct(private string $cypher, array $parameters = []) {

        parent::__construct();

        foreach ($parameters as $name => $value) {

            $this->addParameter($name, $value);
        }
    }

    public final function getQueryString(): string {

        return $this->cypher;
    }
}
