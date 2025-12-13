<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class Remove extends Clause {

    private array $items;

    public final function __construct() {

        parent::__construct();

        $this->items = [];
    }

    public final function getQueryString(): string {

        $statement = 'REMOVE';

        foreach ($this->items as $item) {

            switch ($item['type']) {

                case 'property':

                    $statement .= sprintf(' %s.%s,', $item['object'], $item['property']);
                    
                    break;

                case 'label':

                    $statement .= sprintf(' %s:%s,', $item['alias'], $item['label']);
                    
                    break;
            }
        }

        return rtrim($statement, ',');
    }

    public final function property(string $object, string $property): self {

        $this->items[] = [
            'type'     => 'property',
            'object'   => $object,
            'property' => $property
        ];
        
        return $this;
    }

    public final function label(string $alias, string $label): self {

        $this->items[] = [
            'type'   => 'label',
            'alias'  => $alias,
            'label' => $label
        ];

        return $this;
    }
}
