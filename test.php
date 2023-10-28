<?php

require 'crud.php';
$orm = new QueryBuild();
$tableName = 'barang';

$data = $orm->put($tableName, ['id' => 1, 'name' => 'test', 'category' => 'B']);
$data = $orm->read($tableName);
print_r($data);
die();
