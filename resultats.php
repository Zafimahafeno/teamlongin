<?php  
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include './includes/header.php';
include './includes/sidebar.php';
?>

<style>
.container-custom {
    display: flex;
    gap: 20px;
    align-items: stretch;
}

.box {
    flex: 1;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.table-responsive {
    flex: 1;
    overflow-x: auto;
}

.table thead {}

.custom-blue-header {
    background-color: #007BFF !important;
    /* Bleu Bootstrap */
    color: white !important;
    /* Texte en blanc pour contraste */
}

.btn-primary {
    width: 100%;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="text-primary">Résultats des votes par chaque Candidat</h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-bar-chart"></i> Résultats</li>
            <li class="active"><i class="fa fa-table"></i> Vue Globale</li>
        </ol>
    </section>

    <div class="container my-5">
        <h2 class="text-center text-primary mb-4"></h2>
        <div class="container-custom">
            <!-- Tableau des résultats -->
            <div class="box table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="custom-blue-header text-center">
                        <tr>
                            <th style="white-space: nowrap;">Nom du Candidat</th>
                            <th style="white-space: nowrap;">Voix (PAT)</th>
                            <th style="white-space: nowrap;">Voix (Enseignant)</th>
                            <th style="white-space: nowrap;">Total Voix</th>
                            <th style="white-space: nowrap;">Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_candidat = $_POST['id_candidat'];
    $fonction_votant = $_POST['fonction_votant'];
    $nombreVote = (int)$_POST['nombreVote'];

    // Vérification et mise à jour des votes dans la base de données
    $queryCheck = "SELECT * FROM voix WHERE id_candidat = ? AND fonction_votant = ?";
    $stmt = $conn->prepare($queryCheck);
    $stmt->bind_param("is", $id_candidat, $fonction_votant);
    $stmt->execute();
    $resultCheck = $stmt->get_result();

    if ($resultCheck->num_rows > 0) {
        // Mise à jour des votes existants
        $queryUpdate = "UPDATE voix SET nombreVote = nombreVote + ? WHERE id_candidat = ? AND fonction_votant = ?";
        $stmt = $conn->prepare($queryUpdate);
        $stmt->bind_param("iis", $nombreVote, $id_candidat, $fonction_votant);
        $stmt->execute();
    } else {
        // Insertion des nouveaux votes
        $queryInsert = "INSERT INTO voix (id_candidat, fonction_votant, nombreVote) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($queryInsert);
        $stmt->bind_param("isi", $id_candidat, $fonction_votant, $nombreVote);
        $stmt->execute();
    }
}

$queryTotalVotants = "SELECT (SELECT COUNT(*) FROM votant WHERE fonction = 'PAT') AS totalVotantsPAT,(SELECT COUNT(*) FROM votant WHERE fonction = 'Enseignant' AND tel <>'') AS totalVotantsEnseignant";
$resultTotalVotants = $conn->query($queryTotalVotants);
$rowTotalVotants = $resultTotalVotants->fetch_assoc();

$totalVotantsPAT = $rowTotalVotants['totalVotantsPAT'];
$totalVotantsEnseignant = $rowTotalVotants['totalVotantsEnseignant'];

$queryCandidats = "
    SELECT 
        candidat.id, 
        candidat.nom,
        COALESCE(SUM(CASE WHEN fonction_votant = 'PAT' THEN nombreVote ELSE 0 END), 0) AS voixPAT,
        COALESCE(SUM(CASE WHEN fonction_votant = 'Enseignant' THEN nombreVote ELSE 0 END), 0) AS voixEnseignant
    FROM candidat
    LEFT JOIN voix ON candidat.id = voix.id_candidat
    GROUP BY candidat.id
";
                        $resultCandidats = $conn->query($queryCandidats);
                        
                        if ($resultCandidats->num_rows > 0) {
                            while ($row = $resultCandidats->fetch_assoc()) {
                                $voixPAT = $row['voixPAT'];
                                $voixEnseignant = $row['voixEnseignant'];
                                $totalVoix = $voixPAT + $voixEnseignant;
                                $pourcentage = ($totalVotantsPAT > 0 && $totalVotantsEnseignant > 0) ? (($voixPAT / $totalVotantsPAT) * 10) + (($voixEnseignant / $totalVotantsEnseignant) * 90) : 0;
                                echo "<tr class='text-center'>";
                                echo "<td>{$row['nom']}</td>";
                                echo "<td>{$voixPAT}</td>";
                                echo "<td>{$voixEnseignant}</td>";
                                echo "<td>{$totalVoix}</td>";
                                echo "<td><strong>" . number_format($pourcentage, 2) . "%</strong></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-danger'>Aucun candidat trouvé.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulaire d'ajout de vote -->
            <div class="box">
                <h3 class="text-center text-info">Ajouter un Vote</h3>
                <form action="" method="POST">
                    <div class="mb-2">
                        <label for="id_candidat" class="form-label">Choisir un Candidat :</label>
                        <select class="form-control" name="id_candidat" required>
                            <option value="">Sélectionner un candidat</option>
                            <?php
                            $queryAllCandidats = "SELECT * FROM candidat";
                            $resultAllCandidats = $conn->query($queryAllCandidats);
                            while ($candidat = $resultAllCandidats->fetch_assoc()) {
                                echo "<option value='{$candidat['id']}'>{$candidat['nom']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="fonction_votant" class="form-label">Fonction du Votant :</label>
                        <select class="form-control" name="fonction_votant" required>
                            <option value="PAT">PAT</option>
                            <option value="Enseignant">Enseignant</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="nombreVote" class="form-label">Nombre de Votes :</label>
                        <input type="number" class="form-control" name="nombreVote" required min="1">
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>