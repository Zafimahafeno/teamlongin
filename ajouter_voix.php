<?php
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_candidat = $_POST['id_candidat'];
    $fonction_votant = $_POST['fonction_votant'];
    $nombreVote = (int)$_POST['nombreVote'];

    $queryCheck = "SELECT * FROM voix WHERE id_candidat = ? AND fonction_votant = ?";
    $stmt = $conn->prepare($queryCheck);
    $stmt->bind_param("is", $id_candidat, $fonction_votant);
    $stmt->execute();
    $resultCheck = $stmt->get_result();

    if ($resultCheck->num_rows > 0) {
        $queryUpdate = "UPDATE voix SET nombreVote = nombreVote + ? WHERE id_candidat = ? AND fonction_votant = ?";
        $stmt = $conn->prepare($queryUpdate);
        $stmt->bind_param("iis", $nombreVote, $id_candidat, $fonction_votant);
        $stmt->execute();
    } else {
        $queryInsert = "INSERT INTO voix (id_candidat, fonction_votant, nombreVote) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($queryInsert);
        $stmt->bind_param("isi", $id_candidat, $fonction_votant, $nombreVote);
        $stmt->execute();
    }
}

$queryTotalVotants = "
    SELECT 
        (SELECT COUNT(*) FROM votant WHERE fonction = 'PAT') AS totalVotantsPAT,
        (SELECT COUNT(*) FROM votant WHERE fonction = 'Enseignant') AS totalVotantsEnseignant
";
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

$queryAllCandidats = "SELECT * FROM candidat";
$resultAllCandidats = $conn->query($queryAllCandidats);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Candidats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2>Résultats des Candidats</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom du Candidat</th>
                    <th>Voix (PAT)</th>
                    <th>Voix (Enseignant)</th>
                    <th>Total Voix</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultCandidats->num_rows > 0) {
                    while ($row = $resultCandidats->fetch_assoc()) {
                        $voixPAT = $row['voixPAT'];
                        $voixEnseignant = $row['voixEnseignant'];
                        $totalVoix = $voixPAT + $voixEnseignant;

                        $pourcentage = 0;
                        if ($totalVotantsPAT > 0 && $totalVotantsEnseignant > 0) {
                            $pourcentage = (($voixPAT / $totalVotantsPAT) * 10) + (($voixEnseignant / $totalVotantsEnseignant) * 90);
                        }

                        echo "<tr>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td>" . $voixPAT . "</td>";
                        echo "<td>" . $voixEnseignant . "</td>";
                        echo "<td>" . $totalVoix . "</td>";
                        echo "<td>" . number_format($pourcentage, 2) . "%</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucun candidat trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Ajouter un Vote</h2>
        <form action="" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="id_candidat" class="form-label">Choisir un Candidat :</label>
                <select class="form-control" name="id_candidat" required>
                    <option value="">Sélectionner un candidat</option>
                    <?php while ($candidat = $resultAllCandidats->fetch_assoc()) { ?>
                    <option value="<?= $candidat['id'] ?>"><?= $candidat['nom'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fonction_votant" class="form-label">Fonction du Votant :</label>
                <select class="form-control" name="fonction_votant" required>
                    <option value="PAT">PAT</option>
                    <option value="Enseignant">Enseignant</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nombreVote" class="form-label">Nombre de Votes :</label>
                <input type="number" class="form-control" name="nombreVote" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter un Vote</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$conn->close();
?>