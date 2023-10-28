<?php

require 'crud.php';
$orm = new QueryBuild();
$tableName = 'barang';

$data = $orm->readOne($tableName, ['id' => 2]);

print_r($data);
die();
