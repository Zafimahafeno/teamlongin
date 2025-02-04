<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Inclure les en-têtes et la barre latérale
include './includes/header.php';
include './includes/sidebar.php';

// Inclure le fichier de statistiques
// Vérifiez que ce fichier est dans le même répertoire que test_dashboard_pat.php

?>

<header>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./dist/css/responsive.css">
  <style>
    .stats-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
    }
    .chart-wrapper {
      flex: 1;
      min-width: 300px;
    }
    .stats-table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      font-family: Arial, sans-serif;
    }

    .stats-table th, .stats-table td {
      border: 1px solid #ccc;
      padding: 8px;
    }

    .stats-table th {
      background-color: #4a90e2;
      color: white;
    }

    .stats-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .stats-table tr:hover {
      background-color: #ddd;
    }

    @media screen and (max-width: 800px) {
      .stats-container {
        width: 100%;
      }
    }
  </style>
</header>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Bienvenue <?php echo $_SESSION['user_prenom']; ?></h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
    </ol>
  </section>
  
  <section class="content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h4>Résultat des sondages PAT</h4>
      </div>

      <!-- Votants Section -->
      <div class="col-md-3 col-xs-6">
        <a href="./view_gateway.php">
          <div class="media-box">
            <div class="media-icon">
              <i class="fa fa-users"></i> <span class="nombre_dash"><?php include './backend/totalVotantsPat.php'; ?></span>
            </div>
            <div class="media-info">
              <h5>Votants</h5>
            </div>
          </div>
        </a>
      </div>

      <!-- Favorables Section -->
      <div class="col-md-3 col-xs-6">
        <a href="liste_pat_favorable.php">
          <div class="media-box bg-green">
            <div class="media-icon">
              <i class="fa fa-thumbs-up"></i> <?php include('./backend/totalFavorablePat.php'); ?>
            </div>
            <div class="media-info">
              <h5>Favorables</h5>
            </div>
          </div>
        </a>
      </div>

      <!-- Opposants Section -->
      <div class="col-md-3 col-xs-6">
        <a href="liste_pat_opposant.php">
          <div class="media-box bg-sea">
            <div class="media-icon">
              <i class="fa fa-thumbs-down"></i> <?php include('./backend/totalOpposantPat.php'); ?>
            </div>
            <div class="media-info">
              <h5>Opposants</h5>
            </div>
          </div>
        </a>
      </div>

      <!-- Indécis Section -->
      <div class="col-md-3 col-xs-6">
        <a href="liste_pat_indecis.php">
          <div class="media-box bg-blue">
            <div class="media-icon">
              <i class="fa fa-meh"></i>  <?php include('./backend/totalIndecisPat.php'); ?>
            </div>
            <div class="media-info">
              <h5>Indécis</h5>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Tableau récapitulatif -->
    <div class="container-fluid">
      <div class="chart-wrapper">
        <div class="chart-container-table">
          <h3>Tableau récapitulatif</h3>  
          <table class="table stats-table table-striped">
            <thead>
              <tr>
                <th>Effectif</th>
                <th>Non traité</th>
                <th>Favorable</th>
                <th>Indécis</th>
                <th>Opposant</th>
                <th>% Non traité</th>
                <th>% Favorable</th>
                <th>% Indécis</th>
                <th>% Opposant</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $servername = "mysql-mahafeno.alwaysdata.net";
              $username = "mahafeno";
              $password = "antso0201";
              $dbname = "mahafeno_longin";

              $conn = new mysqli($servername, $username, $password, $dbname);

              // Vérification de la connexion
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              // Requête pour récupérer le nombre total des PAT
              $totalQuery = "
                  SELECT COUNT(*) AS totalPAT
                  FROM votant 
                  WHERE fonction = 'PAT'
              ";

              $totalResult = $conn->query($totalQuery);
              $totalPAT = 0; // Valeur par défaut si aucun résultat
              if ($totalResult->num_rows > 0) {
                  $totalRow = $totalResult->fetch_assoc();
                  $totalPAT = $totalRow['totalPAT']; // Total dynamique des PAT
              }

              // Requête pour récupérer les statistiques des votes pour le PAT
              $query = "
                  SELECT 
                      SUM(CASE WHEN intentionVote = 'favorable' THEN 1 ELSE 0 END) AS favorable,
                      SUM(CASE WHEN intentionVote = 'indécis' THEN 1 ELSE 0 END) AS indecis,
                      SUM(CASE WHEN intentionVote = 'Opposant' THEN 1 ELSE 0 END) AS opposant,
                      SUM(CASE WHEN intentionVote = 'Non traité' OR intentionVote = '' THEN 1 ELSE 0 END) AS nonTraite
                  FROM votant 
                  WHERE fonction = 'PAT'
              ";

              $result = $conn->query($query);

              if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();

                  $favorable = $row['favorable'];
                  $indecis = $row['indecis'];
                  $opposant = $row['opposant'];
                  $nonTraite = $row['nonTraite'];

                  // Calcul des pourcentages selon la règle de 10%
                  $basePourcentage = 10;

                  $pourcentageFavorable = ($favorable / $totalPAT) * $basePourcentage;
                  $pourcentageIndecis = ($indecis / $totalPAT) * $basePourcentage;
                  $pourcentageOpposant = ($opposant / $totalPAT) * $basePourcentage;
                  $pourcentageNonTraite = ($nonTraite / $totalPAT) * $basePourcentage;

                  // Affectation des valeurs à la variable $stats
                  $stats = array(
                      'totalPAT' => $totalPAT,
                      'favorable' => $favorable,
                      'indecis' => $indecis,
                      'opposant' => $opposant,
                      'nonTraite' => $nonTraite,
                      'pourcentageFavorable' => number_format($pourcentageFavorable, 2),
                      'pourcentageIndecis' => number_format($pourcentageIndecis, 2),
                      'pourcentageOpposant' => number_format($pourcentageOpposant, 2),
                      'pourcentageNonTraite' => number_format($pourcentageNonTraite, 2)
                  );
              } else {
                  echo "Aucune donnée trouvée.";
              }

              ?>

              <tr>
                <td><?= $stats['totalPAT'] ?></td>
                <td><?= $stats['nonTraite'] ?></td>
                <td><?= $stats['favorable'] ?></td>
                <td><?= $stats['indecis'] ?></td>
                <td><?= $stats['opposant'] ?></td>
                <td><?= $stats['pourcentageNonTraite'] ?>%</td>
                <td><?= $stats['pourcentageFavorable'] ?>%</td>
                <td><?= $stats['pourcentageIndecis'] ?>%</td>
                <td><?= $stats['pourcentageOpposant'] ?>%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php $conn->close(); ?>
  </section>
</div>

<?php include './includes/footer.php'; ?>
