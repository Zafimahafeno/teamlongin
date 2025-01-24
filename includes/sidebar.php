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
            <li><a href="statistique.php"><i class="fa fa-angle-right"></i>Statistique des votes</a></li>
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
        <li class="treeview"> <a href="#"><i class="fa fa-power"></i> <span>Déconnexion</span> <span class="pull-right-container"></span> </a>
          <!-- <ul class="treeview-menu">
            <li><a href="changepwd.php"><i class="fa fa-angle-right"></i> Changer mot de passe</a></li>
            <li><a href="editpro.php"><i class="fa fa-angle-right"></i> Modifier Profile</a></li>
           </ul> -->
        </li>
        <!-- <li class="treeview"> <a href="#"><i class="fa fa-user"></i> <span>Profile</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="changepwd.php"><i class="fa fa-angle-right"></i> Changer mot de passe</a></li>
            <li><a href="editpro.php"><i class="fa fa-angle-right"></i> Modifier Profile</a></li>
           </ul>
        </li> -->
			  <!-- <li><a href="#"><i class="fa fa-angle-right"></i> Error Code</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Blacklist Category</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i>  Blacklist Number</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Whitelist Category</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i> Whitelist Number</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Whitelist DCS Number</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i> Error Code Mapping</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Routing</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i> Gateway Testing</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> System Alerts</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i> System Setting</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Sender ID Routing</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i> Sender</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Add Service Provider</a></li>
			<li><a href="#"><i class="fa fa-angle-right"></i> Content Analyzer</a></li>
			 <li><a href="#"><i class="fa fa-angle-right"></i> Car Reports</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> Arch Reports</a></li>
        
        <li class="treeview"> <a href="#"><i class="fa fa-cloud"></i> <span>Download Zone</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-angle-right"></i> Repeat History</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> View Download</a></li>
           
            
          </ul>
        </li>
        <li class="treeview"> <a href="#"><i class="fa fa-map-marker"></i> <span>Template</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-angle-right"></i> Add Template</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> View Template</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"><i class="fa fa-question"></i> <span>Help</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href=""><i class="fa fa-angle-right"></i> Erroe Code</a></li>
            
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-table"></i> <span>Logs</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-angle-right"></i> Web Access</a></li>
            <li><a href="#"><i class="fa fa-angle-right"></i> View Action</a></li>
              </ul>
            </li>-->
          
          
      <!-- sidebar-menu --> 
    </section>
  </aside>