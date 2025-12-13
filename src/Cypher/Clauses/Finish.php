<?php

namespace Neo4jQueryBuilder\Cypher\Clauses;

final class Finish extends Clause {

    public final function getQueryString(): string {

        return 'FINISH';
    }
}
