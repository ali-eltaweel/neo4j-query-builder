<?php

namespace Neo4jQueryBuilder\Clauses;

class Limit implements IClause {

    private ?int $limit;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('LIMIT %d', $this->limit);
    }

    public function reset(): void {

        $this->limit = null;
    }

    public final function getParameters(): array {

        return [];
    }

    public final function limit(int $limit): self {

        $this->limit = $limit;

        return $this;
    }
}
