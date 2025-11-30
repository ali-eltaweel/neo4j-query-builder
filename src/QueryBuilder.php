<?php

namespace Neo4jQueryBuilder;

use Closure;
use Stringable;

class QueryBuilder implements Stringable {

    private array $cluases;

    public function __construct() {

        $this->reset();
    }

    public final function __toString(): string {

        return implode("\n", $this->cluases);
    }

    public function reset(): void {

        $this->cluases = [];
    }

    public final function create(?Closure $callback = null): Clauses\Create {

        $create = $this->cluases[] = new Clauses\Create();

        if (!is_null($callback)) {

            $callback($create);
        }

        return $create;
    }

    public final function delete(?Closure $callback = null): Clauses\Delete {

        $delete = $this->cluases[] = new Clauses\Delete();

        if (!is_null($callback)) {

            $callback($delete);
        }

        return $delete;
    }

    public final function match(?Closure $callback = null): Clauses\Match_ {

        $match = $this->cluases[] = new Clauses\Match_();

        if (!is_null($callback)) {

            $callback($match);
        }

        return $match;
    }

    public final function where(?Closure $callback = null): Clauses\Where {

        $where = $this->cluases[] = new Clauses\Where();

        if (!is_null($callback)) {

            $callback($where);
        }

        return $where;
    }

    public final function return(?Closure $callback = null): Clauses\Return_ {

        $return = $this->cluases[] = new Clauses\Return_();

        if (!is_null($callback)) {

            $callback($return);
        }

        return $return;
    }

    public final function orderBy(?Closure $callback = null): Clauses\OrderBy {

        $orderBy = $this->cluases[] = new Clauses\OrderBy();

        if (!is_null($callback)) {

            $callback($orderBy);
        }

        return $orderBy;
    }

    public final function set(?Closure $callback = null): Clauses\Set {

        $set = $this->cluases[] = new Clauses\Set();

        if (!is_null($callback)) {

            $callback($set);
        }

        return $set;
    }

    public final function remove(?Closure $callback = null): Clauses\Remove {

        $remove = $this->cluases[] = new Clauses\Remove();

        if (!is_null($callback)) {

            $callback($remove);
        }

        return $remove;
    }

    public final function limit(int $limit): self {

        $this->cluases[] = (new Clauses\Limit())->limit($limit);

        return $this;
    }

    public final function skip(int $skip): self {

        $this->cluases[] = (new Clauses\Skip())->skip($skip);

        return $this;
    }
}
