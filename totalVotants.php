<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour compter tous les votants (indépendamment de leur intention de vote)
$sql_total_votants = "
    SELECT COUNT(*) AS total_votants
    FROM votant
";

// Exécution de la requête pour obtenir le total des votants
$result_total_votants = $conn->query($sql_total_votants);

// Vérification et affichage du résultat
if ($result_total_votants->num_rows > 0) {
    $row_total_votants = $result_total_votants->fetch_assoc();
    $total_votants = $row_total_votants["total_votants"];
    echo $total_votants;  // Afficher directement le nombre de tous les votants
}

// Fermeture de la connexion
$conn->close();
?>
