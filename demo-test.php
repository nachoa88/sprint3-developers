<?php

require_once './config/db.inc.php'; // adjust the path to the Db.php file if needed

$db = new Db();
$database = $db->getConnection();

// Check connection
try {
    // Ping command is used to check if the database is still available.
    $database->command(['ping' => 1]);
    echo "Connection successful: Able to run query against the database.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}