<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class OrderBy extends Clause {

    private array $fields;

    public final function __construct() {

        parent::__construct();

        $this->fields = [];
    }

    public final function getQueryString(): string {

        $statement = 'ORDER BY ';

        foreach ($this->fields as [ $field, $order ]) {

            $statement .= "{$field} {$order}, ";
        }

        return rtrim($statement, ', ');
    }

    public final function ascending(string $field): self {

        $this->fields[] = [ $field, 'ASC' ];
        
        return $this;
    }

    public final function descending(string $field): self {

        $this->fields[] = [ $field, 'DESC' ];
        
        return $this;
    }
}
