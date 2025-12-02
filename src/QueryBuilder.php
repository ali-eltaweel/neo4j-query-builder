<?php

namespace Neo4jQueryBuilder;

use Neo4jQueryBuilder\Clauses\IClause;

use Closure;
use Stringable;

class QueryBuilder implements Stringable {

    /** @var Clauses\IClause[] */
    private array $clauses;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return implode("\n", $this->clauses);
    }

    public function reset(): void {

        $this->clauses = [];
    }

    public final function getParameters(): array {

        return array_reduce(
            $this->clauses,
            fn(array $carry, IClause $clause) => array_merge($carry, $clause->getParameters()),
            []
        );
    }

    public final function create(?Closure $callback = null): Clauses\Create {

        $create = $this->clauses[] = new Clauses\Create();

        if (!is_null($callback)) {

            $callback($create);
        }

        return $create;
    }

    public final function delete(?Closure $callback = null): Clauses\Delete {

        $delete = $this->clauses[] = new Clauses\Delete();

        if (!is_null($callback)) {

            $callback($delete);
        }

        return $delete;
    }

    public final function match(?Closure $callback = null): Clauses\Match_ {

        $match = $this->clauses[] = new Clauses\Match_();

        if (!is_null($callback)) {

            $callback($match);
        }

        return $match;
    }

    public final function where(?Closure $callback = null): Clauses\Where {

        $where = $this->clauses[] = new Clauses\Where();

        if (!is_null($callback)) {

            $callback($where);
        }

        return $where;
    }

    public final function return(?Closure $callback = null): Clauses\Return_ {

        $return = $this->clauses[] = new Clauses\Return_();

        if (!is_null($callback)) {

            $callback($return);
        }

        return $return;
    }

    public final function orderBy(?Closure $callback = null): Clauses\OrderBy {

        $orderBy = $this->clauses[] = new Clauses\OrderBy();

        if (!is_null($callback)) {

            $callback($orderBy);
        }

        return $orderBy;
    }

    public final function set(?Closure $callback = null): Clauses\Set {

        $set = $this->clauses[] = new Clauses\Set();

        if (!is_null($callback)) {

            $callback($set);
        }

        return $set;
    }

    public final function remove(?Closure $callback = null): Clauses\Remove {

        $remove = $this->clauses[] = new Clauses\Remove();

        if (!is_null($callback)) {

            $callback($remove);
        }

        return $remove;
    }

    public final function limit(int $limit): self {

        $this->clauses[] = (new Clauses\Limit())->limit($limit);

        return $this;
    }

    public final function skip(int $skip): self {

        $this->clauses[] = (new Clauses\Skip())->skip($skip);

        return $this;
    }
}
