<?php
require 'src/builder.php';
// Usage
$queryBuilder = new QueryBuilder();
$result = $queryBuilder->table('users')->get();
echo $result;