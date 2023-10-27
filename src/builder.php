<?php

class QueryBuilder
{
  private $table;
  private $select = '*';
  private $where = [];
  private $orWhere = [];
  private $like = [];
  private $orLike = [];
  private $whereIn = [];
  private $groupBy = [];
  private $orderBy = [];
  private $join = [];
  private $insertValues = [];
  private $updateValues = [];
  private $deleteFlag = false;
  private $limit;
  private $offset;

  public function table($name)
  {
    $this->table = $name;
    return $this;
  }

  public function select($columns)
  {
    $this->select = $columns;
    return $this;
  }

  public function where($column, $value)
  {
    $this->where[] = "$column = '$value'";
    return $this;
  }

  public function orWhere($column, $value)
  {
    $this->orWhere[] = "$column = '$value'";
    return $this;
  }

  public function like($column, $value)
  {
    $this->like[] = "$column LIKE '$value'";
    return $this;
  }

  public function orLike($column, $value)
  {
    $this->orLike[] = "$column LIKE '$value'";
    return $this;
  }

  public function whereIn($column, $values)
  {
    $values = implode("', '", $values);
    $this->whereIn[] = "$column IN ('$values')";
    return $this;
  }

  public function groupBy($columns)
  {
    $this->groupBy = is_array($columns) ? $columns : [$columns];
    return $this;
  }

  public function orderBy($column, $direction = 'ASC')
  {
    $this->orderBy[] = "$column $direction";
    return $this;
  }

  public function insert($data)
  {
    $this->insertValues = $data;
    return $this;
  }

  public function update($data)
  {
    $this->updateValues = $data;
    return $this;
  }

  public function delete()
  {
    $this->deleteFlag = true;
    return $this;
  }

  public function limit($limit)
  {
    $this->limit = $limit;
    return $this;
  }

  public function offset($offset)
  {
    $this->offset = $offset;
    return $this;
  }

  public function countAll()
  {
    $countQuery = "SELECT COUNT(*) as count FROM {$this->table}";

    // Apply the same conditions as in the main query
    $selectQuery = "SELECT $this->select FROM {$this->table}";

    if (!empty($this->join)) {
      $selectQuery .= ' ' . implode(' ', $this->join);
    }

    if (!empty($this->where)) {
      $selectQuery .= " WHERE " . implode(' AND ', $this->where);
    }
    if (!empty($this->orWhere)) {
      $selectQuery .= " OR " . implode(' OR ', $this->orWhere);
    }
    if (!empty($this->like)) {
      $selectQuery .= " WHERE " . implode(' AND ', $this->like);
    }
    if (!empty($this->orLike)) {
      $selectQuery .= " OR " . implode(' OR ', $this->orLike);
    }
    if (!empty($this->whereIn)) {
      $selectQuery .= " WHERE " . implode(' AND ', $this->whereIn);
    }

    if (!empty($this->groupBy)) {
      $selectQuery .= " GROUP BY " . implode(', ', $this->groupBy);
    }

    if (!empty($this->orderBy)) {
      $selectQuery .= " ORDER BY " . implode(', ', $this->orderBy);
    }

    if ($this->limit) {
      $selectQuery .= " LIMIT " . $this->limit;
    }

    if ($this->offset) {
      $selectQuery .= " OFFSET " . $this->offset;
    }

    // Combine the subquery with the main query
    return "$countQuery";
  }

  public function get()
  {
    if ($this->deleteFlag) {
      $query = "DELETE FROM {$this->table}";
    } elseif (!empty($this->updateValues)) {
      $query = "UPDATE {$this->table} SET ";
      $set = [];
      foreach ($this->updateValues as $column => $value) {
        $set[] = "$column = '$value'";
      }
      $query .= implode(', ', $set);
    } else {
      $query = "SELECT $this->select FROM {$this->table}";
    }

    if (!empty($this->join)) {
      $query .= ' ' . implode(' ', $this->join);
    }

    if (!empty($this->where)) {
      $query .= " WHERE " . implode(' AND ', $this->where);
    }
    if (!empty($this->orWhere)) {
      $query .= " OR " . implode(' OR ', $this->orWhere);
    }
    if (!empty($this->like)) {
      $query .= " WHERE " . implode(' AND ', $this->like);
    }
    if (!empty($this->orLike)) {
      $query .= " OR " . implode(' OR ', $this->orLike);
    }
    if (!empty($this->whereIn)) {
      $query .= " WHERE " . implode(' AND ', $this->whereIn);
    }

    if (!empty($this->groupBy)) {
      $query .= " GROUP BY " . implode(', ', $this->groupBy);
    }

    if (!empty($this->orderBy)) {
      $query .= " ORDER BY " . implode(', ', $this->orderBy);
    }

    if ($this->limit) {
      $query .= " LIMIT " . $this->limit;
    }

    if ($this->offset) {
      $query .= " OFFSET " . $this->offset;
    }

    return $query;
  }
}
