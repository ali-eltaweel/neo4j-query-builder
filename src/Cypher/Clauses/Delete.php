<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class Delete extends Clause {

    /** @var array<string> */
    private array $items;

    private bool $detach;

    public final function __construct(string ...$items) {

        parent::__construct();

        $this->items = [];
        $this->detach = false;

        foreach ($items as $item) {

            $this->addItem($item);
        }
    }

    public final function getQueryString(): string {

        return sprintf('DELETE%s %s', $this->detach ? ' DETACH' : '', implode(', ', $this->items));
    }

    public final function addItem(string $item): self {

        if (!in_array($item, $this->items)) {

            $this->items[] = $item;
        }

        return $this;
    }

    public final function detach(bool $value = true): self {

        $this->detach = $value;

        return $this;
    }
}
