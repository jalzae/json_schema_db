<?php
require 'src/builder.php';
// Usage
$queryBuilder = new QueryBuilder();
$result = $queryBuilder->table('users')->like('id',1)->get();
echo $result;
