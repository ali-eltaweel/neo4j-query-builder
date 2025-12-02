<?php

namespace Neo4jQueryBuilder\Clauses;

class Skip implements IClause {

    private ?int $skip;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('SKIP %d', $this->skip);
    }

    public function reset(): void {

        $this->skip = null;
    }

    public final function getParameters(): array {

        return [];
    }

    public final function skip(int $skip): self {

        $this->skip = $skip;

        return $this;
    }
}
