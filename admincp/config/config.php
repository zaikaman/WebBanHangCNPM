<?php
// Database connection variables
$dsn = "mysql:host=o3iyl77734b9n3tg.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=vdgpk50m2yvb0v8o";
$user = "qpd8l97yha3kmm0y";
$password = "on8kor6fvgjukajv";

try {
    // Set up a new PDO connection for MySQL
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    exit();
}
?>
