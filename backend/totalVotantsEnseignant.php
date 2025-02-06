<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

$sql_all_enseigant = "
    SELECT COUNT(*) AS total_enseigant
    FROM votant
    WHERE fonction = 'Enseignant' AND tel <> ''
";

$result = $conn->query($sql_all_enseigant);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total_enseigant"];
    echo $total;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
