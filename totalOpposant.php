<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour compter les votants "opposant"
$sql_opposant = "
    SELECT COUNT(*) AS total_opposant
    FROM votant
    WHERE intentionVote = 'opposant'
";

// Exécution de la requête pour "opposant"
$result_opposant = $conn->query($sql_opposant);

// Vérification et affichage du résultat pour "opposant"
if ($result_opposant->num_rows > 0) {
    $row_opposant = $result_opposant->fetch_assoc();
    $total_opposant = $row_opposant["total_opposant"];
    echo $total_opposant;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
