<?php
include ('config/pdoconfig.php');

if (!empty($_POST["custNom"])) {
    $id = $_POST['custNom'];
    $stmt = $DB_con->prepare("SELECT * FROM  clients WHERE nom_client = :id");
    $stmt->execute(array(':id' => $id));
    ?>

        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <?php echo htmlentities($row['identifiant_client']); ?>
            <?php
        }
}
