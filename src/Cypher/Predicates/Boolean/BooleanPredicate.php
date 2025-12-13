<?php

namespace Neo4jQueryBuilder\Cypher\Predicates\Boolean;

use Neo4jQueryBuilder\Cypher\Predicates\Predicate;

abstract class BooleanPredicate extends Predicate {

    protected const OPERATOR = '';

    private array $predicates;

    public function __construct(Predicate ...$predicates) {

        parent::__construct();

        $this->predicates = $predicates;
    }

    public function getQueryString(): string {

        if (empty($this->predicates)) {

            return '';
        }

        return implode(
            sprintf(' %s ', static::OPERATOR),
            array_map(
                fn (Predicate $predicate) => $predicate instanceof self ? "({$predicate})" : $predicate,
                $this->predicates
            )
        );
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->predicates,
            fn (array $parameters, Predicate $predicate) => array_merge($parameters, $predicate->getParameters()),
            parent::getParameters()
        );
    }
}

