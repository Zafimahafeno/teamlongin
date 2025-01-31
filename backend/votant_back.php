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
    $nom = $_POST["nom_votant"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $fonction = $_POST["fonction"] ?? '';
    $tel = $_POST["tel"] ?? '';
    $commentaire = $_POST["commentaire"] ?? '';
    $id_etablissement = $_POST["id_etablissement"] ?? '';
    $grade_enseignant = $_POST["grade_enseignant"] ?? '';
    $IM = $_POST["IM"] ?? '';
    $corps = $_POST["corps"] ?? '';
    // Définir une valeur par défaut pour id_candidat (par exemple 1)
    $id_candidat = 12; // À ajuster selon votre logique métier
    
    // Préparer la requête d'insertion avec id_candidat
    $sql = "INSERT INTO votant (nom_votant, grade_enseignant, IM, corps, prenom, fonction, tel, commentaire, id_etablissement, id_candidat) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    
    // Lier les paramètres à la requête préparée (ajout de 'i' pour l'id_candidat)
    $stmt->bind_param("sssssssssi", 
        $nom,
        $grade_enseignant, 
        $IM, 
        $corps, 
        $prenom, 
        $fonction, 
        $tel, 
        $commentaire, 
        $id_etablissement,
        $id_candidat
    );
    
    // Exécuter la requête
    if ($stmt->execute()) {
        // Redirection vers view_gateway.php après l'ajout réussi du votant
        header("Location: ../view_gateway.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout du votant: " . $stmt->error;
    }
    
    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>