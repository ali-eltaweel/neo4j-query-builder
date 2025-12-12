<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

use Neo4jQueryBuilder\Cypher\Node;

final class Create extends Clause {

    /** @var Node[] */
    private array $elements;

    public final function __construct() {

        parent::__construct();

        $this->elements = [];
    }

    public final function getQueryString(): string {

        return sprintf('CREATE %s', implode(', ', $this->elements));
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->elements,
            fn (array $parameters, Node $element) => array_merge($parameters, $element->getParameters()),
            parent::getParameters()
        );
    }

    public final function addElement(Node $element): self {

        $this->elements[] = $element;

        return $this;
    }
}
