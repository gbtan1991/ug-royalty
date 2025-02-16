<?php
$dsn = 'mysql:host=localhost;dbname=ug_royalty';
$user = 'root';
$pass = '';

try {

    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>