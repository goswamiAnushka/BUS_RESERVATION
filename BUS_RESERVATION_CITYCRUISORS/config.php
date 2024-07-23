<?php
define("DB_SERVER", "sql304.infinityfree.com");
define("DB_USERNAME", "if0_36951682");
define("DB_PASSWORD", "aCztWA2z1Ygd");
define("DB_NAME", "if0_36951682_cistycruisers");

// Connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
