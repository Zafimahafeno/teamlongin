<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

include './includes/header.php';
include './includes/sidebar.php';
include './backend/statTotal.php';
?>

<header>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./dist/css/responsive.css">
  <style>
      .chart-container {
          position: relative;
          margin: 20px 0;
          height: 400px;
          background: #fff;
          padding: 15px;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }
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
      .chart-title {
          text-align: center;
          margin-bottom: 15px;
          color: #333;
          font-weight: bold;
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
      .chart-container-table {
          position: relative;
          margin: 20px 0;
          height: 250px;
          background: #fff;
          padding: 15px;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
          overflow-y: scroll;
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
    <h1>BIENVENUE <?php echo $_SESSION['user_prenom']; ?></h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
    </ol>
  </section>

  <section class="content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h4>Résultat des sondages</h4>
      </div>
      <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-3 col-xs-6">
        <a href="./view_gateway.php">
          <div class="media-box">
            <div class="media-icon">
              <i class="fa fa-users"></i> <span class="nombre_dash"> <?php include 'totalVotants.php'; ?></span>
            </div>
            <div class="media-info">
              <h5>Votants</h5>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-3 col-xs-6">
        <a href="./listeNonTraite.php">
          <div class="media-box" style="background-color: #607D8B; color: white;">
            <div class="media-icon">
              <i class="fa fa-hourglass-half"></i> <?php include('./backend/totalNonTraite.php'); ?>
            </div>
            <div class="media-info">
              <h5>Non traité</h5>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-3 col-xs-6">
        <a href="favorable.php">
          <div class="media-box bg-green">
            <div class="media-icon">
              <i class="fa fa-thumbs-up"></i> <?php include('totalFavorable.php'); ?>
            </div>
            <div class="media-info">
              <h5>Favorables</h5>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-3 col-xs-6">
        <a href="opposants.php">
          <div class="media-box bg-sea">
            <div class="media-icon">
              <i class="fa fa-thumbs-down"></i> <?php include('totalOpposant.php'); ?>
            </div>
            <div class="media-info">
              <h5>Opposants</h5>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-3 col-xs-6">
        <a href="indecis.php">
          <div class="media-box bg-blue">
            <div class="media-icon">
              <i class="fa fa-meh"></i>  <?php include('totalIndecis.php'); ?>
            </div>
            <div class="media-info">
              <h5>Indécis</h5>
            </div>
          </div>
        </a>
      </div>
      </div>

     
     <!-- Tableau récapitulatif des votes -->
     <div class="container-fluid">
      <div class="stats-container">
        <div class="chart-wrapper">
          <div class="chart-container-table">
            <h3>Tableau récapitulatif des votes</h3> 
            <table class="stats-table">
              <thead>
                <tr>
                  <th>Effectif Total</th>
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
                <tr>
                  <td><?= $stats['total'] ?></td>
                  <td><?= $stats['nonTraite'] ?></td>
                  <td><?= $stats['favorable'] ?></td>
                  <td><?= $stats['indecis'] ?></td>
                  <td><?= $stats['opposant'] ?></td>
                  <td><?= $stats['pourcentageNontraite'] ?></td>
                  <td><?= $stats['pourcentageFavorable'] ?></td>
                  <td><?= $stats['pourcentageIndecis'] ?></td>
                  <td><?= $stats['pourcentageOpposant'] ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </section>
</div>

<?php
include './includes/footer.php';
?>
