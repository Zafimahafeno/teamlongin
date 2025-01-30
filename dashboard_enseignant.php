<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

include './includes/header.php';
include './includes/sidebar.php';
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
        <h4>Résultat des sondages Enseignants</h4>
      </div>

      <!-- Votants Section -->
      <div class="col-md-3 col-xs-6">
        <a href="./view_gateway.php">
          <div class="media-box">
            <div class="media-icon">
              <i class="fa fa-users"></i> <span class="nombre_dash"> <?php include './backend/totalVotantsEnseignant.php'; ?></span>
            </div>
            <div class="media-info">
              <h5>Votants</h5>
            </div>
          </div>
        </a>
      </div>

      <!-- Favorables Section -->
      <div class="col-md-3 col-xs-6">
        <a href="favorable.php">
          <div class="media-box bg-green">
            <div class="media-icon">
              <i class="fa fa-thumbs-up"></i> <?php include('./backend/totalFavorableEnseignant.php'); ?>
            </div>
            <div class="media-info">
              <h5>Favorables</h5>
            </div>
          </div>
        </a>
      </div>

      <!-- Opposants Section -->
      <div class="col-md-3 col-xs-6">
        <a href="opposants.php">
          <div class="media-box bg-sea">
            <div class="media-icon">
              <i class="fa fa-thumbs-down"></i> <?php include('./backend/totalOpposantEnseignant.php'); ?>
            </div>
            <div class="media-info">
              <h5>Opposants</h5>
            </div>
          </div>
        </a>
      </div>

      <!-- Indécis Section -->
      <div class="col-md-3 col-xs-6">
        <a href="indecis.php">
          <div class="media-box bg-blue">
            <div class="media-icon">
              <i class="fa fa-meh"></i>  <?php include('./backend/totalIndecisEnseignant.php'); ?>
            </div>
            <div class="media-info">
              <h5>Indécis</h5>
            </div>
          </div>
        </a>
      </div>

    </div>

    <div class="container-fluid">
      <div class="stats-container">
        <div class="chart-wrapper">
          <div class="chart-container">
            <h4 class="chart-title">Répartition par établissement</h4>
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
    </div>
  </section>

 
</div> <!-- Fin de la content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Fonction pour charger les données des graphiques depuis le backend
  async function loadChartData() {
  try {
    const response = await fetch('get_vote_data.php');
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
      label: 'Enseignant - Favorable',
      data: etablissements.map(e => data[e].Enseignant.Favorable),
      backgroundColor: 'rgba(47, 8, 219, 0.6)',
      stack: 'Enseignant'
    },
    {
      label: 'Enseignant - Opposant',
      data: etablissements.map(e => data[e].Enseignant.Opposant),
      backgroundColor: 'rgba(153, 102, 255, 0.6)',
      stack: 'Enseignant'
    },
    {
      label: 'Enseignant - Indécis',
      data: etablissements.map(e => data[e].Enseignant.Indécis),
      backgroundColor: 'rgba(255, 159, 64, 0.6)',
      stack: 'Enseignant'
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

  // Calcul des totaux uniquement pour les enseignants
  Object.values(data).forEach(etablissement => {
    Object.entries(etablissement.Enseignant).forEach(([intention, count]) => {
      totals[intention] += count;
    });
  });

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: Object.keys(totals),
      datasets: [{
        data: Object.values(totals),
        backgroundColor: [
          'rgba(47, 8, 219, 0.6)',
          'rgba(153, 102, 255, 0.6)',
          'rgba(255, 159, 64, 0.6)'
        ],
        borderColor: [
          'rgba(47, 8, 219, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
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

