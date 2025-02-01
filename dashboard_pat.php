<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

include './includes/header.php';
include './includes/sidebar.php';
include './backend/statspat.php';
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Bienvenue <?php echo $_SESSION['user_prenom']; ?></h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
    </ol>
  </section>
  
  <!-- Main content -->
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
              <i class="fa fa-users"></i> <span class="nombre_dash"> <?php include './backend/totalVotantsPat.php'; ?></span>
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
    
    <div class="container-fluid">
      <!-- <div class="stats-container">
        <div class="chart-wrapper">
          <div class="chart-container">
            <h4 class="chart-title">Répartition</h4>
            <canvas id="voteChart"></canvas>
          </div>
        </div>

        <div class="chart-wrapper">
          <div class="chart-container">
            <h4 class="chart-title">Vue d'ensemble des votes</h4>
            <canvas id="overviewChart"></canvas>
          </div>
        </div>
      </div>
    </div> -->

    <div class="container-fluid">
      <div class="stats-container">
        <div class="chart-wrapper">
          <div class="chart-container-table">
          <h3>Tableau récapitulatif</h3>  
          <table class="stats-table">
            <thead>
                <tr>
                    <th>Corps</th>
                    <th>Effectif</th>
                    <th>Favorable</th>
                    <th>Indécis</th>
                    <th>Opposant</th>
                    <th>% Favorable</th>
                    <th>% Indécis</th>
                    <th>% Opposant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['corps']) ?></td>
                        <td><?= $row['total'] ?></td>
                        <td><?= $row['favorable'] ?></td>
                        <td><?= $row['indecis'] ?></td>
                        <td><?= $row['opposant'] ?></td>
                        <td><?= $row['pourcentageFavorable'] ?></td>
                        <td><?= $row['pourcentageIndecis'] ?></td>
                        <td><?= $row['pourcentageOpposant'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

  </section>

 
</div> <!-- Fin de la content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Fonction pour charger les données des graphiques depuis le backend
  async function loadChartData() {
  try {
    const response = await fetch('get_vote_data2.php');
    const data = await response.json();
    createCharts(data);
  } catch (error) {
    console.error('Erreur de chargement:', error);
  }
}

function createCharts(rawData) {
  createVoteChart(rawData);
  createOverviewChart(rawData);
}

function createVoteChart(data) {
  const ctx = document.getElementById('voteChart').getContext('2d');
  const etablissements = Object.keys(data);

  const datasets = [
  {
    label: 'PAT - Favorable',
    data: etablissements.map(e => data[e]?.Favorable || 0),
    backgroundColor: 'rgba(75, 192, 192, 0.6)',
    stack: 'PAT'
  },
  {
    label: 'PAT - Opposant',
    data: etablissements.map(e => data[e]?.Opposant || 0),
    backgroundColor: 'rgba(255, 99, 132, 0.6)',
    stack: 'PAT'
  },
  {
    label: 'PAT - Indécis',
    data: etablissements.map(e => data[e]?.Indécis || 0),
    backgroundColor: 'rgba(255, 206, 86, 0.6)',
    stack: 'PAT'
  }
];


  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: etablissements,
      datasets: datasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          stacked: true
        },
        y: {
          stacked: true,
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          position: 'top',
          align: 'start'
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      }
    }
  });
}

function createOverviewChart(data) {
  const ctx = document.getElementById('overviewChart').getContext('2d');

  let totals = {
    Favorable: 0,
    Opposant: 0,
    Indécis: 0
  };

  // Calcul des totaux uniquement pour le PAT
  Object.values(data).forEach(etablissement => {
    Object.entries(etablissement).forEach(([intention, count]) => {
      if (totals[intention] !== undefined) {
        totals[intention] += count;
      }
    });
  });

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: Object.keys(totals),
      datasets: [{
        data: Object.values(totals),
        backgroundColor: [
          'rgba(75, 192, 192, 0.6)',
          'rgba(255, 99, 132, 0.6)',
          'rgba(255, 206, 86, 0.6)'
        ],
        borderColor: [
          'rgba(75, 192, 192, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(255, 206, 86, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = Object.values(totals).reduce((a, b) => a + b, 0);
              const percentage = ((context.raw / total) * 100).toFixed(1);
              return `${context.label}: ${context.raw} (${percentage}%)`;
            }
          }
        }
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', loadChartData);

</script>

</div> <!-- Fermeture de content-wrapper -->
 <!-- Le footer doit être à la fin, en dehors de la section "content-wrapper" -->
 <?php
  include './includes/footer.php';
  ?>

