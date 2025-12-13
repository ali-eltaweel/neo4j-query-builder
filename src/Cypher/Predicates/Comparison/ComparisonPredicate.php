<?php

namespace Neo4jQueryBuilder\Cypher\Predicates\Comparison;

use Neo4jQueryBuilder\Cypher\Predicates\Predicate;

abstract class ComparisonPredicate extends Predicate {

    protected const OPERATOR = '';

    public function __construct(private string $lhs) {

        parent::__construct();
    }

    public function getQueryString(): string {

        return $this->lhs . ' ' . static::OPERATOR;
    }
}
