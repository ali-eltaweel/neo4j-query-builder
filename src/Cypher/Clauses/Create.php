<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

use Neo4jQueryBuilder\Cypher\{ Node, Relationship };

final class Create extends Clause {

    /** @var array<Node|Relationship> */
    private array $ditems;

    public final function __construct() {

        parent::__construct();

        $this->ditems = [];
    }

    public final function getQueryString(): string {

        return sprintf('CREATE %s', implode(', ', $this->ditems));
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->ditems,
            fn (array $parameters, Node|Relationship $element) => array_merge($parameters, $element->getParameters()),
            parent::getParameters()
        );
    }

    public final function addItem(Node|Relationship $item): self {

        $this->ditems[] = $item;

        return $this;
    }
}
