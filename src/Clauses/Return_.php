<?php

namespace Neo4jQueryBuilder\Clauses;

use Stringable;

class Return_ implements Stringable {

    private array $elements;
    
    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('RETURN %s', implode(', ', $this->elements));
    }

    public function reset(): void {

        $this->elements = [];
    }

    public final function element(string $alias): self {

        $this->elements[] = $alias;

        return $this;
    }

    public final function elements(array $aliases): self {

        foreach ($aliases as $alias) {

            $this->elements[] = $alias;
        }

        return $this;
    }
}
