<?php
// Connexion à la base de données (remplacez les informations par les vôtres)
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Requête SQL pour récupérer les données
$sql = "SELECT nom AS nom_candidat, SUM(vote.nombre) AS total_votes 
        FROM candidat 
        INNER JOIN vote ON candidat.id_candidat = vote.id_candidat 
        GROUP BY candidat.id_candidat";

$result = $conn->query($sql);

// Vérifier si la requête a réussi
if ($result) {
  $candidates_data = [];
  // Récupérer les données sous forme de tableau associatif
  while ($row = $result->fetch_assoc()) {
    $candidates_data[] = $row;
  }
} else {
  echo "Erreur lors de l'exécution de la requête : " . $conn->error;
  exit; // Sortir du script en cas d'erreur
}

// Encoder le tableau en JSON (vérifiez que $candidates_data n'est pas vide)
$json_data = json_encode($candidates_data);

// Envoyer les données JSON au script appelant
echo $json_data;

// Fermer la connexion
$conn->close();
?>