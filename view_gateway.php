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
                                <!-- <label><input type="radio" name="colorRadio" checked="checked" value="bind"> All</label>
                                <label><input type="radio" name="colorRadio" value="other"> Active</label> -->
                               
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
                            $sql = "SELECT votant.*, etablissement.nom as nom_etablissement FROM votant 
                                    LEFT JOIN etablissement ON votant.id_etablissement = etablissement.id_etablissement";

                            $result = $conn->query($sql);

                            // Affichage des données dans le tableau
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td data-field='nom_votant'>" . $row["nom_votant"] . "</td>";
                                    echo "<td data-field='prenom'>" . $row["prenom"] . "</td>";
                                    echo "<td data-field='fonction'>" . $row["fonction"] . "</td>";
                                    echo "<td data-field='id_etablissement'>" . ($row["nom_etablissement"] ? $row["nom_etablissement"] : "Aucun établissement") . "</td>";
                                    echo "<td data-field='email'>" . $row["email"] . "</td>";
                                    echo "<td data-field='tel'>" . $row["tel"] . "</td>";
                                    echo "<td data-field='intentionVote'>" . $row["intentionVote"] . "</td>";
                                    echo "<td data-field='DernierContact'>" . $row["DernierContact"] . "</td>";
                                    echo "<td data-field='commentaire'>" . $row["commentaire"] . "</td>";
                                    echo "<td data-field='demarcheEffectue'>" . $row["demarcheEffectue"] . "</td>";
                                    echo "<td data-field='proposition'>" . $row["proposition"] . "</td>";
                                    
                                    echo "<td class='action-col'>";
                                    echo "<label>";
                                    echo "<a href='./backend/update_votant.php?id=" . $row["id"] . "' class='btn btn-default btn-icon btn-xs tip' title='Modifier' rel='tooltip' data-toggle='tooltip' data-placement='top' data-original-title='Modifier'>";
                                    echo "<i class='fa fa-edit text-info'></i>";
                                    echo "</a>";
                                    echo "</label>";
                                    echo "<label>";
                                    echo "</label>";
                                    echo "<label>";
                                    echo "<a href='delete_votant.php?id=" . $row["id"] . "' class='btn btn-default btn-icon btn-xs tip' title='Supprimer' rel='tooltip' data-toggle='modal' data-placement='top' data-original-title='Supprimer' onclick='getDelSmppClient(\"" . $row["id"] . "\", \"" . $row["nom_votant"] . "\");'>";
                                    echo "<i class='fa fa-trash-o text-danger'></i>";
                                    echo "</a>";
                                    echo "</label>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='13'>Aucune donnée disponible</td></tr>";
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

<script src="./includes/updateVotant.js"></script>
<?php
include './includes/footer.php';
?>
