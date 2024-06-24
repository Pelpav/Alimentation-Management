<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM produits WHERE identifiant_produit = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Supprimé" && header("refresh:1; url=products.php");
    } else {
        $err = "Réessayer plus tard";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $productId = $_POST['productId'];
    $stockQty = $_POST['stockQty'];

    // Mettre à jour le stock dans la base de données
    $updateQuery = "UPDATE produits SET stock_produit = stock_produit + ? WHERE identifiant_produit = ?";
    $updateStmt = $mysqli->prepare($updateQuery);
    $updateStmt->bind_param('ss', $stockQty, $productId);
    $updateStmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);

    // Vérifiez si la mise à jour a réussi
    if ($updateStmt->affected_rows > 0) {
        $success = "Stock ajouté avec succès" && header("refresh:1; url=products.php");
    } else {
        $err = "Erreur lors de l'ajout de stock.";
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
                            <a href="add_product.php" class="btn btn-outline-success">
                                <i class="fas fa-utensils"></i>
                                Ajouter nouveau produit
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  produits ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($prod = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if ($prod->image_produit) {
                                                    echo "<img src='../../products/$prod->image_produit' height='60' width='60 class='img-thumbnail'>";
                                                } else {
                                                    echo "<img src='../../products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $prod->nom_produit; ?>
                                            </td>
                                            <td style="color: <?php echo $prod->stock_produit < 10 ? 'red' : 'green'; ?>">
                                                <?php echo $prod->stock_produit; ?>
                                            </td>
                                            <td>
                                                <?php echo $prod->prix_produit; ?> FCFA
                                            </td>

                                            <td>

                                                <a href="update_product.php?update=<?php echo $prod->identifiant_produit; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Modifier
                                                    </button>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-primary add-stock" data-id="<?php echo $prod->identifiant_produit; ?>">
                                                    <i class="fas fa-edit"></i>
                                                    Ajouter du stock
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


    <!-- Formulaire de confirmation pour ajouter du stock -->
    <div id="addStockModal" class="modal fade" tabindex="-1" role="dialog" action="" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter du stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addStockForm">
                    <div class="modal-body">
                        <input type="hidden" id="productId" name="productId">
                        <div class="form-group">
                            <label for="stockQty">Quantité à ajouter</label>
                            <input type="number" class="form-control" id="stockQty" name="stockQty" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handler pour le clic sur le bouton "Ajouter du stock"
            $(".add-stock").click(function() {
                // Récupérer l'identifiant du produit associé à ce bouton
                var productId = $(this).data('id');
                // Mettre à jour la valeur de l'input hidden avec l'identifiant du produit
                $("#productId").val(productId);
                // Afficher la fenêtre modale
                $("#addStockModal").modal('show');
            });

            // Handler pour la soumission du formulaire
            $("#addStockForm").submit(function(event) {
                event.preventDefault();
                var productId = $("#productId").val();
                var stockQty = $("#stockQty").val();
                // Envoyer les données au serveur pour traiter l'ajout de stock
                $.post("", { // Utiliser une chaîne vide pour envoyer la requête au même fichier
                    productId: productId,
                    stockQty: stockQty,
                }, function() {
                    // Recharger la page une fois que la requête est terminée
                    location.reload();
                });
            });
        });
    </script>

</body>

</html>