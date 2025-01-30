<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

$sql_opposant_PAT = "
    SELECT COUNT(*) AS total_opposant_PAT
    FROM votant
    WHERE fonction = 'PAT' AND intentionVote = 'opposant'
";

$result = $conn->query($sql_opposant_PAT);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total_opposant_PAT"];
    echo $total;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
