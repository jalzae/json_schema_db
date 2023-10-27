<?php
// New data to be added to the JSON file
$newData = [
    "id" => "Hello",
    "name" => "Hello",
    "category" => "Hello"
];

$filePath = 'data.json';

// Read the existing JSON content
$existingData = json_decode(file_get_contents($filePath), true);

if ($existingData === null) {
    $existingData = [];
}

// Add the new data to the existing data array
$existingData[] = $newData;

// Encode the combined data and write it back to the file
$jsonData = json_encode($existingData, JSON_PRETTY_PRINT);
file_put_contents($filePath, $jsonData);

echo "New data added successfully.";
