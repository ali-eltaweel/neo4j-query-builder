<?php

namespace Neo4jQueryBuilder\Expressions;

use Neo4jQueryBuilder\ParameterGenerator;

abstract class Expression extends ParameterGenerator {

    public function __construct() {
        
        $this->reset();
    }

    public abstract function getParameters(): array;
    
    public abstract function reset(): void;
}
