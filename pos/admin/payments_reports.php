<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
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
                        <div class="card-header border-0">
                            Rapport de Ventes
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Code de Paiement</th>
                                        <th scope="col">Méthode de Paiement</th>
                                        <th class="text-success" scope="col">Code De Commande</th>
                                        <th scope="col">Montant payé</th>
                                        <th class="text-success" scope="col">Date de paiement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $ret = "SELECT p.code_commande, p.methode_paiements, p.code_paiements, SUM(p.montant_paiements) AS montant_total, p.creee_le
                                    //         FROM paiements p
                                    //         JOIN commandes c ON p.code_commande = c.code_commande
                                    //         JOIN clients cl ON c.identifiant_client = cl.identifiant_client
                                    //         GROUP BY p.code_commande, p.methode_paiements, p.code_paiements, p.creee_le
                                    //         ORDER BY p.creee_le DESC";
                                    $ret = "SELECT * from paiements";
                                    $stmt = $mysqli->prepare($ret);

                                    // Vérifiez la préparation de la requête SQL
                                    if ($stmt === false) {
                                        echo "Erreur de préparation de la requête : " . $mysqli->error;
                                    } else {
                                        $stmt->execute();
                                        $res = $stmt->get_result();

                                        // Vérifiez si des résultats ont été retournés
                                        if ($res->num_rows > 0) {
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
                                    <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Aucun résultat trouvé</td></tr>";
                                        }
                                    }
                                    ?>
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