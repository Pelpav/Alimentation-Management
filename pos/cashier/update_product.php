<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['UpdateProduct'])) {
  //Prévenir la publication de valeurs vides
  if (empty($_POST["code_produit"]) || empty($_POST["nom_produit"]) || empty($_POST['description_produit']) || empty($_POST['prix_produit'])) {
    $err = "Valeurs nulles non acceptées";
  } else {
    $update = $_GET['update'];
    $code_produit = $_POST['code_produit'];
    $nom_produit = $_POST['nom_produit'];

    // Vérifier si un fichier est téléchargé
    if (!empty($_FILES['image_produit']['name'])) {
      $image_produit = $_FILES['image_produit']['name'];
      move_uploaded_file($_FILES["image_produit"]["tmp_name"], "../../products/" . $_FILES["image_produit"]["name"]);
    } else {
      // Si aucun fichier n'est téléchargé, conserver l'image existante
      $ret = "SELECT image_produit FROM produits WHERE identifiant_produit = '$update' ";
      $stmt = $mysqli->prepare($ret);
      $stmt->execute();
      $stmt->bind_result($image_produit);
      $stmt->fetch();
      $stmt->close();
    }

    $description_produit = $_POST['description_produit'];
    $prix_produit = $_POST['prix_produit'];

    // Insérer les informations capturées dans une table de base de données
    $postQuery = "UPDATE produits SET code_produit = ?, nom_produit = ?, image_produit = ?, description_produit = ?, prix_produit = ? WHERE identifiant_produit = ?";
    $postStmt = $mysqli->prepare($postQuery);

    // Lié les paramètres
    $postStmt->bind_param('ssssss', $code_produit, $nom_produit, $image_produit, $description_produit, $prix_produit, $update);
    $postStmt->execute();

    // Déclarer une variable qui sera transmise à la fonction d'alerte
    if ($postStmt) {
      $success = "Produit mis à jour" && header("refresh:1; url=products.php");
    } else {
      $err = "Veuillez réessayer";
    }
  }
}
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
    $update = $_GET['update'];
    $ret = "SELECT * FROM  produits WHERE identifiant_produit = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
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
                <h3>Remplissez tous les champs</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Produit Nom</label>
                      <input type="text" value="<?php echo $prod->nom_produit; ?>" name="nom_produit" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Produit Code</label>
                      <input type="text" name="code_produit" value="<?php echo $prod->code_produit; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-4">
                      <label>Produit Image</label>
                      <input type="file" name="image_produit" class="btn btn-outline-success form-control" value="<?php echo $image_produit; ?>">
                    </div>
                    <div class="col-md-4">
                      <label>Produit Prix</label>
                      <input type="text" name="prix_produit" class="form-control" value="<?php echo $prod->prix_produit; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-12">
                      <label>Produit Description</label>
                      <textarea rows="5" name="description_produit" class="form-control" value=""><?php echo $prod->description_produit; ?></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="UpdateProduct" value="Update Produit" class="btn btn-success" value="">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>