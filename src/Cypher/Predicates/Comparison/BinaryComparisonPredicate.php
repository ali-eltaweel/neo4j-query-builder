<?php

namespace Neo4jQueryBuilder\Cypher\Predicates\Comparison;

abstract class BinaryComparisonPredicate extends ComparisonPredicate {

    private ?string $parameter;
    
    private mixed $value;

    public final function __construct(string $lhs, mixed $value, bool $raw = false) {

        parent::__construct($lhs);

        if ($raw) {

            $this->value = $value;
            $this->parameter = null;
        } else {
            $this->parameter = self::newParameter();
            $this->addParameter($this->parameter, $value);
        }
    }

    public final function getQueryString(): string {

        return parent::getQueryString() . ' ' . (is_null($this->parameter) ? $this->value : "\${$this->parameter}");
    }
}
