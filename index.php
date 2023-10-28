<?php

require 'src/orm.php';
$orm = new Orm();
$tableName = 'barang';
$orm->init($tableName);
