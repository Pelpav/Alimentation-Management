<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="MartDevelopers Inc">
    <title>Alimentation Point Of Sale </title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/img/icons/site.webmanifest">
    <link rel="mask-icon" href="assets/img/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="assets/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.js"></script>
    <style>
        body {
            margin-top: 20px;
        }
    </style>
</head>
</style>
<?php
$code_commande = $_GET['code_commande'];
$ret = "SELECT c.code_commande, cl.nom_client, p.nom_produit, p.prix_produit, cp.quantite, c.creee_le
        FROM commandes c
        JOIN clients cl ON c.identifiant_client = cl.identifiant_client
        JOIN commande_produit cp ON c.identifiant_commande = cp.identifiant_commande
        JOIN produits p ON cp.identifiant_produit = p.identifiant_produit
        WHERE c.code_commande = ?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('s', $code_commande);
$stmt->execute();
$res = $stmt->get_result();

require_once('partials/_head.php');

?>

<body>
    <div class="container">
        <div class="row">
            <div id="Reçu" class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong>Technolab Suite</strong>
                            <br>
                            Sotuba
                            <br>
                            Juste après le pont
                            <br>
                            (+223) 63-19-84-46
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>Date:
                                <?php
                                $order = $res->fetch_object();
                                echo strftime('%d %B %Y à %Hh%M', strtotime($order->creee_le));
                                ?>
                            </em>
                        </p>
                        <p>
                            <em class="text-success">Reçu #:
                                <?php echo $order->code_commande; ?>
                            </em>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <h2>Reçu</h2>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Element</th>
                                <th>Quantité</th>
                                <th class="text-center">Prix Unitaire</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_general = 0;
                            $stmt->execute(); // Réexécuter la requête pour réinitialiser le curseur
                            $res = $stmt->get_result();
                            while ($order = $res->fetch_object()) {
                                $total = ($order->prix_produit * $order->quantite);
                                $total_general += $total;
                                $nom_produit = explode(' – ', $order->nom_produit);
                            ?>
                                <tr>
                                    <td class="col-md-9"><em><?php echo $order->nom_produit; ?></em></td>
                                    <td class="col-md-1" style="text-align: center"><?php echo $order->quantite; ?></td>
                                    <td class="col-md-1 text-center"><?php echo $order->prix_produit; ?> FCFA</td>
                                    <td class="col-md-1 text-center"><?php echo $total; ?> FCFA</td>
                                </tr>

                            <?php } ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td class="text-right">
                                    <h4><strong>Total: </strong></h4>
                                </td>
                                <td class="text-center text-danger">
                                    <h4><strong><?php echo $total_general; ?> FCFA</strong></h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <button id="print" onclick="printContent('Reçu');" class="btn btn-success btn-lg text-justify btn-block">
                    Imprimer <span class="fas fa-print"></span>
                </button>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
