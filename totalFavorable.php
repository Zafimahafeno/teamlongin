<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour compter les votants "favorable"
$sql_favorable = "
    SELECT COUNT(*) AS total_favorable
    FROM votant
    WHERE intentionVote = 'favorable'
";

// Exécution de la requête pour "favorable"
$result_favorable = $conn->query($sql_favorable);

// Vérification et affichage du résultat pour "favorable"
if ($result_favorable->num_rows > 0) {
    $row_favorable = $result_favorable->fetch_assoc();
    $total_favorable = $row_favorable["total_favorable"];
    echo $total_favorable;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
