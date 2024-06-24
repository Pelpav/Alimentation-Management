<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
include ('config/code-generator.php');

check_login();

//Add Client
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
            $success = "Client ajouté" && header("refresh:1; url=customes.php");
        } else {
            $err = "Veuillez réssayer";
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
                                        <label>Client Nom</label>
                                        <input type="text" name="nom_client" class="form-control">
                                        <input type="hidden" name="identifiant_client" value="<?php echo $cus_id; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Client Numéro</label>
                                        <input type="text" name="numero_client" class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Client Email</label>
                                        <input type="email" name="email_client" class="form-control" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Client Mot de passe</label>
                                        <input type="password" name="motdepasse_client" class="form-control" value="">
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="addCustomer" value="Add Client"
                                            class="btn btn-success" value="">
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