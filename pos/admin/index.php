<?php
session_start();
include ('config/config.php');
//login 
if (isset($_POST['login'])) {
    $email_admin = $_POST['email_admin'];
    $motdepasse_admin = sha1(md5($_POST['motdepasse_admin'])); //double encrypt to increase security
    $stmt = $mysqli->prepare("SELECT email_admin, motdepasse_admin, identifiant_admin  FROM   admin WHERE (email_admin =? AND motdepasse_admin =?)"); //sql to Se connecter user
    $stmt->bind_param('ss', $email_admin, $motdepasse_admin); //bind fetched parameters
    $stmt->execute(); //execute bind 
    $stmt->bind_result($email_admin, $motdepasse_admin, $identifiant_admin); //bind result
    $rs = $stmt->fetch();
    $_SESSION['identifiant_admin'] = $identifiant_admin;
    if ($rs) {
        //if its sucessfull

        header("location:dashboard.php");
    } else {
        $err = "Incorrect Authentication Credentials ";
    }
}
require_once ('partials/_head.php');
?>

<body class="bg-dark">
    <div class="main-content">
        <div class="header bg-gradient-primar py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Système de Ventes de Produits</h1>
                            <h3 class="text-white">Admin</h3>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form method="post" role="form">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" required name="email_admin" placeholder="Email"
                                            type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="motdepasse_admin"
                                            placeholder="Mot de passe" type="password">
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span class="text-muted">Se rappeler de moi</span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="login" class="btn btn-primary my-4">Connexion</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="forgot_pwd.php" class="text-light"><small>Mot de passe oublié?</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php
    require_once ('partials/_footer.php');
    ?>
    <!-- Argon Scripts -->
    <?php
    require_once ('partials/_scripts.php');
    ?>
</body>

</html>