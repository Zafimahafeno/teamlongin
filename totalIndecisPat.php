<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour compter les votants "indécis"
$sql_indecis = "
    SELECT COUNT(*) AS total_indecis
    FROM votant
    WHERE intentionVote = 'indecis' AND fonction = 'PAT' 
";

// Exécution de la requête pour "indécis"
$result_indecis = $conn->query($sql_indecis);

// Vérification et affichage du résultat pour "indécis"
if ($result_indecis->num_rows > 0) {
    $row_indecis = $result_indecis->fetch_assoc();
    $total_indecis = $row_indecis["total_indecis"];
    echo $total_indecis;  // Afficher directement le nombre
}

// Fermeture de la connexion
$conn->close();
?>
