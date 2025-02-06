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
        e.nom AS etablissement,
        SUM(CASE WHEN v.intentionVote = '' OR 'Non traité' THEN 1 ELSE 0 END) AS nonTraite,
        SUM(CASE WHEN v.intentionVote = 'favorable' THEN 1 ELSE 0 END) AS favorable,
        SUM(CASE WHEN v.intentionVote = 'indécis' THEN 1 ELSE 0 END) AS indecis,
        SUM(CASE WHEN v.intentionVote = 'Opposant' THEN 1 ELSE 0 END) AS opposant,
        COUNT(v.id) AS total
    FROM etablissement e
    LEFT JOIN votant v ON e.id_etablissement = v.id_etablissement
    WHERE v.tel <> ''
    GROUP BY e.nom
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
