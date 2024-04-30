<?php
// Connexion à la base de données - Remplacez les valeurs par les vôtres
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "longin";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si l'ID de la tâche est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Récupérer l'ID de la tâche depuis l'URL
    $tache_id = $_GET['id'];

    // Requête pour récupérer les détails de la tâche
    $sql = "SELECT * FROM tache WHERE id = $tache_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Afficher les détails de la tâche
        while ($row = $result->fetch_assoc()) {
            echo "TITRE : " . $row["titre"] . "<br>";
            echo "Description : " . $row["description"] . "<br>";
            echo "Echéance : " . $row["echeance"] . "<br>";
            echo "Statut : " . $row["status"] . "<br>";
            echo "Priorité : " . $row["priorite"] . "<br>";
            echo "Responsable : " . $row["responsable"] . "<br>";
            echo "Lieu : " . $row["lieu"] . "<br>";
            // Afficher d'autres détails de la tâche si nécessaire
        }
    } else {
        echo "Aucune tâche trouvée avec cet identifiant.";
    }
} else {
    echo "ID de la tâche non spécifié.";
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
