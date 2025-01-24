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
	  <div class="col-md-12"><h4>Rapports</h4></div>
  <div class="col-lg-2 col-xs-6">
		<a href="./view_user.php">
          <div class="media-box">
            <div class="media-icon "><i class="icon-envelope"></i> </div>
            <div class="media-info">
              <h5>Gestions des Candidats</h5>
            </div>
          </div>
		  </a>
        </div>
  <div class="col-lg-2 col-xs-6">
		<a href="./view_gateway.php">
          <div class="media-box bg-sea">
            <div class="media-icon"><i class="fa fa-money"></i> </div>
            <div class="media-info">
              <h5>Gestion des Votants</h5>
            </div>
          </div>
		  </a>
        </div>
  <div class="col-lg-2 col-xs-6">
		<a href="#">
          <div class="media-box bg-blue">
            <div class="media-icon"><i class="fa fa-mail-reply"></i> </div>
            <div class="media-info">
              <h5>Statistique des votants</h5>
            </div>
          </div>
		  </a>
        </div>
  <div class="col-lg-2 col-xs-6">
		<a href="./statistique_votes.php">
          <div class="media-box bg-green">
            <div class="media-icon "><i class="fa fa-envelope"></i> </div>
            <div class="media-info">
              <h5>Statistique des votes</h5>
            </div>
          </div>
		  </a>
        </div>

	<div class="col-lg-2 col-xs-6">
		 <a href="#">
          <div class="media-box bg-blue">
            <div class="media-icon "><i class="fa fa-envelope-o"></i> </div>
            <div class="media-info">
              <h5>Gestion des tâches</h5>
            </div>
          </div>
		  </a>
        </div>
  <div class="col-lg-2 col-xs-6">
		<a href="./planning.php">
          <div class="media-box bg-green">
            <div class="media-icon "><i class="fa fa-users"></i> </div>
            <div class="media-info">
              <h5>Gestion des planing</h5>
            </div>
          </div>
		  </a>
        </div>
		
  </div>
      <div class="row">
        <div class="col-lg-7">
          <div class="chart-box">
            <h4>"SAHIA MANOVA,NDAO HIARA-DIA"</h4>
            <div class="chart">
              <div id="container"></div>
              <!--for values check "Product Sales" chart on char-function.js--> 
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="chart-box">
            <h4>"HO AN'NY FAMPANDROSOANA"</h4>
            <div class="chart">
              <div id="container1"></div>
              <!--for values check "Sales Overview" chart on char-function.js--> 
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
