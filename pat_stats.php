<?php
// Connexion à la base de données
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

// Requête pour récupérer le nombre total des PAT
$totalQuery = "
    SELECT COUNT(*) AS totalPAT
    FROM votant 
    WHERE fonction = 'PAT'
";

$totalResult = $conn->query($totalQuery);
$totalPAT = 0; // Valeur par défaut si aucun résultat
if ($totalResult->num_rows > 0) {
    $totalRow = $totalResult->fetch_assoc();
    $totalPAT = $totalRow['totalPAT']; // Total dynamique des PAT
}

// Requête pour récupérer les statistiques des votes pour le PAT
$query = "
    SELECT 
        SUM(CASE WHEN intentionVote = 'favorable' THEN 1 ELSE 0 END) AS favorable,
        SUM(CASE WHEN intentionVote = 'indécis' THEN 1 ELSE 0 END) AS indecis,
        SUM(CASE WHEN intentionVote = 'Opposant' THEN 1 ELSE 0 END) AS opposant,
        SUM(CASE WHEN intentionVote = 'Non traité' OR intentionVote = '' THEN 1 ELSE 0 END) AS nonTraite
    FROM votant 
    WHERE fonction = 'PAT'
";

$result = $conn->query($query);

$stats = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $favorable = $row['favorable'];
    $indecis = $row['indecis'];
    $opposant = $row['opposant'];
    $nonTraite = $row['nonTraite'];

    // Calcul des pourcentages
    $pourcentageFavorable = ($favorable / $totalPAT) * 100;
    $pourcentageIndecis = ($indecis / $totalPAT) * 100;
    $pourcentageOpposant = ($opposant / $totalPAT) * 100;
    $pourcentageNonTraite = ($nonTraite / $totalPAT) * 100;

    // Ajouter les valeurs au tableau $stats pour affichage
    $stats = [
        'totalPAT' => $totalPAT,
        'favorable' => $favorable,
        'indecis' => $indecis,
        'opposant' => $opposant,
        'nonTraite' => $nonTraite,
        'pourcentageFavorable' => number_format($pourcentageFavorable, 2),
        'pourcentageIndecis' => number_format($pourcentageIndecis, 2),
        'pourcentageOpposant' => number_format($pourcentageOpposant, 2),
        'pourcentageNonTraite' => number_format($pourcentageNonTraite, 2)
    ];
} else {
    echo "Aucune donnée trouvée.";
}

$conn->close();

?>
