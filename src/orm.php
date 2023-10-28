<?php

class Orm
{
  
  private $root;
  public function __construct()
  {
    $this->root = dirname(__DIR__) . '/assets/';
  }
  public function init(string $table)
  {
    //check if folder is exist or not
    //if not exist, make it
    if (!is_dir($this->root . $table)) {
      if (mkdir($this->root . $table, 0755, true)) {
        // Directory created successfully
        file_put_contents($this->root . $table . '/schema.json', file_get_contents('global.json'));
        file_put_contents($this->root . $table . '/data.json', json_encode([]));
        file_put_contents($this->root . $table . '/index.json', file_get_contents('index.json'));
      } else {
        // Failed to create the directory
        echo "Failed to create directory .";
      }
    }
  }
}
