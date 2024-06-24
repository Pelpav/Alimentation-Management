<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
include ('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
    //Prevent Posting Blank Values

    if (empty($_POST["code_paiements"]) || empty($_POST["montant_paiements"]) || empty($_POST['methode_paiements'])) {
        $err = "Valeurs nulles non acceptées";
    } else {

        $code_paiements = $_POST['code_paiements'];
        $code_commande = $_GET['code_commande'];
        $identifiant_client = $_GET['identifiant_client'];
        $montant_paiements = $_POST['montant_paiements'];
        $methode_paiements = $_POST['methode_paiements'];
        $pay_id = $_POST['pay_id'];

        $statut_commande = $_GET['statut_commande'];

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO paiements (pay_id, code_paiements, code_commande, identifiant_client, montant_paiements, methode_paiements) VALUES(?,?,?,?,?,?)";
        $upQry = "UPDATE commandes SET statut_commande =? WHERE code_commande =?";

        $postStmt = $mysqli->prepare($postQuery);
        $upStmt = $mysqli->prepare($upQry);
        //bind paramaters

        $rc = $postStmt->bind_param('ssssss', $pay_id, $code_paiements, $code_commande, $identifiant_client, $montant_paiements, $methode_paiements);
        $rc = $upStmt->bind_param('ss', $statut_commande, $code_commande);

        $postStmt->execute();
        $upStmt->execute();
        //declare a varible which will be passed to alert function
        if ($upStmt && $postStmt) {
            $success = "Payé" && header("refresh:1; url=receipts.php");
        } else {
            $err = "Veuillez réessayer";
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
        $code_commande = $_GET['code_commande'];
        $ret = "SELECT * FROM  commandes WHERE code_commande ='$code_commande' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($order = $res->fetch_object()) {
            $total = ($order->prix_produit * $order->quantite_produit);

            ?>

                                <!-- Header -->
                                <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;"
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
                                                                <label>Paiment ID</label>
                                                                <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Code de Paiement</label>
                                                                <input type="text" name="code_paiements" value="<?php echo $mpesaCode; ?>"
                                                                    class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <label>Montant ( FCFA)</label>
                                                                <input type="text" name="montant_paiements" readonly value="<?php echo $total; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Méthode de Paiement</label>
                                                                <select class="form-control" name="methode_paiements">
                                                                    <option selected>Cash</option>
                                                                    <option>Paypal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <input type="submit" name="pay" value="Payer la commande"
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
        }
        ?>
</body>

</html>