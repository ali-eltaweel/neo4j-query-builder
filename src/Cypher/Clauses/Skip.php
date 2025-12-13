<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class Skip extends Clause {

    public final function __construct(private int $count) {

        parent::__construct();
    }

    public final function getQueryString(): string {

        return 'SKIP ' . $this->count;
    }
}
