<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class Limit extends Clause {

    public final function __construct(private int $limit) {

        parent::__construct();
    }

    public final function getQueryString(): string {

        return 'LIMIT ' . $this->limit;
    }
}
