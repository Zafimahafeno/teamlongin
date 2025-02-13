<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour compter les votants "favorable"
$sql_nontraite = "
    SELECT COUNT(*) AS total_nontraite
    FROM votant
    WHERE intentionVote = 'Non traité' OR intentionVote = ''
";

// Exécution de la requête pour "favorable"
$result_nontraite = $conn->query($sql_nontraite);

// Vérification et affichage du résultat pour "favorable"
if ($result_nontraite->num_rows > 0) {
    $row_nontraite = $result_nontraite->fetch_assoc();
    $total_nontraite = $row_nontraite["total_nontraite"];
    echo $total_nontraite;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
