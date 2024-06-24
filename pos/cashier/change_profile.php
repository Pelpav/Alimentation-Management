<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
check_login();
//Modifier Profile
if (isset($_POST['ChangeProfile'])) {
    $identifiant_employee = $_SESSION['identifiant_employee'];
    $nom_employee = $_POST['nom_employee'];
    $email_employee = $_POST['email_employee'];
    $Qry = "UPDATE employee SET nom_employee =?, email_employee =? WHERE identifiant_employee =?";
    $postStmt = $mysqli->prepare($Qry);
    //bind paramaters
    $rc = $postStmt->bind_param('ssi', $nom_employee, $email_employee, $identifiant_employee);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
        $success = "Compte mis à jour" && header("refresh:1; url=dashboard.php");
    } else {
        $err = "Veuillez réessayer";
    }
}
if (isset($_POST['changePassword'])) {

    //Change Mot de passe
    $error = 0;
    if (isset($_POST['old_password']) && !empty($_POST['old_password'])) {
        $old_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['old_password']))));
    } else {
        $error = 1;
        $err = "Ancien mot de passe ne peut pas être vide";
    }
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
    } else {
        $error = 1;
        $err = "Nouveau mot de passe ne peut pas être vide";
    }
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
    } else {
        $error = 1;
        $err = "Mot de passe de confirmation ne peut pas être vide";
    }

    if (!$error) {
        $identifiant_employee = $_SESSION['identifiant_employee'];
        $sql = "SELECT * FROM employee   WHERE identifiant_employee = '$identifiant_employee'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($old_password != $row['motdepasse_employee']) {
                $err = "Corrigez votre ancien mot de passe";
            } elseif ($new_password != $confirm_password) {
                $err = "Mots de passe différents";
            } else {

                $new_password = sha1(md5($_POST['new_password']));
                //Insert Captured information to a database table
                $query = "UPDATE employee SET  motdepasse_employee =? WHERE identifiant_employee =?";
                $stmt = $mysqli->prepare($query);
                //bind paramaters
                $rc = $stmt->bind_param('si', $new_password, $identifiant_employee);
                $stmt->execute();

                //declare a varible which will be passed to alert function
                if ($stmt) {
                    $success = "Mot de passe Changed" && header("refresh:1; url=dashboard.php");
                } else {
                    $err = "Veuillez réessayer";
                }
            }
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
        $identifiant_employee = $_SESSION['identifiant_employee'];
        //$login_id = $_SESSION['login_id'];
        $ret = "SELECT * FROM  employee  WHERE identifiant_employee = '$identifiant_employee'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($staff = $res->fetch_object()) {
            ?>
            <!-- Header -->
            <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
                style="min-height: 600px; background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
                <!-- Mask -->
                <span class="mask bg-gradient-default opacity-8"></span>
                <!-- Header container -->
                <div class="container-fluid d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-7 col-md-10">
                            <h1 class="display-2 text-white">Salut
                                <?php echo $staff->nom_employee; ?>
                            </h1>
                            <p class="text-white mt-0 mb-5">C'est ta page de profil. Tu peux le personnaliser comme
                                tu le souhaites et aussi changer ton mot de passe</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container-fluid mt--8">
                <div class="row">
                    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3 order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="#">
                                            <img src="../admin/assets/img/theme/user-a-min.png" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                                <div class="d-flex justify-content-between">
                                </div>
                            </div>
                            <div class="card-body pt-0 pt-md-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                            <div>
                                            </div>
                                            <div>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3>
                                        <?php echo $staff->nom_employee; ?></span>
                                    </h3>
                                    <div class="h5 font-weight-300">
                                        <i class="ni location_pin mr-2"></i>
                                        <?php echo $staff->email_employee; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Mon compte</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <h6 class="heading-small text-muted mb-4">Informations Utilisateur</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-username">User Nom</label>
                                                    <input type="text" name="nom_employee"
                                                        value="<?php echo $staff->nom_employee; ?>" id=" input-username"
                                                        class="form-control form-control-alternative" ">
                                                                                                                                        </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="
                                                    col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="input-email">Email
                                                            address</label>
                                                        <input type="email" id="input-email"
                                                            value="<?php echo $staff->email_employee; ?>"
                                                            name=" email_employee"
                                                            class="form-control form-control-alternative">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="submit" id="input-email" name="ChangeProfile"
                                                            class="btn btn-success form-control-alternative"
                                                            value="Soumettre"">
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </form>
                                                <hr>
                                                <form method =" post">
                                                        <h6 class="heading-small text-muted mb-4">Change Mot de passe</h6>
                                                        <div class="pl-lg-4">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-control-label"
                                                                            for="input-username">Ancien Mot de passe</label>
                                                                        <input type="password" name="old_password"
                                                                            id="input-username"
                                                                            class="form-control form-control-alternative">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-control-label"
                                                                            for="input-email">Nouveau Mot de passe</label>
                                                                        <input type="password" name="new_password"
                                                                            class="form-control form-control-alternative">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-control-label"
                                                                            for="input-email">Confirmer Nouveau Mot de
                                                                            passe</label>
                                                                        <input type="password" name="confirm_password"
                                                                            class="form-control form-control-alternative">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <input type="submit" id="input-email"
                                                                            name="changePassword"
                                                                            class="btn btn-success form-control-alternative"
                                                                            value="Change Mot de passe">
                                                                    </div>
                                                                </div>
                                                            </div>
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
        }
        ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once ('partials/_sidebar.php');
    ?>
</body>

</html>