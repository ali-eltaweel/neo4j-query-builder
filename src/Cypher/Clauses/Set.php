<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

use Neo4jQueryBuilder\Cypher\PropertiesMap;
use Neo4jQueryBuilder\Cypher\RawCypher;

final class Set extends Clause {

    private array $items;

    public final function __construct() {

        parent::__construct();

        $this->items = [];
    }

    public final function getQueryString(): string {

        $statement = 'SET';

        foreach ($this->items as $item) {

            switch ($item['type']) {

                case 'property':

                    $statement .= sprintf(
                        ' %s.%s = %s%s,',
                        $item['object'],
                        $item['property'],
                        $item['value'] instanceof RawCypher ? '' : '$',
                        $item['value']
                    );
                    
                    break;

                case 'properties':

                    $statement .= sprintf(
                        ' %s %s %s,',
                        $item['alias'],
                        match ($item['operation']) { 'replace' => '=', 'append' => '+=' },
                        $item['properties']
                    );
                    
                    break;

                case 'label':

                    $statement .= sprintf(' %s:%s,', $item['alias'], $item['label']);
                    
                    break;
            }
        }

        return rtrim($statement, ',');
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->items,
            fn (array $parameters, array $item) => array_merge(
                $parameters,
                ($value = $item['value'] ?? null) instanceof RawCypher ? $value->getParameters() : [],
                ($properties = $item['properties'] ?? null) instanceof PropertiesMap ? $properties->getParameters() : [],
            ),
            parent::getParameters()
        );
    }

    public final function property(string $object, string $property, mixed $value): self {

        if ($value instanceof RawCypher) {

            $this->items[] = [
                'type'     => 'property',
                'object'   => $object,
                'property' => $property,
                'value'    => $value
            ];

        } else {

            $this->addParameter($parameter = self::newParameter(), $value);
    
            $this->items[] = [
                'type'     => 'property',
                'object'   => $object,
                'property' => $property,
                'value'    => $parameter
            ];
        }
        
        return $this;
    }

    public final function replace(string $alias, PropertiesMap|array $properties): self {

        $this->items[] = [
            'type'       => 'properties',
            'operation'  => 'replace',
            'alias'      => $alias,
            'properties' => is_array($properties) ? new PropertiesMap($properties) : $properties
        ];

        return $this;
    }

    public final function append(string $alias, PropertiesMap|array $properties): self {

        $this->items[] = [
            'type'       => 'properties',
            'operation'  => 'append',
            'alias'      => $alias,
            'properties' => is_array($properties) ? new PropertiesMap($properties) : $properties
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
