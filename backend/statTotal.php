<?php
// Connexion à la base de données
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les statistiques, incluant les votants "Non traité"
$query = "
    SELECT 
        (SELECT COUNT(*) FROM votant WHERE fonction = 'PAT' OR (fonction = 'Enseignant' AND tel <> '')) AS total,  -- Total incluant les 'Non traité'
        SUM(CASE WHEN v.intentionVote = 'Non traité' OR v.intentionVote = '' THEN 1 ELSE 0 END) AS nonTraite,
        SUM(CASE WHEN v.intentionVote = 'favorable' THEN 1 ELSE 0 END) AS favorable,
        SUM(CASE WHEN v.intentionVote = 'indécis' THEN 1 ELSE 0 END) AS indecis,
        SUM(CASE WHEN v.intentionVote = 'Opposant' THEN 1 ELSE 0 END) AS opposant
    FROM votant v
    WHERE v.intentionVote IS NOT NULL
";

// Exécution de la requête pour obtenir les statistiques
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalVotants = $row['total'];  // Total incluant "Non traité"
    $nonTraite = $row['nonTraite'];
    $favorable = $row['favorable'];
    $indecis = $row['indecis'];
    $opposant = $row['opposant'];

    // Calcul des pourcentages
    $pourcentageNonTraite = $totalVotants ? round(($nonTraite / $totalVotants) * 100, 2) . "%" : "0%";
    $pourcentageFavorable = $totalVotants ? round(($favorable / $totalVotants) * 100, 2) . "%" : "0%";
    $pourcentageIndecis = $totalVotants ? round(($indecis / $totalVotants) * 100, 2) . "%" : "0%";
    $pourcentageOpposant = $totalVotants ? round(($opposant / $totalVotants) * 100, 2) . "%" : "0%";

    // Passer les statistiques dans un tableau associatif
    $stats = [
        'total' => $totalVotants,
        'nonTraite' => $nonTraite,
        'favorable' => $favorable,
        'indecis' => $indecis,
        'opposant' => $opposant,
        'pourcentageNontraite' => $pourcentageNonTraite,
        'pourcentageFavorable' => $pourcentageFavorable,
        'pourcentageIndecis' => $pourcentageIndecis,
        'pourcentageOpposant' => $pourcentageOpposant
    ];
} else {
    $stats = []; // Si aucun résultat, retourner un tableau vide
}

// Fermeture de la connexion
$conn->close();
?>