<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
check_login();
//Supprimer Staff
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $adn = "DELETE FROM  employee  WHERE  identifiant_employee = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Supprimé" && header("refresh:1; url=hrm.php");
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
                            <a href="add_staff.php" class="btn btn-outline-success"><i
                                    class="fas fa-user-plus"></i>Ajouter nouveau
                                staff</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Numéro du Personnel</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  employee ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($staff = $res->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $staff->numero_employee; ?>
                                                </td>
                                                <td>
                                                    <?php echo $staff->nom_employee; ?>
                                                </td>
                                                <td>
                                                    <?php echo $staff->email_employee; ?>
                                                </td>
                                                <td>
                                                    <a href="hrm.php?delete=<?php echo $staff->identifiant_employee; ?>">
                                                        <button class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Supprimer
                                                        </button>
                                                    </a>

                                                    <a
                                                        href="update_staff.php?update=<?php echo $staff->identifiant_employee; ?>">
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