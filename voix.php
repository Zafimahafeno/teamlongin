<?php
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour obtenir le nombre total de votants PAT et Enseignants
$queryVotants = "SELECT 
                    (SELECT COUNT(*) FROM votant WHERE fonction = 'PAT') AS totalPAT,
                    (SELECT COUNT(*) FROM votant WHERE fonction = 'Enseignant') AS totalEnseignant";
$resultVotants = $conn->query($queryVotants);
$rowVotants = $resultVotants->fetch_assoc();
$totalPAT = $rowVotants['totalPAT'];
$totalEnseignant = $rowVotants['totalEnseignant'];

// Requête pour récupérer les candidats et le nombre de voix qu'ils ont obtenues
$queryCandidats = "
    SELECT 
        candidat.id, 
        candidat.nom,
        SUM(CASE WHEN voix.id_votant IN (SELECT id FROM votant WHERE fonction = 'PAT') THEN voix.nombreVote ELSE 0 END) AS voixPAT,
        SUM(CASE WHEN voix.id_votant IN (SELECT id FROM votant WHERE fonction = 'Enseignant') THEN voix.nombreVote ELSE 0 END) AS voixEnseignant
    FROM candidat
    LEFT JOIN voix ON candidat.id = voix.id_candidat
    GROUP BY candidat.id
";
$resultCandidats = $conn->query($queryCandidats);

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
                        // Calcul du total des voix et du pourcentage
                        $totalVoix = $row['voixPAT'] + $row['voixEnseignant'];
                        $pourcentage = 0;
                        if ($totalPAT > 0 && $totalEnseignant > 0) {
                            $pourcentage = (($row['voixPAT'] / $totalPAT) * 10) + (($row['voixEnseignant'] / $totalEnseignant) * 90);
                        }

                        // Affichage des résultats
                        echo "<tr>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td>" . $row['voixPAT'] . "</td>";
                        echo "<td>" . $row['voixEnseignant'] . "</td>";
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>