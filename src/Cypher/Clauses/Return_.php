<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class Return_ extends Clause {

    /** @var array<string> */
    private array $items;

    public final function __construct(string ...$items) {

        parent::__construct();

        $this->items = [];

        foreach ($items as $item) {

            $this->addItem($item);
        }
    }

    public final function getQueryString(): string {

        return sprintf('RETURN %s', implode(', ', $this->items));
    }

    public final function addItem(string $item): self {

        if (!in_array($item, $this->items)) {

            $this->items[] = $item;
        }

        return $this;
    }
}
