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
        <h1>Liste des votants</h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-envelope-o"></i>Vue Global</li>
            <!-- <li class="active"><i class="fa fa-table"></i> Liste</li> -->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-box">
                    <h4>VOTANTS</h4>
                    <!-- Ajout des boutons de filtrage -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <label><input type="radio" name="colorRadio" checked="checked" value="bind"> All</label>
                                <label><input type="radio" name="colorRadio" value="other"> Active</label>
                               
                                <button class="btn btn-primary" onclick="window.location.href='telecharger_candidat.php'" title="Télécharger en fichier pdf">
                                    <i class="fas fa-download"></i>
                                </button>
                                                                                                                    
                            </div>
                        </div>
                    </div>
                   
                    <!-- Tableau responsive pour afficher les données -->
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th class="sortable">#</th> -->
                                    <th class="sortable">#</th>
                                    <th class="sortable">Nom</th>
                                    <th class="sortable">Prenom</th>
                                    <th class="sortable">Fonction</th>
                                    <th class="sortable">Établissement</th>
                                    <th class="sortable">Email</th>
                                    <th class="sortable">Contact</th>
                                    <th class="sortable">Intention de vote</th>
                                    <th class="sortable">Dernier contact</th>
                                    <th class="sortable">Commentaire</th>
                                    <th class="sortable">Démarche effectuée</th>
                                    <th class="sortable">Proposition</th>
                                    <th class="sortable">Actions</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Connexion à la base de données
                                $conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

                                // Vérification de la connexion
                                if ($conn->connect_error) {
                                    die("Échec de la connexion à la base de données: " . $conn->connect_error);
                                }

                                // Exécution de la requête SQL pour récupérer les données de la table
                                $sql = "SELECT  votant.*, etablissement.nom FROM   votant  LEFT JOIN  etablissement ON  votant.id_etablissement = etablissement.id";

                                $result = $conn->query($sql);

                                // Affichage des données dans le tableau
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td>" . $row["nom_votant"] . "</td>";
                                        echo "<td>" . $row["prenom"] . "</td>";
                                        echo "<td>" . $row["fonction"] . "</td>";
                                        echo "<td>" . ($row["nom"] ? $row["nom"] : "Aucun établissement") . "</td>";                                        echo "<td>" . $row["email"] . "</td>";
                                        echo "<td>" . $row["tel"] . "</td>";
                                        echo "<td>" . $row["intentionVote"] . "</td>";
                                        echo "<td>" . $row["DernierContact"] . "</td>";
                                        echo "<td>" . $row["commentaire"] . "</td>";
                                        echo "<td>" . $row["demarcheEffectue"] . "</td>";
                                        echo "<td>" . $row["proposition"] . "</td>";
                                        

                                        echo "<td class='action-col' scope='col' id='0'>";
                                        echo "<label>";
                                        echo "<a href='edit_gateway.php' onclick='document.editfrm1.submit(); return false;' class='btn btn-default btn-icon btn-xs tip' title='' rel='tooltip' data-toggle='tooltip' data-placement='top' data-original-title='Edit Smpp Provider'><i class='fa fa-edit text-info'></i></a>";
                                        echo "</label>";
                                        echo "<label>";
                                        echo "<a href='#addsender_outbound' class='btn btn-default btn-icon btn-xs tip' title='' rel='tooltip' data-toggle='modal' data-placement='top' data-original-title='Add SenderID' onclick='addSenderIdOutBound(\"" . $row["id"] . "\", \"" . $row["nom"] . "\");'><i class='fa fa-info-circle text-success'></i></a>";
                                        echo "</label>";
                                        echo "<label>";
                                        echo "<a href='#confrmdel-emp' class='btn btn-default btn-icon btn-xs tip' title='' rel='tooltip' data-toggle='modal' data-placement='top' data-original-title='Del Smpp Provider' onclick='getDelSmppClient(\"" . $row["id"] . "\", \"" . $row["nom"] . "\");'><i class='fa fa-trash-o text-danger'></i></a>";
                                        echo "</label>";
                                        echo "<label>";
                                        echo "<a href='#' class='btn btn-default btn-icon btn-xs tip' title='' rel='tooltip' data-toggle='modal' data-placement='top' data-original-title='Reset Bind' onclick='getResetBind(\"" . $row["id"] . "\", \"" . $row["nom"] . "\");'><i class='glyphicon glyphicon-link text-warning'></i></a>";
                                        echo "</label>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='11'>Aucune donnée disponible</td></tr>";
                                }

                                // Fermeture de la connexion
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
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
