<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
check_login();
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
                            Rapport de Ventes
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Code de Paiement</th>
                                        <th scope="col">Méthode de Paiement</th>
                                        <th class="text-success" scope="col">Code De Paiement</th>
                                        <th scope="col">Montant payé</th>
                                        <th class="text-success" scope="col">Date de paiement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $identifiant_client = $_SESSION['identifiant_client'];
                                    $ret = "SELECT * FROM  paiements WHERE identifiant_client ='$identifiant_client' ORDER BY `creee_le` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($payment = $res->fetch_object()) {
                                        ?>
                                        <tr>
                                            <th class="text-success" scope="row">
                                                <?php echo $payment->code_paiements; ?>
                                            </th>
                                            <th scope="row">
                                                <?php echo $payment->methode_paiements; ?>
                                            </th>
                                            <td class="text-success">
                                                <?php echo $payment->code_commande; ?>
                                            </td>
                                            <td>
                                                <?php echo $payment->montant_paiements; ?> FCFA
                                            </td>
                                            <td class="text-success">
                                                <?php echo date('d/M/Y g:i', strtotime($payment->creee_le)) ?>
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