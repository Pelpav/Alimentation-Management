<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Annuler la commande
if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    $adn = "DELETE FROM  commandes  WHERE  identifiant_commande = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Supprimé" && header("refresh:1; url=payments.php");
    } else {
        $err = "Réessayer plus tard";
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
        ?>
        <!-- Header -->
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Client</th>
                                        <th class="text-success" scope="col">Produits</th>
                                        <th scope="col">Prix Total</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT c.code_commande, cl.nom_client, GROUP_CONCAT(p.nom_produit SEPARATOR ', ') AS produits, 
                                            SUM(p.prix_produit * cp.quantite) AS prix_total, c.creee_le, c.identifiant_commande, c.identifiant_client
                                            FROM commandes c
                                            JOIN clients cl ON c.identifiant_client = cl.identifiant_client
                                            JOIN commande_produit cp ON c.identifiant_commande = cp.identifiant_commande
                                            JOIN produits p ON cp.identifiant_produit = p.identifiant_produit
                                            WHERE c.statut_commande = ''
                                            GROUP BY c.code_commande, cl.nom_client, c.creee_le, c.identifiant_commande, c.identifiant_client
                                            ORDER BY c.creee_le DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $order->code_commande; ?></th>
                                            <td><?php echo $order->nom_client; ?></td>
                                            <td class="text-success"><?php echo $order->produits; ?></td>
                                            <td><?php echo $order->prix_total; ?> FCFA</td>
                                            <td><?php echo strftime('%d %B %Y à %Hh%M', strtotime($order->creee_le)); ?></td>
                                            <td>
                                                <a href="pay_order.php?identifiant_commande=<?php echo $order->identifiant_commande; ?>&identifiant_client=<?php echo $order->identifiant_client; ?>&statut_commande=Payé">
                                                    <button class="btn btn-sm btn-success">
                                                        <i class="fas fa-handshake"></i>
                                                        Payer la commande
                                                    </button>
                                                </a>
                                                <a href="payments.php?cancel=<?php echo $order->identifiant_commande; ?>">
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-window-close"></i>
                                                        Annuler la commande
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
    ?>
</body>

</html>