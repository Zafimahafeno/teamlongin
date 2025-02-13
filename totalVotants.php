<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête pour obtenir les totaux des votants PAT et Enseignant
$sql_total_votants = "
    SELECT 
        (SELECT COUNT(*) FROM votant WHERE fonction = 'PAT') AS total_PAT,
        (SELECT COUNT(*) FROM votant WHERE fonction = 'Enseignant' AND tel <> '') AS total_Enseignant
";

$result = $conn->query($sql_total_votants);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_PAT = $row["total_PAT"];
    $total_Enseignant = $row["total_Enseignant"];
    $total_general = $total_PAT + $total_Enseignant;

    echo $total_general;  // Afficher directement le nombre de tous les votants
}

// Fermeture de la connexion
$conn->close();
?>