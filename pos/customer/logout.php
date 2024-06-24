<?php
session_start();
unset($_SESSION['identifiant_client']);
session_destroy();
header("Location: ../../index.php");
exit;
