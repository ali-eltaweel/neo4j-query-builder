<?php

namespace Neo4jQueryBuilder\Clauses;

use Stringable;

class Delete implements Stringable {

    private array $elements;
    
    private bool $detach;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return sprintf('%sDELETE %s', $this->detach ? 'DETACH ' : '', implode(', ', $this->elements));
    }

    public function reset(): void {

        $this->elements = [];
        $this->detach   = false;
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

    public final function detach(): self {

        $this->detach = true;

        return $this;
    }
}
