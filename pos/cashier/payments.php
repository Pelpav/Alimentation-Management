<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
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
                            <a href="orders.php" class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> <i class="fas fa-utensils"></i>
                                Faire une nouvelle commande
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Produit</th>
                                        <th scope="col">Prix Total</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  commandes WHERE statut_commande =''  ORDER BY `commandes`.`creee_le` DESC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = ($order->prix_produit * $order->quantite_produit);

                                        ?>
                                                    <tr>
                                                        <th class="text-success" scope="row">
                                                            <?php echo $order->code_commande; ?>
                                                        </th>
                                                        <td>
                                                            <?php echo $order->nom_client; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $order->nom_produit; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $total; ?> FCFA
                                                        </td>
                                                        <td>
                                                            <?php echo strftime('%d %B %Y à %Hh%M', strtotime($order->creee_le)); ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="pay_order.php?code_commande=<?php echo $order->code_commande; ?>&identifiant_client=<?php echo $order->identifiant_client; ?>&statut_commande=Payé">
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