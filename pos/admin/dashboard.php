<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
require_once('partials/_analytics.php');
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
                    <!-- Card stats -->
                    <div class="row">

                        <div class="col-xl-3 col-lg-4">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Employés</h5>
                                            <span class="h2 font-weight-bold mb-0">
                                                <?php echo $staff; ?>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Produits</h5>
                                            <span class="h2 font-weight-bold mb-0">
                                                <?php echo $products; ?>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                                <i class="fas fa-utensils"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Commandes</h5>
                                            <span class="h2 font-weight-bold mb-0">
                                                <?php echo $orders; ?>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Ventes</h5>
                                            <span class="h2 font-weight-bold mb-0">
                                                <?php if ($sales) {
                                                    echo $sales;
                                                } else {
                                                    $sales = 0;
                                                    echo $sales;
                                                } ?> FCFA
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="container-fluid mt--7">
            <div class="row mt-5">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Commandes récentes</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="orders_reports.php" class="btn btn-sm btn-primary">Voir tout</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Code</th>
                                        <th scope="col">Client</th>
                                        <th class="text-success" scope="col">Produit</th>
                                        <th scope="col">Total</th>
                                        <th scop="col">Status</th>
                                        <th class="text-success" scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT c.code_commande, cl.nom_client, GROUP_CONCAT(p.nom_produit SEPARATOR ', ') AS produits, 
                                    SUM(p.prix_produit * cp.quantite) AS prix_total, c.statut_commande, c.creee_le 
                                    FROM commandes c
                                    JOIN clients cl ON c.identifiant_client = cl.identifiant_client
                                    JOIN commande_produit cp ON c.identifiant_commande = cp.identifiant_commande
                                    JOIN produits p ON cp.identifiant_produit = p.identifiant_produit
                                    GROUP BY c.code_commande, cl.nom_client, c.statut_commande, c.creee_le
                                    ORDER BY c.creee_le DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row">
                                                <?php echo $order->code_commande; ?>
                                            </th>
                                            <td>
                                                <?php echo $order->nom_client; ?>
                                            </td>
                                            <td class="text-success">
                                                <?php echo $order->produits; ?>
                                            </td>
                                            <td>
                                                <?php echo $order->prix_total; ?> FCFA
                                            </td>
                                            <td>
                                                <?php if ($order->statut_commande == '') {
                                                    echo "<span class='badge badge-danger'>Non Payé</span>";
                                                } else {
                                                    echo "<span class='badge badge-success'>$order->statut_commande</span>";
                                                } ?>
                                            </td>
                                            <td class="text-success">
                                                <?php echo strftime('%d %B %Y à %Hh%M', strtotime($order->creee_le)); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-xl-12">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Paiements récents</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="payments_reports.php" class="btn btn-sm btn-primary">Voir tout</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Code</th>
                                        <th scope="col">Montant</th>
                                        <th class='text-success' scope="col">Code De Paiement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM   paiements   ORDER BY `paiements`.`creee_le` DESC LIMIT 7 ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($payment = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row">
                                                <?php echo $payment->code_paiements; ?>
                                            </th>
                                            <td>
                                                
                                                <?php echo $payment->montant_paiements; ?> FCFA
                                            </td>
                                            <td class='text-success'>
                                                <?php echo $payment->code_commande; ?>
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
            <?php require_once('partials/_footer.php'); ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>