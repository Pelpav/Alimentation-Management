<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
require_once('partials/_analytics.php');
?>
<!-- For more projects: Visit NetGO+  -->

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
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <a href="orders.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Elements disponibles</h5>
                        <span class="h2 font-weight-bold mb-0">
                          <?php echo $products; ?>
                        </span>
                      </div><!-- For more projects: Visit NetGO+  -->
                      <div class="col-auto">
                        <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                          <i class="fas fa-utensils"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div><!-- For more projects: Visit NetGO+  -->
            <div class="col-xl-4 col-lg-6">
              <a href="orders_reports.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Commandes</h5>
                        <span class="h2 font-weight-bold mb-0">
                          <?php echo $orders; ?>
                        </span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                          <i class="fas fa-shopping-cart"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a><!-- For more projects: Visit NetGO+  -->
            </div>
            <div class="col-xl-4 col-lg-6">
              <a href="payments_reports.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total d'argent dépensé</h5>
                        <span class="h2 font-weight-bold mb-0">
                          <?php if ($sales) {
                            echo $sales;
                          } else {
                            $sales = 0;
                            echo $sales;
                          } ?> FCFA
                        </span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                          <i class="fas fa-wallet"></i>
                        </div>
                      </div><!-- For more projects: Visit NetGO+  -->
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div><!-- For more projects: Visit NetGO+  -->
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Commandes récentes</h3>
                </div>
                <div class="col text-right">
                  <a href="orders_reports.php" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr><!-- For more projects: Visit NetGO+  -->
                    <th class="text-success" scope="col">Code</th>
                    <th scope="col">Client</th>
                    <th class="text-success" scope="col">Produit</th>
                    <th scope="col">Prix Unitaire</th>
                    <th class="text-success" scope="col">#</th>
                    <th scope="col">Prix Total</th>
                    <th scop="col">Status</th>
                    <th class="text-success" scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $identifiant_client = $_SESSION['identifiant_client'];
                  $ret = "SELECT * FROM  commandes WHERE identifiant_client = '$identifiant_client' ORDER BY `commandes`.`creee_le` DESC LIMIT 10 ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $total = ($order->prix_produit * $order->quantite_produit);

                  ?>
                    <tr>
                      <th class="text-success" scope="row">
                        <?php echo $order->code_commande; ?>
                      </th>
                      <td>
                        <?php echo $order->nom_client; ?>
                      </td>
                      <td class="text-success">
                        <?php echo $order->nom_produit; ?>
                      </td>
                      <td>
                        <?php echo $order->prix_produit; ?> FCFA
                      </td>
                      <td class="text-success">
                        <?php echo $order->quantite_produit; ?>
                      </td>
                      <td>
                        <?php echo $total; ?> FCFA
                      </td>
                      <td>
                        <?php if ($order->statut_commande == '') {
                          echo "<span class='badge badge-danger'>Not Payé</span>";
                        } else {
                          echo "<span class='badge badge-success'>$order->statut_commande</span>";
                        } ?>
                      </td>
                      <td class="text-success">
                        <?php echo date('d/M/Y g:i', strtotime($order->creee_le)); ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- For more projects: Visit NetGO+  -->
      <div class="row mt-5">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Mes paiements récents</h3>
                </div>
                <div class="col text-right">
                  <a href="payments_reports.php" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success" scope="col">Code</th>
                    <th scope="col">Montant</th>
                    <th class='text-success' scope="col">Code De Paiement</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM   paiements WHERE identifiant_client ='$identifiant_client'   ORDER BY `paiements`.`creee_le` DESC LIMIT 10 ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($payment = $res->fetch_object()) {
                  ?>
                    <tr>
                      <th class="text-success" scope="row">
                        <?php echo $payment->code_paiements; ?>
                      </th>
                      <td>
                        $
                        <?php echo $payment->montant_paiements; ?>
                      </td>
                      <td class='text-success'>
                        <?php echo $payment->code_commande; ?>
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
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>
<!-- For more projects: Visit NetGO+  -->

</html>