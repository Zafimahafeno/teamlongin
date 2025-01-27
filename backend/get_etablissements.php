<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer tous les établissements
$sql = "SELECT * FROM etablissement";
$result = $conn->query($sql);

// Générer les options pour la liste déroulante
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['nom']) . '</option>';
    }
}
echo '<option value="other">Ajouter un autre établissement</option>'; // Option pour ajouter un nouvel établissement

$conn->close();
?>
