<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();


// Initialiser un tableau vide pour stocker les produits sélectionnés
$selectedProducts = [];
// Vérifier si le formulaire a été soumis
if (isset($_POST['submit_order'])) {

    if (isset($_POST['client_non_enregistre']) && $_POST['client_non_enregistre'] == '1') {
        $identifiant_client = uniqid('client_');
        $nom_client = $_POST['nom_client'];
        $cree_le = date('Y-m-d H:i:s');

        // Insérer le client non enregistré dans la base de données
        $insertClientQuery = "INSERT INTO clients (identifiant_client, nom_client, creee_le) VALUES (?, ?, ?)";
        $insertClientStmt = $mysqli->prepare($insertClientQuery);
        if ($insertClientStmt === false) {
            die('Erreur de préparation de la requête : ' . htmlspecialchars($mysqli->error));
        }
        $insertClientStmt->bind_param('sss', $identifiant_client, $nom_client, $cree_le);
        $insertClientStmt->execute();
    } else {
        $identifiant_client = $_GET['client_id'];
    }
    // Parcourir les produits pour obtenir les quantités sélectionnées
    foreach ($_POST['quantite_produit'] as $identifiant_produit => $quantite) {
        // Récupérer les informations sur le produit
        $productQuery = "SELECT * FROM produits WHERE identifiant_produit = ?";
        $productStmt = $mysqli->prepare($productQuery);
        $productStmt->bind_param('s', $identifiant_produit);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        $prod = $productResult->fetch_object();

        // Vérifier si la quantité n'est pas vide ou nulle
        if ($quantite > $prod->stock_produit) {
            // Afficher un message d'erreur si la quantité demandée est supérieure au stock disponible
            $err = "La quantité demandée pour le produit {$prod->nom_produit} dépasse le stock disponible.";
            break;
        } else if (!empty($quantite)) {
            // Ajouter le produit et sa quantité au tableau des produits sélectionnés
            $selectedProducts[$identifiant_produit] = $quantite;
        }
    }

    // Vérifier s'il y a des produits sélectionnés et qu'il n'y a pas d'erreur
    if (empty($err) && !empty($selectedProducts)) {
        // Générer un identifiant de commande unique
        $identifiant_commande = uniqid('cmd_');

        // Insertion de la commande dans la table commandes
        $insertOrderQuery = "INSERT INTO commandes (identifiant_commande, code_commande, identifiant_client, statut_commande) VALUES (?, ?, ?, ?)";
        $insertOrderStmt = $mysqli->prepare($insertOrderQuery);
        $code_commande = "CODE_" . strtoupper(uniqid());
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
            $updateStockStmt->bind_param('ii', $quantite, $identifiant_produit);
            $updateStockStmt->execute();
        }

        // Afficher un message de succès
        $success = "Commande validée avec succès !";

        // Redirection vers la page de rapports des commandes
        header("Location: payments.php");
        exit();
    } else if (empty($selectedProducts)) {
        // Afficher un message d'erreur si aucun produit n'a été sélectionné
        $err = "Une erreur s'est produite.";
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

                        <div class="table-responsive">
                            <!-- Table -->
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow">
                                        <div class="card-header border-0">
                                            <?php if (isset($_GET['client_id']) || isset($_POST['client_non_enregistre'])) : ?>
                                                Sélectionnez les produits que le client souhaite acheter
                                            <?php else : ?>

                                            <?php endif; ?>
                                        </div>
                                        <div class="table-responsive">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="client_non_enregistre">
                                                        <input type="checkbox" id="client_non_enregistre" name="client_non_enregistre" value="1" onclick="toggleClientFields(this)">
                                                        Client non enregistré
                                                    </label>
                                                </div>
                                                <div class="form-group" id="client_fields" style="display: none;">
                                                    <label for="nom_client">Nom du client</label>
                                                    <input type="text" id="nom_client" name="nom_client" class="form-control">
                                                </div>
                                                <table class="table align-items-center table-flush">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col"><b>Image</b></th>
                                                            <th scope="col"><b>Nom</b></th>
                                                            <th scope="col"><b>Prix</b></th>
                                                            <th scope="col"><b>Stock</b></th>
                                                            <?php if (isset($_GET['client_id']) || isset($_POST['client_non_enregistre'])) : ?>
                                                                <th scope="col"><b></b></th>
                                                                <th scope="col" id="quantiteth" style="display: none;"><b>Quantité</b></th>
                                                            <?php else : ?>
                                                                <th scope="col"><b></b></th>
                                                                <th scope="col" id="quantiteth" style="display: none;"><b>Quantité</b></th>
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
                                                            $checkboxId = "checkbox_" . $prod->identifiant_produit;
                                                            $quantityId = "quantity_" . $prod->identifiant_produit;
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
                                                                        <input type="checkbox" id="<?php echo $checkboxId; ?>" name="selected_products[]" value="<?php echo $prod->identifiant_produit; ?>" onclick="toggleQuantity('<?php echo $checkboxId; ?>', '<?php echo $quantityId; ?>')">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" id="<?php echo $quantityId; ?>" name="quantite_produit[<?php echo $prod->identifiant_produit; ?>]" class="form-control" style="display: none;">
                                                                    </td>
                                                                <?php else : ?>
                                                                    <td>
                                                                        <input type="checkbox" id="<?php echo $checkboxId; ?>" name="selected_products[]" value="<?php echo $prod->identifiant_produit; ?>" style="display: none;" onclick="toggleQuantity('<?php echo $checkboxId; ?>', '<?php echo $quantityId; ?>')">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" id="<?php echo $quantityId; ?>" name="quantite_produit[<?php echo $prod->identifiant_produit; ?>]" class="form-control" style="display: none;">
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                                <?php if (isset($_GET['client_id'])) : ?>
                                                    <button type="submit" name="submit_order" class="btn btn-success">Valider la commande</button>
                                                <?php else : ?>
                                                    <button type="submit" name="submit_order" class="btn btn-success" style="display: none;">Valider la commande</button>
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

                        function toggleClientFields(checkbox) {
                            var clientFields = document.getElementById('client_fields');
                            var submitButton = document.querySelector('button[name="submit_order"]');
                            var quantityFields = document.querySelectorAll('input[name^="quantite_produit"]');
                            var checkboxFields = document.querySelectorAll('input[name="selected_products[]"]');
                            var nav = document.getElementById('quantiteth');

                            if (checkbox.checked) {
                                clientFields.style.display = 'block';
                                submitButton.style.display = 'block'; // Afficher le bouton de soumission

                                checkboxFields.forEach(function(checkbox) {
                                    checkbox.style.display = 'block';
                                });
                                if (checkboxFields.checked) {
                                    quantityFields.forEach(function(quantity) {
                                        quantity.style.display = 'block';
                                    });
                                }
                                nav.style.display = 'block';
                            } else {
                                clientFields.style.display = 'none';
                                submitButton.style.display = 'none'; // Masquer le bouton de soumission
                                quantityFields.forEach(function(quantity) {
                                    quantity.style.display = 'none';
                                    quantity.value = ''; // Effacer la valeur du champ quantité lorsqu'il est masqué
                                });
                                checkboxFields.forEach(function(checkbox) {
                                    checkbox.style.display = 'none';
                                });
                                nav.style.display = 'none';
                            }
                        }
                    </script>

</body>

</html>