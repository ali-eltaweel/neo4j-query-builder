<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\HasParameters;

class Limit implements IClause {

    use HasParameters;

    private ?int $limit;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('LIMIT %d', $this->limit);
    }

    public function reset(): void {

        $this->limit      = null;
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return $this->parameters;
    }

    public final function limit(int $limit): self {

        $this->limit = $limit;

        return $this;
    }
}
