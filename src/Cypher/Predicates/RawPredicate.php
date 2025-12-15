<?php

namespace Neo4jQueryBuilder\Cypher\Predicates;

use Neo4jQueryBuilder\Cypher\Predicates\Predicate;
use Neo4jQueryBuilder\Cypher\RawCypher;

final class RawPredicate extends Predicate {

    private RawCypher $cypher;

    public final function __construct(string $cypher, array $parameters = []) {

        $this->cypher = new RawCypher($cypher, $parameters);
    }

    public final function getQueryString(): string {

        return $this->cypher->getQueryString();
    }

    public final function getParameters(): array {

        return $this->cypher->getParameters();
    }
}
