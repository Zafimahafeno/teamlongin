<head>
  <link rel="stylesheet" href="../dist/css/style.css">
</head>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar dark-bg">
    <section class="sidebar">
      <div class="user-panel black-bg">
        <div class="pull-left image"> <img src="dist/img/logo.png" class="img-circle" alt="User Image"> </div>
        <div class="pull-left info">
          <p>TEAM LONGIN</p>
          <a href="index.php"><i class="fa fa-circle"></i> Online</a> </div>
      </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
         <li class="header dark-bg">Menu de navigation</li>

         <a href="dashboard.php" class="dashboard-link"><i class="fa fa-angle-right"></i> Tableau de bord</a>
        
        <li class="treeview"> <a href="#"><i class="fa fa-desktop"></i> <span>Gestion des Candidats</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="add_user.php"><i class="fa fa-angle-right"></i>Ajouter Candidat</a></li>
            <li><a href="view_user.php"><i class="fa fa-angle-right"></i>Liste des Candidats</a></li>
            <li></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"><i class="fa fa-bullseye"></i> <span>Gestion des Votants</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="add_gateway.php"><i class="fa fa-angle-right"></i>Ajouter Votants</a></li>
            <li><a href="view_gateway.php"><i class="fa fa-angle-right"></i>Liste des Votants</a></li>
          </ul>
        </li>

        <li class="treeview"> <a href="#"><i class="fa fa-pencil-square-o"></i> <span>Statistique</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="statistique_votes"><i class="fa fa-angle-right"></i>Statistique des votes</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i>Statistique des votants</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"><i class="fa fa-table"></i> <span>Communication</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="planing.php"><i class="fa fa-angle-right"></i> Planning</a></li>
            <li><a href="tache.php"><i class="fa fa-angle-right"></i> Gestion de tâche</a></li>
            <li><a href="message.php"><i class="fa fa-angle-right"></i> Envoyer des messages</a></li>
          </ul>
        </li>
        <li> <a href="../teamlongin/backend/logout.php"><i class="fa fa-power"></i> <span>Déconnexion</span> <span class="pull-right-container"></span> </a>
        </li>
    </section>
  </aside>