<?php

namespace Neo4jQueryBuilder\Clauses;

use Closure;
use Neo4jQueryBuilder\NodeBuilder;
use Neo4jQueryBuilder\RelationshipBuilder;
use Stringable;

class Match_ implements Stringable {

    private ?NodeBuilder $node;
    
    private ?RelationshipBuilder $relationship;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('MATCH %s', $this->relationship ?? $this->node);
    }

    public function reset(): void {

        $this->node         = null;
        $this->relationship = null;
    }

    public final function node(?Closure $callback = null): NodeBuilder {

        $node = $this->node = new NodeBuilder();

        if (!is_null($callback)) {

            $callback($node);
        }

        return $node;
    }

    public final function relationship(?Closure $callback = null): RelationshipBuilder {

        $relationship = $this->relationship = new RelationshipBuilder();

        if (!is_null($callback)) {

            $callback($relationship);
        }

        return $relationship;
    }
}
