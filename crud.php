<?php

class QueryBuild
{
  private $root;
  public function __construct()
  {
    $this->root = 'assets/';
  }

  public function read(string $table)
  {
    try {
      if (file_exists($this->root . $table . '/data.json')) {
        $data = file_get_contents($this->root . $table . '/data.json');
        return ($data);
      } else {
        throw new Exception('Table not found');
      }
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function readOne(string $table, array $where)
  {
    try {
      $dataFile = $this->root . $table . '/data.json';

      if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);

        if ($data === null) {
          throw new Exception('Failed to decode JSON data');
        }

        // Iterate through the data to find the matching item
        foreach ($data as $item) {
          $matches = true;

          // Check if the item matches the conditions specified in the $where array
          foreach ($where as $field => $value) {
            if (!isset($item[$field]) || $item[$field] !== $value) {
              $matches = false;
              break; // No need to check further if one condition fails
            }
          }

          if ($matches) {
            // If an item matches all conditions, return it
            return json_encode($item, JSON_PRETTY_PRINT);
          }
        }

        // If no item matches the conditions, throw an exception
        throw new Exception('Item not found');
      } else {
        throw new Exception('Table not found');
      }
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }


  public function update(string $table, array $set, array $where)
  {
    try {
      $dataFile = $this->root . $table . '/data.json';

      if (file_exists($dataFile)) {
        // Read the existing data from 'data.json'
        $data = json_decode(file_get_contents($dataFile), true);

        if ($data === null) {
          throw new Exception('Failed to decode JSON data');
        }

        $found = false;

        foreach ($data as $key => $item) {
          $matches = true;

          // Check if the item matches the conditions specified in the WHERE clause
          foreach ($where as $field => $value) {
            if (!isset($item[$field]) || $item[$field] !== $value) {
              $matches = false;
              break; // No need to check further if one condition fails
            }
          }

          if ($matches) {
            // Update the item with the new values specified in the SET clause
            foreach ($set as $field => $value) {
              $data[$key][$field] = $value;
            }
            $found = true;
          }
        }

        if (!$found) {
          throw new Exception('Item not found');
        }

        // Encode the updated data back to JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Write the updated data back to 'data.json'
        file_put_contents($dataFile, $jsonData);

        return 'Item(s) updated successfully';
      } else {
        throw new Exception('Table not found');
      }
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }


  public function insert(string $table, array $newValue)
  {
    try {
      $dataFile = $this->root . $table . '/data.json';

      if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);

        if ($data === null) {
          throw new Exception('Failed to decode JSON data');
        }

        $data[] = $newValue;
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);


        file_put_contents($dataFile, $jsonData);

        return $jsonData;
      } else {
        throw new Exception('Table not found');
      }
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  public function delete(string $table, $where)
  {
    try {
      $dataFile = $this->root . $table . '/data.json';

      if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);

        if ($data === null) {
          throw new Exception('Failed to decode JSON data');
        }

        $found = false;

        foreach ($data as $key => $item) {
          $matches = true;

          foreach ($where as $field => $value) {
            if (!isset($item[$field]) || $item[$field] !== $value) {
              $matches = false;
              break;
            }
          }

          if ($matches) {
            unset($data[$key]);
            $found = true;
          }
        }

        if (!$found) {
          throw new Exception('Item not found');
        }

        // Re-index the array to remove any gaps from deleted items
        $data = array_values($data);

        // Encode the updated data back to JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Write the updated data back to 'data.json'
        file_put_contents($dataFile, $jsonData);

        return 'Item(s) deleted successfully';
      } else {
        throw new Exception('Table not found');
      }
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
}
