<?php

function execute($sql_file_path, $database_name){
    $mysqli = new mysqli("localhost", "root", "", $database_name);
// Database connection

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Path to your SQL file
$sql_file = $sql_file_path;
$sql_handle = fopen($sql_file, 'r');

// Read the SQL file line by line
$batch_size = 20;  // Set how many records to insert at a time
$batch_count = 0;  // Counter for batches
$query_buffer = "";  // Buffer to store queries

while (!feof($sql_handle)) {
    $line = fgets($sql_handle);

    // Replace INSERT INTO with INSERT IGNORE INTO to ignore duplicate errors
    $line = str_replace("INSERT INTO", "INSERT IGNORE INTO", $line);

    // Add the line to the query buffer
    $query_buffer .= $line;

    // Look for the end of the INSERT statement
    if (strpos($line, ");") !== false) {
        $batch_count++;

        // If we have reached the batch size, execute the query
        if ($batch_count >= $batch_size) {
            // Execute the current batch
            if (!$mysqli->multi_query($query_buffer)) {
                echo "Error: " . $mysqli->error;
                break;
            }

            // Process the results (for multi_query, even for non-SELECT queries)
            do {
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
            } while ($mysqli->more_results() && $mysqli->next_result());

            // Reset for the next batch
            $batch_count = 0;
            $query_buffer = "";
        }
    }
}

// Execute any remaining queries in the buffer
if (!empty($query_buffer)) {
    if (!$mysqli->multi_query($query_buffer)) {
        echo "Error: " . $mysqli->error;
    }

    // Process any remaining results
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
}

fclose($sql_handle);
$mysqli->close();
}
// Database connection
