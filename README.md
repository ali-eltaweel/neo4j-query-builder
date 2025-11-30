# Neo4j - Query Builder

**Neo4j Query Builder for PHP**

- [Neo4j - Query Builder](#neo4j---query-builder)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Creating Nodes](#creating-nodes)
    - [Creating Relationships](#creating-relationships)
    - [Creating Nodes and Relationships Together](#creating-nodes-and-relationships-together)
    - [Matching Nodes](#matching-nodes)
    - [Matching Relationships](#matching-relationships)
    - [Deleting Elements](#deleting-elements)
    - [Filtering Nodes and Relationships](#filtering-nodes-and-relationships)
    - [Returning Elements](#returning-elements)
    - [Updating Elements](#updating-elements)

***

## Installation

Install *neo4j-query-builder* via Composer:

```bash
composer require ali-eltaweel/neo4j-query-builder
```

## Usage

### Creating Nodes

Here is an example of how to create a node with the label `PERSON` and properties `name` and `age`:

```php
$q = new Neo4jQueryBuilder\QueryBuilder();

$q->create()->node()->alias('n')->label('PERSON')->properties([ 'name' => 'Alice', 'age' => 30 ]);

echo $q;
```

The previous code snippet will generate the following Cypher query:

> ```sql
> CREATE (n:PERSON { name: "Alice", age: 30 })
> ```

Creating multiple nodes in a single query can be done as follows:

```php
$q = new Neo4jQueryBuilder\QueryBuilder();

$q->create(function(Neo4jQueryBuilder\Clauses\Create $create) {
  
  $create->node()->alias('russell')->label('PLAYER')->properties([ 'name' => 'Russell Westbrook', 'age' => 33 ]);
  $create->node()->alias('lebron')->label('PLAYER')->properties([ 'name' => 'LeBron James', 'age' => 36 ]);
});
```

The above code will generate the following Cypher query:

> ```sql
> CREATE (russell:PLAYER { name: "Russell Westbrook", age: 33 }), (lebron:PLAYER { name: "LeBron James", age: 36 })
> ```

### Creating Relationships

The following example demonstrates how to create a relationship between two nodes:

```php
$q = new Neo4jQueryBuilder\QueryBuilder();

$q->create(function(Neo4jQueryBuilder\Clauses\Create $create) {

  $create->relationship(function(Neo4jQueryBuilder\RelationshipBuilder $relationship) {

    $relationship->from()->alias('russell');
    $relationship->to()->alias('lebron');

    $relationship->label('TEAMMATE_OF')->property('since', 2021);
  });
});
```

The above code will generate the following Cypher query:

> ```sql
> CREATE (russell)-[:TEAMMATE_OF { since: 2021 }]->(lebron)
> ```

### Creating Nodes and Relationships Together


```php
$q = new Neo4jQueryBuilder\QueryBuilder();

$q->create(function(Neo4jQueryBuilder\Clauses\Create $create) {

  $create->relationship(function(Neo4jQueryBuilder\RelationshipBuilder $relationship) {

    $relationship->from()->alias('russell')->label('PLAYER')->properties([ 'name' => 'Russell Westbrook', 'age' => 33 ]);
    $relationship->to()->alias('lebron')->label('PLAYER')->properties([ 'name' => 'LeBron James', 'age' => 36 ]);
    
    $relationship->label('TEAMMATE_OF')->property('since', 2021);
  });
});
```

> ```sql
> CREATE (russell:PLAYER { name: "Russell Westbrook", age: 33 })-[:TEAMMATE_OF { since: 2021 }]->(lebron:PLAYER { name: "LeBron James", age: 36 })
> ```

### Matching Nodes

```php
$q->match()->node()->alias('n');
```

> ```sql
> MATCH (n)
> ```

### Matching Relationships

```php
$q->match()->relationship(function(RelationshipBuilder $r) {

  $r->alias('r')->label('TEAMMATE_OF');
});
```

> ```sql
> MATCH ()-[r:TEAMMATE_OF]->()
> ```

### Deleting Elements

```php
$q->delete()->detach()->element('n');
```

> ```sql
> DETACH DELETE n
> ```

### Filtering Nodes and Relationships

```php
$q->match()->node()->alias('player')->label('PLAYER');
$q->where()->condition()->name('id(player)')->operator('=')->value(10);
```

> ```sql
> MATCH (player:PLAYER)
> WHERE id(player) = 10
> ```

```php
$q->match()->relationship()->alias('rel')->label('TEAMMATE_OF');
$q->where()->condition()->name('rel.since')->operator('=')->value(2021);
```

> ```sql
> MATCH ()-[rel:TEAMMATE_OF]->()
> WHERE rel.since = 2021
> ```

### Returning Elements

```php
$q->match()->node()->alias('n');
$q->return()->element('n');
```

> ```sql
> MATCH (n)
> RETURN n
> ```

### Updating Elements

```php
$q->match()->node()->alias('n');
$q->set()->expression('n.active = true');
$q->return()->element('n');
```

> ```sql
> MATCH (n)
> SET n.active = true
> RETURN n
> ```

```php
$q->match()->node()->alias('n');
$q->remove()->expression('n:REF');
$q->return()->element('n');
```

> ```sql
> MATCH (n)
> REMOVE n:REF
> RETURN n
> ```
