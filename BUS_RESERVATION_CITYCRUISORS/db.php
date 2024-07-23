<?php
// db.php
$host = 'sql304.infinityfree.com'; // or IP address
$dbname = 'if0_36951682_cistycruisers';
$username = 'if0_36951682';
$password = 'aCztWA2z1Ygd';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
