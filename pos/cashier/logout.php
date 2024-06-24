<?php
session_start();
unset($_SESSION['identifiant_employee']);
session_destroy();
header("Location: ../../index.php");
exit;
