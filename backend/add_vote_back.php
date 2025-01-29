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
   
    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO voix (nombreVote, id_candidat) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $nombre, $id_candidat);
    
    if ($stmt->execute()) {
        // Fermer la déclaration et la connexion avant la redirection
        $stmt->close();
        $conn->close();
        
        // Redirection avec un message de succès
        header("Location: ../statistique_votes.php?success=1");
        exit();
    } else {
        // Fermer la déclaration et la connexion
        $stmt->close();
        $conn->close();
        
        // Redirection avec un message d'erreur
        header("Location: ../statistique_votes.php?error=1");
        exit();
    }
}
?>