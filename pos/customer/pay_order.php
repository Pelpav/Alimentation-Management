<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["code_paiements"]) || empty($_POST["montant_paiements"]) || empty($_POST['methode_paiements'])) {
        $err = "Valeurs nulles non acceptées";
    } else {
        // Vérifiez l'existence des clés dans $_GET
        if (!isset($_GET['identifiant_commande']) || !isset($_GET['identifiant_client']) || !isset($_GET['statut_commande'])) {
            $err = "Paramètres manquants dans l'URL";
        } else {
            $code_paiements = $_POST['code_paiements'];
            $identifiant_commande = $_GET['identifiant_commande'];
            $identifiant_client = $_GET['identifiant_client'];
            $montant_paiements = $_POST['montant_paiements'];
            $methode_paiements = $_POST['methode_paiements'];
            $pay_id = $_POST['pay_id'];
            $statut_commande = "Payé";
            $cree_le = date('Y-m-d H:i:s'); // Mettre le timestamp actuel

            try {
                //Insert Captured information to a database table
                $postQuery = "INSERT INTO paiements (pay_id, code_paiements, code_commande, identifiant_client, montant_paiements, methode_paiements, creee_le) VALUES(?,?,?,?,?,?,?)";
                $upQry = "UPDATE commandes SET statut_commande =? WHERE identifiant_commande =?";

                $postStmt = $pdo->prepare($postQuery);
                $upStmt = $pdo->prepare($upQry);

                //bind paramaters
                $postStmt->execute([$pay_id, $code_paiements, $identifiant_commande, $identifiant_client, $montant_paiements, $methode_paiements, $cree_le]);
                $upStmt->execute([$statut_commande, $identifiant_commande]);

                // Vérifiez si la mise à jour a réussi
                if ($upStmt->rowCount() > 0) {
                    $success = "Payé";
                    header("refresh:1; url=payments_reports.php");
                } else {
                    $err = "La mise à jour du statut de la commande a échoué.";
                }
            } catch (PDOException $e) {
                $err = "Erreur d'exécution : " . $e->getMessage();
            }
        }
    }
}
require_once('partials/_head.php');
?>

<body>
    <!-- Sidenav -->
    <?php
    require_once('partials/_sidebar.php');
    ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php
        require_once('partials/_topnav.php');
        $identifiant_commande = $_GET['identifiant_commande'];
        $ret = "SELECT c.identifiant_commande, cl.nom_client, SUM(p.prix_produit * cp.quantite) AS total, c.creee_le, c.identifiant_commande, c.identifiant_client
                FROM commandes c
                JOIN clients cl ON c.identifiant_client = cl.identifiant_client
                JOIN commande_produit cp ON c.identifiant_commande = cp.identifiant_commande
                JOIN produits p ON cp.identifiant_produit = p.identifiant_produit
                WHERE c.identifiant_commande = ?
                GROUP BY c.identifiant_commande, cl.nom_client, c.creee_le, c.identifiant_commande, c.identifiant_client";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('s', $identifiant_commande);
        $stmt->execute();
        $res = $stmt->get_result();
        $order = $res->fetch_object();
        if ($order) {
            $total = $order->total;
        ?>

            <!-- Header -->
            <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
                                            <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Code de Paiement</label>
                                            <input type="text" name="code_paiements" value="<?php echo $mpesaCode; ?>" class="form-control" value="">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Montant ( FCFA)</label>
                                            <input type="text" name="montant_paiements" readonly value="<?php echo $total; ?>" class="form-control">
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
                                            <input type="submit" name="pay" value="Payer la commande" class="btn btn-success" value="">
                                        </div>
                                    </div>
                                </form>
                                <?php if (isset($err)) {
                                    echo "<div class='alert alert-danger'>$err</div>";
                                } ?>
                                <?php if (isset($success)) {
                                    echo "<div class='alert alert-success'>$success</div>";
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <?php
                require_once('partials/_footer.php');
                ?>
            </div>
    </div>
    <!-- Argon Scripts -->
<?php
            require_once('partials/_scripts.php');
        }
?>
</body>

</html>