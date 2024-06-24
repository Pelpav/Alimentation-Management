<?php
$dbuser = "tomglobalb";
$dbpass = "3PbDyeAhNS";
$host = "localhost";
$db = "tomglobalb_alimentation";
// Connexion MySQLi
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);

// Connexion PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion PDO : " . $e->getMessage();
}
?>