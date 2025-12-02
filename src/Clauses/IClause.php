<?php

namespace Neo4jQueryBuilder\Clauses;

use Stringable;

interface IClause extends Stringable {
    
    public function getParameters(): array;
}
