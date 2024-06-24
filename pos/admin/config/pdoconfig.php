<?php
$DB_host = "localhost";
$DB_user = "tomglobalb";
$DB_pass = "3PbDyeAhNS";
$DB_name = "tomglobalb_alimentation";
try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $e->getMessage();
}
?>
