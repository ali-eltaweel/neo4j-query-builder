<?php

namespace Neo4jQueryBuilder\Clauses;

use Neo4jQueryBuilder\HasParameters;

class Skip implements IClause {

    use HasParameters;

    private ?int $skip;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('SKIP %d', $this->skip);
    }

    public function reset(): void {

        $this->skip       = null;
        $this->parameters = [];
    }

    public final function getParameters(): array {

        return $this->parameters;
    }

    public final function skip(int $skip): self {

        $this->skip = $skip;

        return $this;
    }
}
