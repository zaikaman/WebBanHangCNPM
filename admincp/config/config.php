<?php
// Database connection variables from the provided URL
$dsn = "pgsql:host=cd1goc44htrmfn.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com;port=5432;dbname=dav3lqsjounjo8";
$user = "u56e312a1lr0ld";
$password = "p72eafe3c2c7e3af2333278b52bd1311ed515810977a45c77f9ac715496cd0de2";
$sslmode = "require";

try {
    // Set up a new PDO connection for PostgreSQL
    $pdo = new PDO("$dsn;sslmode=$sslmode", $user, $password);

    // Set error mode to exceptions for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch (PDOException $e) {
    echo "Failed to connect to PostgreSQL: " . $e->getMessage();
    exit();
}
?>
