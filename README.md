# Neo4j - Query Builder

**Neo4j Query Builder for PHP**

- [Neo4j - Query Builder](#neo4j---query-builder)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Create Cypher Query](#create-cypher-query)
    - [Adding Clauses to Cypher Query](#adding-clauses-to-cypher-query)

***

## Installation

Install *neo4j-query-builder* via Composer:

```bash
composer require ali-eltaweel/neo4j-query-builder
```

## Usage

### Create Cypher Query

```php
$query = new Neo4jQueryBuilder\Cypher\CypherQuery();
```

### Adding Clauses to Cypher Query

```php
$query->addClause($create = new Neo4jQueryBuilder\Cypher\Clauses\Create());
```
