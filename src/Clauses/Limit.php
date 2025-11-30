<?php

namespace Neo4jQueryBuilder\Clauses;

use Stringable;

class Limit implements Stringable {

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

    public final function limit(int $limit): self {

        $this->limit = $limit;

        return $this;
    }
}
