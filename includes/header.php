<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Compagne et Élection UF</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-DhISw5U6dovpM+gs3vIi5JzCA/6w6AdewRxnANslWx+UQEGmPmJVbKzm0ofVsmZtcnB8d+gIqK2kpyMM23eFEA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <!-- Template style -->
  <link rel="stylesheet" href="dist/css/style.css">
  <link rel="stylesheet" href="dist/et-line-font/et-line-font.css">
  <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
  <link type="text/css" rel="stylesheet" href="dist/weather/weather-icons.min.css">
  <link type="text/css" rel="stylesheet" href="dist/weather/weather-icons-wind.min.css">
  <link rel="stylesheet" href="dist/css/chosen.min.css">
  <link rel="stylesheet" href="dist/css/select2.css">

  <!-- Ajout du CDN de Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

</head>

<body class="sidebar-mini">
  <div class="wrapper"> 
  
  <!-- Main Header -->
    <header class="main-header dark-bg"> 
    
    <!-- Logo --> 
      <a href="index.html" class="logo dark-bg"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
        <span class="logo-mini"><img src="dist/img/logo.png" alt="Ovio"></span> 
    <!-- logo for regular state and mobile devices --> 
        <span class="logo-lg">Administrateur 
      </a> 
    
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation"> 
      <!-- Sidebar toggle button--> 
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> </a>

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu"> 
            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">  -->
              <!-- <i class="icon-envelope"></i> -->
              <div class="notify"> 
                <span class="heartbit"></span> 
                <span class="point"></span> 
              </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/img1.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>Arun </h4>
                      <p>Lorem ipsum dolor sit amet.</p>
                      <p><small><i class="fa fa-clock-o"></i> 2 mins</small></p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/img2.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>Douglas Smith</h4>
                      <p>Lorem ipsum dolor sit amet.</p>
                      <p><small><i class="fa fa-clock-o"></i> 15 mins</small></p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/img3.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>Lorence Deo</h4>
                      <p>Lorem ipsum dolor sit amet.</p>
                      <p><small><i class="fa fa-clock-o"></i> 35 mins</small></p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/img1.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>Florence Douglas</h4>
                      <p>Lorem ipsum dolor sit amet.</p>
                      <p><small><i class="fa fa-clock-o"></i> 2 mins</small></p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">Check all notifications</a></li>
            </ul>
          </li>
          <!-- messages-menu --> 
          
          <!-- Notifications Menu -->
<?php
 
  require_once './config/db.php';
  // Requêtes SQL pour compter le nombre de tâches pour chaque statut
  $sql_en_attente = "SELECT COUNT(*) AS count FROM tache WHERE status = 'en attente'";
  $sql_en_cours = "SELECT COUNT(*) AS count FROM tache WHERE status = 'en cours'";
  $sql_validation = "SELECT COUNT(*) AS count FROM tache WHERE status = 'Validation'";
  $sql_terminee = "SELECT COUNT(*) AS count FROM tache WHERE status = 'Terminee'";

  // Exécution des requêtes
  $result_en_attente = $conn->query($sql_en_attente);
  $result_en_cours = $conn->query($sql_en_cours);
  $result_validation = $conn->query($sql_validation);
  $result_terminee = $conn->query($sql_terminee);

  // Initialisation des compteurs
  $count_en_attente = 0;
  $count_en_cours = 0;
  $count_validation = 0;
  $count_terminee = 0;

  // Récupération des résultats
  if ($result_en_attente->num_rows > 0) {
      $row = $result_en_attente->fetch_assoc();
      $count_en_attente = $row["count"];
  }

  if ($result_en_cours->num_rows > 0) {
      $row = $result_en_cours->fetch_assoc();
      $count_en_cours = $row["count"];
  }

  if ($result_validation->num_rows > 0) {
      $row = $result_validation->fetch_assoc();
      $count_validation = $row["count"];
  }

  if ($result_terminee->num_rows > 0) {
      $row = $result_terminee->fetch_assoc();
      $count_terminee = $row["count"];
  }

  // Fermeture de la connexion à la base de données
  $conn->close();
?>

<!-- Section de notification -->
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-megaphone"></i>
        <div class="notify">
            <span class="heartbit"></span>
            <span class="point"></span>
        </div>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Notifications</li>
        <li>
            <ul class="menu">
                <li><a href="#"><i class="icon-lightbulb"></i> Vous avez <?php echo $count_en_attente; ?> tâche(s) en attente</a></li>
                <li><a href="#"><i class="icon-lightbulb"></i> Vous avez <?php echo $count_en_cours; ?> tâche(s) en cours</a></li>
                <li><a href="#"><i class="icon-lightbulb"></i> Vous avez <?php echo $count_validation; ?> tâche(s) en validation</a></li>
                <li><a href="#"><i class="icon-lightbulb"></i> Vous avez <?php echo $count_terminee; ?> tâche(s) terminée(s)</a></li>
                <!-- Vous pouvez ajouter d'autres notifications ici -->
            </ul>
        </li>
        <li class="footer"><a href="#">Voir tout</a></li>
    </ul>
</li>
          <!-- Tasks Menu --> 
          <!-- User Account Menu -->
          <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="dist/img/logo.png" class="user-image" alt="User Image"> <span class="hidden-xs">Compagne et Élection UF</span> </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img"><img src="dist/img/logo.png" class="img-responsive" alt="User"></div>
                <p class="text-left">Compagne et Élection UF  <small><?php echo $_SESSION['user_prenom']; ?></small> </p>
                <!--<div class="view-link text-left"><a href="#">View Profile</a> </div>-->
              </li>
              <!-- <li><a href="#"><i class="icon-profile-male"></i> My Profile</a></li>
              <li><a href="#"><i class="icon-wallet"></i> My Balance</a></li>
              <li><a href="#"><i class="icon-envelope"></i> Inbox</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#"><i class="icon-gears"></i> Account Setting</a></li>
              <li role="separator" class="divider"></li> -->
              <li><a href="../teamlongin/backend/logout.php"><i class="fa fa-power-off"></i> Se déconnecter</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  