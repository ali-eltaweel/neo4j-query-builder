<?php

namespace Neo4jQueryBuilder;

use Stringable;

abstract class ParameterGenerator implements Stringable {

    private static int $parameterCounter = 0;

    protected static final function generateParameterName(): string {

        return 'param_' . (++self::$parameterCounter);
    }
}
