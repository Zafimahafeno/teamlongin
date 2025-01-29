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

<style>
  .chart-container {
    max-width: 450px;
    margin: auto;
  }
  .chart-box {
    margin-bottom: 20px;
  }

  .chart-box label {
    font-weight: bold;
    margin-right: 10px;
  }

  .chart-box select {
    padding: 5px;
    font-size: 10px;
    border-radius: 5px;
    border-color: blue;
  }
</style>

<div class="content-wrapper"> 
  <section class="content-header">
    <h1>STATISTIQUE DES VOTES</h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
      <li class="active"><i class="fa fa-envelope-o"></i>Statistique</li>
      <li class="active"><i class="fa fa-table"></i> Vue Globale</li>
    </ol>
  </section>
  
  <section class="content container-fluid">
  <div class="row">
  <div class="col-md-6">
    <div class="chart-box">
      <label for="chartType">Type de graphique :</label>
      <select id="chartType" onchange="updateChartType()">
        <option value="doughnut">Diagramme en Circulaire</option>
        <option value="bar">Diagramme en Baton</option>
      </select>
      <a href="vote.php" class="btn btn-primary">Ajouter une vote</a>
    </div>
  </div>
  
     
  
</div>
    <div class="row">
      <div class="col-md-12">
        <div class="chart-container">
          <canvas id="myChart" width="400" height="400"></canvas>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
  include './includes/footer.php';
  ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var candidatesData; // Variable globale pour stocker les données des candidats

// Cette fonction récupère les données de la base de données et crée le graphique
function fetchDataAndCreateChart(chartType) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        candidatesData = JSON.parse(xhr.responseText);
        createChart(candidatesData, chartType); // Par défaut, créer un graphique en donut
      } else {
        console.error("Erreur lors de la requête AJAX : " + xhr.status);
      }
    }
  };
  xhr.open('GET', 'get_graph.php', true); // Changez fetch_data_from_database.php avec le nom de votre script PHP pour récupérer les données de la base de données
  xhr.send();
}

// Appeler la fonction pour récupérer les données et créer le graphique au chargement de la page
fetchDataAndCreateChart('doughnut');

function createChart(candidatesData, chartType) {
  var labels = candidatesData.map(function(candidate) {
    return candidate.nom_candidat;
  });
  var data = candidatesData.map(function(candidate) {
    return candidate.total_votes;
  });

  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: chartType,
    data: {
      labels: labels,
      datasets: [{
        label: 'Nombre total de votes',
        data: data,
        backgroundColor: [
          'rgba(255, 99, 132, 0.5)',
          'rgba(54, 162, 235, 0.5)',
          'rgba(255, 206, 86, 0.5)',
          'rgba(75, 192, 192, 0.5)',
          'rgba(153, 102, 255, 0.5)',
          'rgba(255, 159, 64, 0.5)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}


function updateChartType() {
  var chartType = document.getElementById('chartType').value;
  // Supprimer le graphique existant
  var canvas = document.getElementById('myChart');
  canvas.parentNode.removeChild(canvas);
  // Créer un nouveau canvas pour le graphique
  var newCanvas = document.createElement('canvas');
  newCanvas.id = 'myChart';
  newCanvas.width = 400;
  newCanvas.height = 400;
  document.querySelector('.chart-container').appendChild(newCanvas);
  // Récupérer les données et créer le nouveau graphique avec le type sélectionné
  fetchDataAndCreateChart(chartType);
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
