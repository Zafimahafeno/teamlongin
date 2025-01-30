<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

$sql_indecis_enseignant = "
    SELECT COUNT(*) AS total_indecis_enseignant
    FROM votant
    WHERE fonction = 'Enseignant' AND intentionVote = 'indécis'
";

$result = $conn->query($sql_indecis_enseignant);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total_indecis_enseignant"];
    echo $total;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
