<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
include ('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {

    // Prevent Posting Blank Values
    if (empty($_POST["code_commande"]) || empty($_POST["nom_client"]) || empty($_GET['prix_produit']) || empty($_POST['quantite_produit'])) {
        $err = "Valeurs nulles non acceptées";
    } else {
        $identifiant_commande = $_POST['identifiant_commande'];
        $code_commande = $_POST['code_commande'];
        $identifiant_client = trim($_POST['identifiant_client']);
        $nom_client = $_POST['nom_client'];
        $identifiant_produit = $_GET['identifiant_produit'];
        $nom_produit = $_GET['nom_produit'];
        $prix_produit = $_GET['prix_produit'];
        $quantite_produit = $_POST['quantite_produit'];

        // Check if quantite_produit is less than or equal to stock_produit
        $checkQuery = "SELECT stock_produit FROM produits WHERE identifiant_produit = ?";
        $checkStmt = $mysqli->prepare($checkQuery);
        $checkStmt->bind_param('s', $identifiant_produit);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $product = $checkResult->fetch_assoc();

        if ($product && $quantite_produit <= $product['stock_produit']) {

            // Insert Captured information to a database table
            $postQuery = "INSERT INTO commandes (quantite_produit, identifiant_commande, code_commande, identifiant_client, nom_client, identifiant_produit, nom_produit, prix_produit) VALUES(?,?,?,?,?,?,?,?)";
            $postStmt = $mysqli->prepare($postQuery);
            // Bind parameters
            $rc = $postStmt->bind_param('ssssssss', $quantite_produit, $identifiant_commande, $code_commande, $identifiant_client, $nom_client, $identifiant_produit, $nom_produit, $prix_produit);
            $postStmt->execute();

            // Update stock_produit
            $updateQuery = "UPDATE produits SET stock_produit = stock_produit - ? WHERE identifiant_produit = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param('ss', $quantite_produit, $identifiant_produit);
            $updateStmt->execute();

            // Declare a variable which will be passed to alert function
            if ($postStmt) {
                $success = "Commande soumise" && header("refresh:1; url=payments.php");
            } else {
                $err = "Veuillez réessayer";
            }
        } else {
            $err = "La quantité commandée dépasse le stock disponible.";
        }
    }
}
require_once ('partials/_head.php');
?>

<body>
    <!-- Sidenav -->
    <?php
    require_once ('partials/_sidebar.php');
    ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php
        require_once ('partials/_topnav.php');
        ?>
        <!-- Header -->
        <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;"
            class="header  pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <h3>Remplissez tous les champs</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <label>Client Nom</label>
                                        <?php
                                        //Load All Clients
                                        $identifiant_client = $_SESSION['identifiant_client'];
                                        $ret = "SELECT * FROM  clients WHERE identifiant_client = '$identifiant_client' ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($cust = $res->fetch_object()) {
                                            ?>
                                                                    <input class="form-control" readonly name="nom_client"
                                                                        value="<?php echo $cust->nom_client; ?>">
                                        <?php } ?>
                                        <input type="hidden" name="identifiant_commande" value="<?php echo $orderid; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Code De Paiement</label>
                                        <input type="text" readonly name="code_commande"
                                            value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <hr>
                                <?php
                                $identifiant_produit = $_GET['identifiant_produit'];
                                $ret = "SELECT * FROM  produits WHERE identifiant_produit = '$identifiant_produit'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                    ?>
                                                            <div class="form-row">
                                                                <div class="col-md-6">
                                                                    <label>Produit Prix ( FCFA)</label>
                                                                    <input type="text" readonly name="prix_produit"
                                                                        value=" <?php echo $prod->prix_produit; ?> FCFA " class="form-control">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Produit Quantité</label>
                                                                    <input type="text" name="quantite_produit" class="form-control" value="">
                                                                </div>
                                                            </div>
                                <?php } ?>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="make" value="Faire une commande"
                                            class="btn btn-success" value="">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php
            require_once ('partials/_footer.php');
            ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once ('partials/_scripts.php');
    ?>
</body>

</html>