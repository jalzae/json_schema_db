<?php 

class QueryBuilder {
    private $table;
    private $where;

    public function table($name) {
        $this->table = $name;
        return $this; // Return the current object for method chaining
    }

    public function where($condition) {
        $this->where = $condition;
        return $this; // Return the current object for method chaining
    }

    public function get() {
        // Perform the database query using $this->table and $this->where
        // This is where you'd implement your database interaction logic
        // For the sake of this example, we'll just return a string to represent the result
        $query = "SELECT * FROM {$this->table} WHERE {$this->where}";
        return $query;
    }
}



