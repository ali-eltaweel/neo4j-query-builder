<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

use Neo4jQueryBuilder\Cypher\Predicates\Predicate;

final class Filter extends Clause {

    public final function __construct(private Predicate $predicate) {

        parent::__construct();
    }

    public final function getQueryString(): string {

        return 'FILTER ' . $this->predicate;
    }

    public final function getParameters(): array {

        return array_merge(
            parent::getParameters(),
            $this->predicate->getParameters()
        );
    }
}
