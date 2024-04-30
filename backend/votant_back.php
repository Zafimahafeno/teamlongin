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
    $nom_votant = $_POST["nom_votant"];
    $prenom_votant = $_POST["prenom_votant"];
    $adresse_votant = $_POST["adresse_votant"];
    $contact_votant = $_POST["contact_votant"];
    
    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO votant (nom_votant, prenom_votant, adresse_votant, contact_votant) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nom_votant, $prenom_votant, $adresse_votant, $contact_votant);
    
    if ($stmt->execute()) {
        echo "Le votant a été ajouté avec succès.";
        
        // Redirection vers view_gateway.php après l'ajout réussi du votant
        header("Location: ../view_gateway.php");
        exit(); // Assurez-vous de quitter le script après la redirection
    } else {
        echo "Erreur lors de l'ajout du votant: " . $conn->error;
    }
    
    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>
