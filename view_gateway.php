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

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        border-radius: 10px 10px 0 0;
    }
    .btn-sm {
        padding: 5px 10px;
        font-size: 14px;
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
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

    <section class="content container-fluid">
<<<<<<< HEAD
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">VOTANTS</h4>
                    <div>
                        <label class="me-2"><input type="radio" name="colorRadio" checked="checked" value="bind"> Tous</label>
                        <label class="me-2"><input type="radio" name="colorRadio" value="other"> Actifs</label>
                        <button class="btn btn-primary" onclick="window.location.href='telecharger_candidat.php'" title="Télécharger en fichier PDF">
                            <i class="fas fa-download"></i>
                        </button>
=======
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
>>>>>>> 718f4cdd19f9da33443dafa2cbdada1fdcf5140a
                    </div>
                </div>
                <div class="card-body">
                    <!-- Barre de recherche intégrée à DataTables -->
                    <div class="mb-3">
                        <input id="tableSearch" type="text" class="form-control" placeholder="Rechercher...">
                    </div>
                    <!-- Tableau responsive -->
                    <div class="table-responsive">
                        <table id="votantsTable" class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Fonction</th>
                                    <th>Établissement</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Intention de vote</th>
                                    <th>Dernier contact</th>
                                    <th>Commentaire</th>
                                    <th>Démarche effectuée</th>
                                    <th>Proposition</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Connexion à la base de données
                                $conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

<<<<<<< HEAD
                                // Vérification de la connexion
                                if ($conn->connect_error) {
                                    die("Échec de la connexion à la base de données: " . $conn->connect_error);
=======
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
echo "<a href='update_votant.php?id=" . $row["id"] . "' class='btn btn-default btn-icon btn-xs' title='Modifier'>";
echo "<i class='fa fa-edit text-info'></i>";
echo "</a>";
echo "<a href='delete_votant.php?id=" . $row["id"] . "' class='btn btn-default btn-icon btn-xs' title='Supprimer' onclick='return confirm(\"Voulez-vous vraiment supprimer ce votant ?\");'>";
echo "<i class='fa fa-trash-o text-danger'></i>";
echo "</a>";
echo "</td>";

                                    echo "</tr>";
>>>>>>> 718f4cdd19f9da33443dafa2cbdada1fdcf5140a
                                }

                                // Requête SQL pour récupérer les données
                                $sql = "SELECT votant.*, etablissement.nom as nom_etablissement FROM votant 
                                        LEFT JOIN etablissement ON votant.id_etablissement = etablissement.id_etablissement";
                                $result = $conn->query($sql);

                                // Affichage des données
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row["nom_votant"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["fonction"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["nom_etablissement"] ?: "Aucun établissement") . "</td>";
                                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["tel"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["intentionVote"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["DernierContact"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["commentaire"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["demarcheEffectue"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["proposition"]) . "</td>";
                                        echo "<td>";
                                        echo "<a href='#' class='btn btn-info btn-sm me-1' title='Modifier'><i class='fa fa-edit'></i></a>";
                                        echo "<a href='#' class='btn btn-success btn-sm me-1' title='Info'><i class='fa fa-info-circle'></i></a>";
                                        echo "<a href='#' class='btn btn-danger btn-sm' title='Supprimer'><i class='fa fa-trash'></i></a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>Aucune donnée disponible</td></tr>";
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
    </div>
</section>

    <!-- content --> 
</div>
<!-- content-wrapper --> 

<script>
    $(document).ready(function() {
        $('#votantsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json' // Traduction en français
            },
            responsive: true, // Rendre le tableau responsive
            paging: true, // Activer la pagination
            pageLength: 10, // Nombre de lignes par page
            order: [[0, 'asc']] // Trier par la première colonne par défaut
        });
    });
</script>

<script src="./includes/updateVotant.js"></script>
<?php
include './includes/footer.php';
?>
