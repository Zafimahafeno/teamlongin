<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour compter les votants "Non traité"
$sql_nontraite = "
    SELECT COUNT(*) AS total_nontraite
    FROM votant
    WHERE intentionVote IN ('Non traité', '') 
    AND fonction = 'Enseignant'
    AND tel <> ''
";

// Exécution de la requête
$result_nontraite = $conn->query($sql_nontraite);

// Vérification si la requête a échoué
if (!$result_nontraite) {
    die("Erreur SQL: " . $conn->error);  // Affiche l'erreur SQL
}

// Récupération et affichage du résultat
$row_nontraite = $result_nontraite->fetch_assoc();
echo $row_nontraite["total_nontraite"];  

// Fermeture de la connexion
$conn->close();
?>