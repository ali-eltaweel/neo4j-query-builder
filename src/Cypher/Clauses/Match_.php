<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

use Neo4jQueryBuilder\Cypher\{ Node, Relationship };

final class Match_ extends Clause {

    /** @var array<Node|Relationship> */
    private array $items;

    public final function __construct() {

        parent::__construct();

        $this->items = [];
    }

    public final function getQueryString(): string {

        return sprintf('MATCH %s', implode(', ', $this->items));
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->items,
            fn (array $parameters, Node|Relationship $element) => array_merge($parameters, $element->getParameters()),
            parent::getParameters()
        );
    }

    public final function addItem(Node|Relationship $item): self {

        $this->items[] = $item;

        return $this;
    }
}
