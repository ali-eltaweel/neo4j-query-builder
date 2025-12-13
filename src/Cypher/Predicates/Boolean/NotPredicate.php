<?php

namespace Neo4jQueryBuilder\Cypher\Predicates\Boolean;

use Neo4jQueryBuilder\Cypher\Predicates\Predicate;

final class NotPredicate extends BooleanPredicate {

    protected const OPERATOR = 'NOT';

    public final function __construct(Predicate $predicate) {

        parent::__construct($predicate);
    }

    public final function getQueryString(): string {

        return static::OPERATOR . ' ' . parent::getQueryString();
    }
}
