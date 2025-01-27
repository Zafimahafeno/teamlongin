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
    $nom = $_POST["nom_votant"];
    $prenom = $_POST["prenom"];
    $fonction = $_POST["fonction"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $DernierContact = $_POST["DernierContact"];
    $commentaire = $_POST["commentaire"];
    $demarcheEffectue = $_POST["demarcheEffectue"];
    $proposition = $_POST["proposition"];
    $id_etablissement = $_POST["id_etablissement"];
    $intentionVote = $_POST["intentionVote"];
    $id_candidat = $_POST["id_candidat"];
    
    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO votant (nom_votant, prenom, fonction, email,tel,DernierContact,commentaire,demarcheEffectue,proposition,id_etablissement,intentionVote,id_candidat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $nom, $prenom, $fonction, $email, $tel, $DernierContact, $commentaire, $demarcheEffectue, $proposition, $id_etablissement, $intentionVote, $id_candidat);
    
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
