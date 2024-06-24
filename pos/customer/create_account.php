<?php
session_start();
include ('config/config.php');
//login 
if (isset($_POST['addCustomer'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["numero_client"]) || empty($_POST["nom_client"]) || empty($_POST['email_client']) || empty($_POST['motdepasse_client'])) {
        $err = "Valeurs nulles non acceptées";
    } else {
        $nom_client = $_POST['nom_client'];
        $numero_client = $_POST['numero_client'];
        $email_client = $_POST['email_client'];
        $motdepasse_client = sha1(md5($_POST['motdepasse_client'])); //Hash This 
        $identifiant_client = trim($_POST['identifiant_client']);

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO clients (identifiant_client, nom_client, numero_client, email_client, motdepasse_client) VALUES(?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sssss', $identifiant_client, $nom_client, $numero_client, $email_client, $motdepasse_client);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Client Account Created" && header("refresh:1; url=index.php");
        } else {
            $err = "Veuillez réessayer";
        }
    }
}
require_once ('partials/_head.php');
require_once ('config/code-generator.php');
?>

<body class="bg-dark">
    <div class="main-content">
        <div class="header bg-gradient-primar py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Alimentation Point Of Sale</h1>
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
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" required name="nom_client"
                                            placeholder="Nom complet" type="text">
                                        <input class="form-control" value="<?php echo $cus_id; ?>" required
                                            name="identifiant_client" type="hidden">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" required name="numero_client"
                                            placeholder="Numéro" type="text">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" required name="email_client" placeholder="Email"
                                            type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="motdepasse_client"
                                            placeholder="Mot de passe" type="password">
                                    </div>
                                </div>

                                <div class="text-center">
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="addCustomer" class="btn btn-primary my-4">Create
                                            Account</button>
                                        <a href="index.php" class=" btn btn-success pull-right">Se connecter</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="../admin/forgot_pwd.php" target="_blank" class="text-light"><small>Forgot
                                    password?</small></a>
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