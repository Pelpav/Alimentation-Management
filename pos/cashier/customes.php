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
                            <a href="add_customer.php" class="btn btn-outline-success">
                                <i class="fas fa-user-plus"></i>
                                Ajouter nouveau client
                            </a>
                            <label for="showIncomplete">
                                <input type="checkbox" id="showIncomplete" onclick="toggleIncompleteClients()">
                                Afficher les clients avec des champs manquants
                            </label>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Nom complet</th>
                                        <th scope="col">Numéro de Téléphone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="clientTableBody">
                                    <?php
                                    $ret = "SELECT * FROM  clients  ORDER BY `clients`.`creee_le` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($cust = $res->fetch_object()) {
                                        $incompleteClass = empty($cust->email_client) ? 'incomplete' : '';
                                    ?>
                                        <tr class="<?php echo $incompleteClass; ?>" style="<?php echo empty($cust->email_client) ? 'display: none;' : ''; ?>">
                                            <td>
                                                <?php echo $cust->nom_client; ?>
                                            </td>
                                            <td>
                                                <?php echo $cust->numero_client; ?>
                                            </td>
                                            <td>
                                                <?php echo $cust->email_client; ?>
                                            </td>
                                            <td>
                                                <a href="orders.php?client_id=<?php echo $cust->identifiant_client; ?>" class="btn btn-sm btn-success">
                                                    <i class="fas fa-cart-plus"></i>
                                                    Ajouter une commande
                                                </a>

                                                <a href="update_customer.php?update=<?php echo $cust->identifiant_client; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-user-edit"></i>
                                                        Modifier
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

    <script>
        function toggleIncompleteClients() {
            var checkbox = document.getElementById('showIncomplete');
            var rows = document.querySelectorAll('#clientTableBody tr.incomplete');
            rows.forEach(function(row) {
                row.style.display = checkbox.checked ? 'table-row' : 'none';
            });
        }
    </script>
</body>

</html>