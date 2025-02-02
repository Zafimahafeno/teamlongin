<?php
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);
// echo 'Connexion à la base de données établie :)';
// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "
    SELECT 
        v.corps,
        COUNT(v.id) AS total,
        SUM(CASE WHEN v.intentionVote = '' OR 'Non traité' THEN 1 ELSE 0 END) AS nonTraite,
        SUM(CASE WHEN v.intentionVote = 'favorable' THEN 1 ELSE 0 END) AS favorable,
        SUM(CASE WHEN v.intentionVote = 'indécis' THEN 1 ELSE 0 END) AS indecis,
        SUM(CASE WHEN v.intentionVote = 'Opposant' THEN 1 ELSE 0 END) AS opposant,
        ROUND((SUM(CASE WHEN v.intentionVote = '' OR 'Non traité' THEN 1 ELSE 0 END) / COUNT(v.id)) * 100, 2) AS pourcentageNontraite,
        ROUND((SUM(CASE WHEN v.intentionVote = 'favorable' THEN 1 ELSE 0 END) / COUNT(v.id)) * 100, 2) AS pourcentageFavorable,
        ROUND((SUM(CASE WHEN v.intentionVote = 'indécis' THEN 1 ELSE 0 END) / COUNT(v.id)) * 100, 2) AS pourcentageIndecis,
        ROUND((SUM(CASE WHEN v.intentionVote = 'Opposant' THEN 1 ELSE 0 END) / COUNT(v.id)) * 100, 2) AS pourcentageOpposant
    FROM votant v
    WHERE v.corps IS NOT NULL AND v.corps <> ''
    GROUP BY v.corps
    HAVING total > 0
";

$result = $conn->query($query);

$stats = [];

while ($row = $result->fetch_assoc()) {
    $row["pourcentageNontraite"] = $row["total"] ? round(($row["nonTraite"] / $row["total"]) * 100, 2) . "%" : "0%";
    $row["pourcentageFavorable"] = $row["total"] ? round(($row["favorable"] / $row["total"]) * 100, 2) . "%" : "0%";
    $row["pourcentageIndecis"] = $row["total"] ? round(($row["indecis"] / $row["total"]) * 100, 2) . "%" : "0%";
    $row["pourcentageOpposant"] = $row["total"] ? round(($row["opposant"] / $row["total"]) * 100, 2) . "%" : "0%";

    $stats[] = $row;
}

$conn->close();
?>
