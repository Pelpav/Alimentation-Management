<?php
//1. Clients
$query = "SELECT COUNT(*) FROM `clients` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($customers);
$stmt->fetch();
$stmt->close();

//2. Commandes
$query = "SELECT COUNT(*) FROM `commandes` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

//3. Commandes
$query = "SELECT COUNT(*) FROM `produits` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

//4.Ventes
$query = "SELECT SUM(montant_paiements) FROM `paiements` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();
