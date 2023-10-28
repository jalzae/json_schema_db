<?php
// Create global.json
$globalData = [
  "database_name" => "YourDatabase",
  "created_at" => "2023-10-30",
  "description" => "Your JSON Database",
  "version" => "1.0",
  "update_at" => "2023-11-15",
  "count" => 2
];
file_put_contents('global.json', json_encode($globalData));

// Create schema.json
$schemaData = [
  "data" => [
    "fields" => ["id", "name", "category"],
    "primary_key" => "id"
  ],
  "index" => [
    "name" => [],
    "category" => []
  ]
];
file_put_contents('schema.json', json_encode($schemaData));

// Create data.json (insert your data records here)
// $data = [
// "1" => ["id" => 1, "name" => "Item 1", "category" => "Category A"],
// "2" => ["id" => 2, "name" => "Item 2", "category" => "Category B"]
// ];

// file_put_contents('data.json', json_encode($data));

// Read data.json
$jsonData = json_decode(file_get_contents('data.json'), true);
// Read existing data from data.json
// $existingData = json_decode(file_get_contents('data.json'), true);

// Add new data (for example, a new record with ID 3)
$newData = [
  "id" => 3,
  "name" => "Item 3",
  "category" => "Category B"
];

// Append the new data to the existing data
$jsonData[] = $newData;

// Write the updated data back to data.json
file_put_contents('data.json', json_encode($jsonData, JSON_PRETTY_PRINT));


// Search for records with "category B"
$categoryBRecords = array_filter($jsonData, function ($record) {
  return $record['category'] === 'Category B';
});

// $categoryBRecords now contains records with "category B"
print_r($categoryBRecords);
