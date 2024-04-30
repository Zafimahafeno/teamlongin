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
    $titre = $_POST["titre"];
    $lieu = $_POST["lieu"];
    $date_event = $_POST["date_event"];
    $heure = $_POST["heure"];
    $acteur = $_POST["acteur"];
    $description = $_POST["description"];
    
    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO planing (titre, lieu, date_event, heure, acteur, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $titre, $lieu, $date_event, $heure, $acteur, $description);
    
    if ($stmt->execute()) {
        echo "L'événement de planification a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'événement de planification: " . $conn->error;
    }
    
    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>
