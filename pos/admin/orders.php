<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');

// Initialiser un tableau vide pour stocker les produits sélectionnés
$selectedProducts = [];

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit_order'])) {
    // Parcourir les produits pour obtenir les quantités sélectionnées
    foreach ($_POST['quantite_produit'] as $identifiant_produit => $quantite) {
        // Vérifier si la quantité n'est pas vide ou nulle
        if (!empty($quantite)) {
            // Ajouter le produit et sa quantité au tableau des produits sélectionnés
            $selectedProducts[$identifiant_produit] = $quantite;
        }
    }
    
    // Vérifier s'il y a des produits sélectionnés
    if (!empty($selectedProducts)) {

        // Insertion des produits sélectionnés dans la base de données
        foreach ($selectedProducts as $identifiant_produit => $quantite) {


            // Insérer la commande dans la table commande_produit
            $insertQuery = "INSERT INTO commande_produit (identifiant_commande, identifiant_produit, quantite) VALUES (?, ?, ?)";
            $insertStmt = $mysqli->prepare($insertQuery);

            // L'identifiant de la commande peut être généré ou provenir d'un autre endroit dans votre application
            $identifiant_commande = "GENERATE_YOUR_ORDER_ID"; // Remplacez ceci par l'identifiant de votre commande

            // Remplacez 'sss' par le type de données approprié pour chaque paramètre dans votre schéma
            $insertStmt->bind_param('sss', $identifiant_commande, $identifiant_produit, $quantite);
            $insertStmt->execute();
        }

        // Afficher un message de succès
        echo "<script>alert('Commande validée avec succès !');</script>";

        // Redirection vers la page de rapports des commandes
        header("Location: orders_reports.php");
        exit();
    } else {
        // Afficher un message d'erreur si aucun produit n'a été sélectionné
        echo "<script>alert('Veuillez sélectionner au moins un produit pour passer la commande.');</script>";
    }
}

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

                        <div class="table-responsive">
                            <!-- Table -->
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow">
                                        <div class="card-header border-0">
                                            <?php if (isset($_GET['client_id'])) : ?>
                                                Sélectionnez les produits que le client souhaite acheter
                                            <?php else : ?>
                                                Sélectionnez un produit pour faire une commande
                                            <?php endif; ?>
                                        </div>
                                        <div class="table-responsive">
                                            <form method="post">
                                                <table class="table align-items-center table-flush">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col"><b>Image</b></th>
                                                            <th scope="col"><b>Nom</b></th>
                                                            <th scope="col"><b>Prix</b></th>
                                                            <th scope="col"><b>Stock</b></th>
                                                            <?php if (isset($_GET['client_id'])) : ?>
                                                                <th scope="col"><b>Quantité</b></th>
                                                            <?php else : ?>
                                                                <th scope="col"><b>Action</b></th>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $ret = "SELECT * FROM produits ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute();
                                                        $res = $stmt->get_result();
                                                        while ($prod = $res->fetch_object()) :
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if ($prod->image_produit) : ?>
                                                                        <img src='../../products/<?php echo $prod->image_produit; ?>' height='60' width='60' class='img-thumbnail'>
                                                                    <?php else : ?>
                                                                        <img src='../../products/default.jpg' height='60' width='60' class='img-thumbnail'>
                                                                    <?php endif; ?>
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
                                                                <?php if (isset($_GET['client_id'])) : ?>
                                                                    <td>
                                                                        <input type="number" name="quantite_produit[<?php echo $prod->identifiant_produit; ?>]" class="form-control" value="">
                                                                    </td>
                                                                <?php else : ?>
                                                                    <td>
                                                                        <a href="make_order.php?identifiant_produit=<?php echo $prod->identifiant_produit; ?>&nom_produit=<?php echo $prod->nom_produit; ?>&prix_produit=<?php echo $prod->prix_produit; ?>">
                                                                            <button class="btn btn-sm btn-warning">
                                                                                <i class="fas fa-cart-plus"></i> Faire une commande
                                                                            </button>
                                                                        </a>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                                <?php if (isset($_GET['client_id'])) : ?>
                                                    <button type="submit" name="submit_order" class="btn btn-success">Valider la commande</button>
                                                <?php endif; ?>
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
</body>

</html>