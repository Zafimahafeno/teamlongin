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
<?php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

// Récupérer les votants et leur présence
$sql = "SELECT v.id AS votant_id, v.nom_votant, v.prenom, v.fonction, e.nom AS etablissement, 
               v.intentionVote, v.DernierContact, p.date_presence, p.statut 
        FROM votant v
        LEFT JOIN etablissement e ON v.id_etablissement = e.id_etablissement
        LEFT JOIN presences p ON v.id = p.votant_id AND p.date_presence = CURDATE()
        ORDER BY v.nom_votant";

$result = $conn->query($sql);

$pat = [];
$enseignants = [];

while ($row = $result->fetch_assoc()) {
    if (stripos($row["fonction"], "enseignant") !== false) {
        $enseignants[] = $row;
    } else {
        $pat[] = $row;
    }
}
?>

<style>
    .table-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }
    .table thead {
        position: sticky;
        top: 0;
        background: #2d56a8;
        color: white;
        z-index: 1000;
    }
    th, td {
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        padding: 8px;
    }
    .statut-colonne {
        min-width: 120px;
    }
    .search-bar {
        margin-bottom: 15px;
        width: 100%;
        max-width: 400px;
    }
    .btn-primary {
        background-color: #f5aa47;
        border-color: #f5aa47;
    }
    .btn-danger {
        background-color: #f4b3d0;
        border-color: #f4b3d0;
    }
    .btn-success {
        background-color: #f8cf87;
        border-color: #f8cf87;
    }
</style>

<div class="content-wrapper"> 
    <section class="content-header">
        <h1>Gestion des Présences</h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-check-circle"></i> Présences</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <!-- <div class="text-center mb-3">
            <button class="btn btn-primary" onclick="ajouterPresenceTous()">Enregistrer Présences du Jour</button>
            <button class="btn btn-danger" onclick="exportPDF('tableEnseignants', 'Historique_Enseignants')">Exporter Enseignants en PDF</button>
            <button class="btn btn-danger" onclick="exportPDF('tablePAT', 'Historique_PAT')">Exporter PAT en PDF</button>
        </div> -->

        <input type="text" id="searchInput" class="form-control search-bar" placeholder="Rechercher...">
        
        <h3>Enseignants</h3>
        <div class="table-container">
            <table class="table table-striped" id="tableEnseignants">
                <thead>
                    <tr>
                        <th>Nom</th><th>Prénom</th><th>Établissement</th><th>Intention de Vote</th><th>Dernier Contact</th><th>Date Présence</th><th>Statut</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enseignants as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["nom_votant"]) ?></td>
                            <td><?= htmlspecialchars($row["prenom"]) ?></td>
                            <td><?= htmlspecialchars($row["etablissement"] ?: "Aucun") ?></td>
                            <td><?= htmlspecialchars($row["intentionVote"]) ?></td>
                            <td><?= htmlspecialchars($row["DernierContact"]) ?></td>
                            <td><?= htmlspecialchars($row["date_presence"] ?: "Non enregistrée") ?></td>
                            <td class="statut-colonne">
                                <select class="form-select statut-select" data-votant-id="<?= $row['votant_id'] ?>">
                                    <option value="Présent" <?= $row["statut"] == "Présent" ? "selected" : "" ?>>Présent</option>
                                    <option value="Absent" <?= $row["statut"] == "Absent" ? "selected" : "" ?>>Absent</option>
                                </select>
                            </td>
                            <td><button class="btn btn-success" onclick="ajouterPresence(<?= $row['votant_id'] ?>)">Ajouter</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h3 class="mt-4">Personnel Administratif et Technique (PAT)</h3>
        <div class="table-container">
            <table class="table table-striped" id="tablePAT">
                <thead>
                    <tr>
                        <th>Nom</th><th>Prénom</th><th>Établissement</th><th>Intention de Vote</th><th>Dernier Contact</th><th>Date Présence</th><th>Statut</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pat as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["nom_votant"]) ?></td>
                            <td><?= htmlspecialchars($row["prenom"]) ?></td>
                            <td><?= htmlspecialchars($row["etablissement"] ?: "Aucun") ?></td>
                            <td><?= htmlspecialchars($row["intentionVote"]) ?></td>
                            <td><?= htmlspecialchars($row["DernierContact"]) ?></td>
                            <td><?= htmlspecialchars($row["date_presence"] ?: "Non enregistrée") ?></td>
                            <td class="statut-colonne">
                                <select class="form-select statut-select" data-votant-id="<?= $row['votant_id'] ?>">
                                    <option value="Présent" <?= $row["statut"] == "Présent" ? "selected" : "" ?>>Présent</option>
                                    <option value="Absent" <?= $row["statut"] == "Absent" ? "selected" : "" ?>>Absent</option>
                                </select>
                            </td>
                            <td><button class="btn btn-success" onclick="ajouterPresence(<?= $row['votant_id'] ?>)">Ajouter</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function ajouterPresenceTous() {
        $.post("ajouter_presence_tous.php", function(response) {
            alert(response);
            location.reload();
        });
    }

    function ajouterPresence(votant_id) {
        var today = new Date().toISOString().split('T')[0];
        var statut = $(".statut-select[data-votant-id='" + votant_id + "']").val();

        $.post("ajouter_presence.php", { votant_id: votant_id, date_presence: today, statut: statut }, function(response) {
            alert(response);
            location.reload();
        });
    }

    // Nouveau gestionnaire d'événements pour le changement de statut
    $(document).on('change', '.statut-select', function() {
        var votant_id = $(this).data('votant-id');
        var statut = $(this).val();
        
        $.post("update_status.php", {
            votant_id: votant_id,
            statut: statut
        }, function(response) {
            // Recharger la page après la mise à jour
            location.reload();
        });
    });

    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>

<?php
include './includes/footer.php';
?>