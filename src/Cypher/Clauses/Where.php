<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

use Neo4jQueryBuilder\Cypher\Predicates\Predicate;

final class Where extends Clause {

    public final function __construct(private Predicate $predicate) {

        parent::__construct();
    }

    public final function getQueryString(): string {

        return 'WHERE ' . $this->predicate;
    }

    public final function getParameters(): array {

        return array_merge(
            parent::getParameters(),
            $this->predicate->getParameters()
        );
    }
}
