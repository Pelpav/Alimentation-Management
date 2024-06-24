<?php
session_start();
unset($_SESSION['identifiant_admin']);
session_destroy();
header("Location: ../../index.php");
exit;
