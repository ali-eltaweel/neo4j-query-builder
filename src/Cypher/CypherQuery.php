<?php

namespace Neo4jQueryBuilder\Cypher;

use Neo4jQueryBuilder\Cypher\Clauses\Clause;

final class CypherQuery extends Cypher {

    /** @var Clause[] */
    private array $clauses;

    public final function __construct() {

        parent::__construct();

        $this->clauses = [];
    }

    public final function getQueryString(): string {

        return implode("\n", $this->clauses);
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->clauses,
            fn (array $parameters, Clause $clause) => array_merge($parameters, $clause->getParameters()),
            parent::getParameters()
        );
    }

    public final function addClause(Clause $clause): self {

        $this->clauses[] = $clause;

        return $this;
    }
}
