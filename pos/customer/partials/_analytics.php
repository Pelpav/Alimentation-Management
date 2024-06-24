<?php
//Global variables
$identifiant_client = $_SESSION['identifiant_client'];

//1. Mes commandes
$query = "SELECT COUNT(*) FROM `commandes` WHERE identifiant_client =  '$identifiant_client' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

//3. Available Produits
$query = "SELECT COUNT(*) FROM `produits` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

//4.Mes paiements
$query = "SELECT SUM(montant_paiements) FROM `paiements` WHERE identifiant_client = '$identifiant_client' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();
