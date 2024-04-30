<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
  die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Requête SQL pour récupérer les plannings depuis la base de données
$query = "SELECT * FROM planing";

// Exécution de la requête
$result = mysqli_query($conn, $query);

// Tableau pour stocker les événements
$events = array();

// Parcourir les résultats de la requête et ajouter chaque événement au tableau
while ($row = mysqli_fetch_assoc($result)) {
  $event = $row;

  // Assuming "date_event" column exists (modify if needed)
  if (isset($event['date_event'])) {
    $event['start'] = $event['date_event']; // Use dedicated date column directly
  } else {
    // Handle cases where "date_event" is missing (e.g., error message, default value)
    echo "Erreur: Colonne 'date_event' manquante pour l'événement ID " . $event['id'] . "<br>";
  }

  $events[] = $event;
}

// Conversion du tableau en format JSON
echo json_encode($events);
?>