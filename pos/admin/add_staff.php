<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
include ('config/code-generator.php');

check_login();
//Add Staff
if (isset($_POST['addStaff'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["numero_employee"]) || empty($_POST["nom_employee"]) || empty($_POST['email_employee']) || empty($_POST['motdepasse_employee'])) {
        $err = "Valeurs nulles non acceptées";
    } else {
        $numero_employee = $_POST['numero_employee'];
        $nom_employee = $_POST['nom_employee'];
        $email_employee = $_POST['email_employee'];
        $motdepasse_employee = sha1(md5($_POST['motdepasse_employee']));

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO employee (numero_employee, nom_employee, email_employee, motdepasse_employee) VALUES(?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ssss', $numero_employee, $nom_employee, $email_employee, $motdepasse_employee);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Staff Ajouté" && header("refresh:1; url=hrm.php");
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
                            <form method="POST">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Numéro du Personnel</label>
                                        <input type="text" name="numero_employee" class="form-control"
                                            value="<?php echo $alpha; ?>-<?php echo $beta; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Staff Nom</label>
                                        <input type="text" name="nom_employee" class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Staff Email</label>
                                        <input type="email" name="email_employee" class="form-control" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Staff Mot de passe</label>
                                        <input type="password" name="motdepasse_employee" class="form-control" value="">
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="addStaff" value="Add Staff" class="btn btn-success"
                                            value="">
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
    ?>
</body>

</html>