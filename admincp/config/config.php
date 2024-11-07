<?php
// Database connection variables
$host = "ep-dry-tree-a4025s4m.us-east-1.aws.neon.tech";
$dbname = "verceldb";
$user = "default";
$password = "BOqb3QaDuNC7";
$port = "5432";
$sslmode = "require";

try {
    // Set up a new PDO connection for PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode", $user, $password);

    // Set error mode to exceptions for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch (PDOException $e) {
    echo "Failed to connect to PostgreSQL: " . $e->getMessage();
    exit();
}
?>
