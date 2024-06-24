<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
include ('config/code-generator.php');

check_login();
if (isset($_POST['addProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code_produit"]) || empty($_POST["nom_produit"]) || empty($_POST['description_produit']) || empty($_POST['prix_produit'])) {
    $err = "Valeurs nulles non acceptées";
  } else {
    $identifiant_produit = $_POST['identifiant_produit'];
    $code_produit = $_POST['code_produit'];
    $nom_produit = $_POST['nom_produit'];
    $stock_produit = $_POST['stock_produit'];
    $image_produit = $_FILES['image_produit']['name'];
    move_uploaded_file($_FILES["image_produit"]["tmp_name"], "../../products/" . $_FILES["image_produit"]["name"]);
    $description_produit = $_POST['description_produit'];
    $prix_produit = $_POST['prix_produit'];


    $postQuery = "INSERT INTO produits (identifiant_produit, code_produit, nom_produit, image_produit, description_produit, prix_produit, stock_produit) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $postStmt = $mysqli->prepare($postQuery);

    // Vérifiez si la préparation de la requête a réussi
    if ($postStmt === false) {
      die("Erreur de préparation de la requête : " . $mysqli->error);
    }

    // Liaison des paramètres
    $rc = $postStmt->bind_param('sssssss', $identifiant_produit, $code_produit, $nom_produit, $image_produit, $description_produit, $prix_produit, $stock_produit);

    // Vérifiez si la liaison des paramètres a réussi
    if ($rc === false) {
      die("Erreur de liaison des paramètres : " . $postStmt->error);
    }

    // Exécution de la requête
    $postStmt->execute();

    // Vérifiez si l'exécution de la requête a réussi
    if ($postStmt->affected_rows > 0) {
      echo "Données insérées avec succès.";
    } else {
      echo "Erreur lors de l'insertion des données : " . $postStmt->error;
    }
    if ($postStmt) {
      $success = "Produit Ajouté" && header("refresh:1; url=add_product.php");
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
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Produit Nom</label>
                    <input type="text" name="nom_produit" class="form-control">
                    <input type="hidden" name="identifiant_produit" value="<?php echo $identifiant_produit; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Produit Code</label>
                    <input type="text" name="code_produit" value="<?php echo $alpha; ?>-<?php echo $beta; ?>"
                      class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-4">
                    <label>Produit Image</label>
                    <input type="file" name="image_produit" class="btn btn-outline-success form-control" value="">
                  </div>
                  <div class="col-md-4">
                    <label>Produit Prix</label>
                    <input type="number" name="prix_produit" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-12">
                    <label>Produit Description</label>
                    <textarea rows="5" name="description_produit" class="form-control" value=""></textarea>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addProduct" value="Add Produit" class="btn btn-success" value="">
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