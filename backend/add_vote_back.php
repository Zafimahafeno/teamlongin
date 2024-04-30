<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nombre = $_POST["nombre"];
    $id_candidat = $_POST["id_candidat"];
    $id_zone = $_POST["id_zone"];
    
    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO vote (nombre, id_candidat, id_zone) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $nombre, $id_candidat, $id_zone);
    
    if ($stmt->execute()) {
        echo "Le vote a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du vote: " . $conn->error;
    }
    
    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>
