<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();


// Initialiser un tableau vide pour stocker les produits sélectionnés
$selectedProducts = [];

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit_order'])) {
  // Parcourir les produits pour obtenir les quantités sélectionnées
  foreach ($_POST['quantite_produit'] as $identifiant_produit => $quantite) {
    // Vérifier si la quantité n'est pas vide ou nulle
    // Récupérer les informations du produit depuis la base de données
    $query = "SELECT * FROM produits WHERE identifiant_produit = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $identifiant_produit);
    $stmt->execute();
    $result = $stmt->get_result();
    $prod = $result->fetch_object();
    if ($quantite > $prod->stock_produit) {
      // Afficher un message d'erreur si la quantité demandée est supérieure au stock disponible
      $err = "La quantité demandée pour le produit {$prod->nom_produit} dépasse le stock disponible.";
      break;
    } else if (!empty($quantite)) {
      // Ajouter le produit et sa quantité au tableau des produits sélectionnés
      $selectedProducts[$identifiant_produit] = $quantite;
    }
  }

  // Vérifier s'il y a des produits sélectionnés
  if (!empty($selectedProducts)) {
    // Générer un identifiant de commande unique
    $identifiant_commande = uniqid('cmd_');

    // Insertion de la commande dans la table commandes
    $insertOrderQuery = "INSERT INTO commandes (identifiant_commande, code_commande, identifiant_client, statut_commande) VALUES (?, ?, ?, ?)";
    $insertOrderStmt = $mysqli->prepare($insertOrderQuery);
    $code_commande = "CODE_" . strtoupper(uniqid());
    $identifiant_client = $_SESSION['identifiant_client']; // Utiliser l'ID du client de la session
    $statut_commande = "";
    $insertOrderStmt->bind_param('ssss', $identifiant_commande, $code_commande, $identifiant_client, $statut_commande);
    $insertOrderStmt->execute();

    // Insertion des produits sélectionnés dans la table commande_produit
    foreach ($selectedProducts as $identifiant_produit => $quantite) {
      // Insérer chaque produit dans la table commande_produit
      $insertQuery = "INSERT INTO commande_produit (identifiant_commande, identifiant_produit, quantite) VALUES (?, ?, ?)";
      $insertStmt = $mysqli->prepare($insertQuery);
      $insertStmt->bind_param('sss', $identifiant_commande, $identifiant_produit, $quantite);
      $insertStmt->execute();
      // Mettre à jour le stock du produit
      $updateStockQuery = "UPDATE produits SET stock_produit = stock_produit - ? WHERE identifiant_produit = ?";
      $updateStockStmt = $mysqli->prepare($updateStockQuery);
      $updateStockStmt->bind_param('is', $quantite, $identifiant_produit);
      $updateStockStmt->execute();
    }

    // Afficher un message de succès
    $success = "Commande validée avec succès !";

    // Redirection vers la page de rapports des commandes
    header("Location: payments.php");
    exit();
  } else {
    // Afficher un message d'erreur si aucun produit n'a été sélectionné
    $err = "Une erreur s'est produite";
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
    ?>
    <!-- Header -->
    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
              Sélectionne un produit pour faire une commande
            </div>
            <div class="table-responsive">
              <form method="post">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Image</th>
                      <th scope="col">Nom</th>
                      <th scope="col">Prix</th>
                      <th scope="col">Stock</th>
                      <th scope="col"><b></b></th>
                      <th scope="col" id="quantiteth" style="display: none;"><b>Quantité</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT * FROM produits ORDER BY `produits`.`creee_le` DESC";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($prod = $res->fetch_object()) {
                      $checkboxId = "checkbox_" . $prod->identifiant_produit;
                      $quantityId = "quantity_" . $prod->identifiant_produit;
                    ?>
                      <tr>
                        <td>
                          <?php
                          if ($prod->image_produit) {
                            echo "<img src='../../products/$prod->image_produit' height='60' width='60' class='img-thumbnail'>";
                          } else {
                            echo "<img src='../../products/default.jpg' height='60' width='60' class='img-thumbnail'>";
                          }
                          ?>
                        </td>
                        <td>
                          <?php echo $prod->nom_produit; ?>
                        </td>
                        <td>
                          <?php echo $prod->prix_produit; ?> FCFA
                        </td>
                        <td>
                          <?php echo $prod->stock_produit; ?>
                        </td>
                        <td>
                          <input type="checkbox" id="<?php echo $checkboxId; ?>" name="selected_products[]" value="<?php echo $prod->identifiant_produit; ?>" onclick="toggleQuantity('<?php echo $checkboxId; ?>', '<?php echo $quantityId; ?>')">
                        </td>
                        <td>
                          <input type="number" id="<?php echo $quantityId; ?>" name="quantite_produit[<?php echo $prod->identifiant_produit; ?>]" class="form-control" style="display: none;">
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <button type="submit" name="submit_order" class="btn btn-success">Valider la commande</button>
              </form>
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
    function toggleQuantity(checkboxId, quantityId) {
      var checkbox = document.getElementById(checkboxId);
      var nav = document.getElementById('quantiteth');
      var quantity = document.getElementById(quantityId);
      if (checkbox.checked) {
        quantity.style.display = 'block';
        nav.style.display = 'block';
      } else {
        quantity.style.display = 'none';
        nav.style.display = 'none';
        quantity.value = ''; // Effacer la valeur du champ quantité lorsqu'il est masqué
      }
    }
  </script>

</body>

</html>