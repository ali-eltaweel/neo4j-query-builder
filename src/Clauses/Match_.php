<?php

namespace Neo4jQueryBuilder\Clauses;

use Closure;
use Neo4jQueryBuilder\NodeBuilder;
use Neo4jQueryBuilder\RelationshipBuilder;

class Match_ implements IClause {

    private array $nodes;
    
    private array $relationships;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('MATCH %s', implode(', ', [...$this->relationships, ...$this->nodes]));
    }

    public function reset(): void {

        $this->nodes         = [];
        $this->relationships = [];
    }

    public final function getParameters(): array {

        return array_reduce(
            [ ...$this->nodes, ...$this->relationships ],
            fn(array $carry, NodeBuilder|RelationshipBuilder $builder) => array_merge($carry, $builder->getParameters()),
            []
        );
    }

    public final function node(?Closure $callback = null): NodeBuilder {

        $node = $this->nodes[] = new NodeBuilder();

        if (!is_null($callback)) {

            $callback($node);
        }

        return $node;
    }

    public final function relationship(?Closure $callback = null): RelationshipBuilder {

        $relationship = $this->relationships[] = new RelationshipBuilder();

        if (!is_null($callback)) {

            $callback($relationship);
        }

        return $relationship;
    }
}
