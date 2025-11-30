<?php

namespace Neo4jQueryBuilder\Clauses;

use Closure;
use Neo4jQueryBuilder\NodeBuilder;
use Neo4jQueryBuilder\RelationshipBuilder;
use Stringable;

class Create implements Stringable {

    private array $elements;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('CREATE %s', implode(', ', $this->elements));
    }

    public function reset(): void {

        $this->elements = [];
    }

    public final function node(?Closure $callback = null): NodeBuilder {

        $node = $this->elements[] = new NodeBuilder();

        if (!is_null($callback)) {

            $callback($node);
        }

        return $node;
    }

    public final function relationship(?Closure $callback = null): RelationshipBuilder {

        $relationship = $this->elements[] = new RelationshipBuilder();

        if (!is_null($callback)) {

            $callback($relationship);
        }

        return $relationship;
    }
}
