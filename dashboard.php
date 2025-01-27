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
</header>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>BIENVENUE <?php echo $_SESSION['user_prenom']; ?></h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
       
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
    <div class="row">
  <div class="col-md-12"><h4>Résultat des sondages</h4></div>
  <div class="col-md-3 col-xs-6">
    <a href="./view_user.php">
      <div class="media-box">
        <div class="media-icon"><i class="fa fa-users"></i> <span class="nombre_dash"> 123</span></div>
        <div class="media-info">
          <h5>Votants</h5>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-xs-6">
    <a href="./view_gateway.php">
      <div class="media-box bg-sea">
        <div class="media-icon"><i class="fa fa-thumbs-down"></i> 12</div>
        <div class="media-info">
          <h5>Opposant</h5>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-xs-6">
    <a href="#">
      <div class="media-box bg-blue">
        <div class="media-icon"><i class="fa fa-meh"></i> 35</div>
        <div class="media-info">
          <h5>Indécis</h5>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-xs-6">
    <a href="./statistique_votes.php">
      <div class="media-box bg-green">
        <div class="media-icon"><i class="fa fa-thumbs-up"></i> 90</div>
        <div class="media-info">
          <h5>Favorable</h5>
        </div>
      </div>
    </a>
  </div>
</div>

      <div class="row">
      <div class="col-lg-6">
  <div class="chart-box">
    <h4>VOTES PAR ETABLISSEMENTS</h4>
    <div class="chart" >
      <!-- Ajoutez un canvas ici pour le graphique -->
      <div class="container1">
      <canvas id="myPieChart"></canvas>
      </div>
    </div>
  </div>
</div>


        <div class="col-lg-6">
          <div class="chart-box">
            <h4>VOTES PAR CANDIDAT</h4>
            <div class="chart">
              <div id="container1" ></div>
              <!--for values check "Sales Overview" chart on char-function.js--> 
              <canvas id="voteResultsChart"></canvas>
            </div>
          </div>
        </div>
		</div>
		</section>
    <!-- content --> 
  </div>
  <!-- content-wrapper --> 
  
  <?php
include './includes/footer.php';

?>


<!-- chart 1 -->
 
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Sélection du canvas
  const ctx = document.getElementById("myPieChart").getContext("2d");

  // Données pour le graphique
  const data = {
    labels: ["Rouge", "Bleu", "Jaune", "Vert", "Violet"],
    datasets: [
      {
        label: "Votes",
        data: [12, 19, 3, 5, 7],
        backgroundColor: [
          "rgba(255, 99, 132, 0.6)",
          "rgba(54, 162, 235, 0.6)",
          "rgba(255, 206, 86, 0.6)",
          "rgba(75, 192, 192, 0.6)",
          "rgba(153, 102, 255, 0.6)"
        ],
        borderColor: [
          "rgba(255, 99, 132, 1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)"
        ],
        borderWidth: 1
      }
    ]
  };

  // Options pour le graphique
  const options = {
    responsive: true,
    plugins: {
      legend: {
        position: "top"
      },
      tooltip: {
        callbacks: {
          label: (context) => `${context.label}: ${context.raw} votes`
        }
      }
    }
  };

  // Création du graphique
  new Chart(ctx, {
    type: "bar",
    data: data,
    options: options
  });
</script>
 <!-- /chart 1 -->

 <!-- chart2 -->
  

 <script>
  // Sélection du canvas
  const ctxBar = document.getElementById("voteResultsChart").getContext("2d");

  // Données des résultats des votes
  const voteData = {
    labels: ["Candidat A", "Candidat B", "Candidat C", "Candidat D", "Candidat E"],
    datasets: [
      {
        label: "Résultats des votes",
        data: [120, 150, 180, 90, 70], // Nombre de votes par candidat
        backgroundColor: [
          "rgba(255, 99, 132, 0.6)",
          "rgba(54, 162, 235, 0.6)",
          "rgba(255, 206, 86, 0.6)",
          "rgba(75, 192, 192, 0.6)",
          "rgba(153, 102, 255, 0.6)"
        ],
        borderColor: [
          "rgba(255, 99, 132, 1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)"
        ],
        borderWidth: 1
      }
    ]
  };

  // Options du graphique
  const voteOptions = {
    responsive: true,
    plugins: {
      legend: {
        display: false // Supprimer la légende
      },
      tooltip: {
        callbacks: {
          label: (context) => `${context.label}: ${context.raw} votes`
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Nombre de votes"
        }
      },
      x: {
        title: {
          display: true,
          text: "Candidats"
        }
      }
    }
  };

  // Création du graphique
  new Chart(ctxBar, {
    type: "pie", // Type du graphique
    data: voteData,
    options: voteOptions
  });
</script>