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
    $nom = isset($_POST["nom_votant"]) ? $_POST["nom_votant"] : null;
    $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : null;
    $fonction = isset($_POST["fonction"]) ? $_POST["fonction"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $tel = isset($_POST["tel"]) ? $_POST["tel"] : null;
    $DernierContact = isset($_POST["DernierContact"]) ? $_POST["DernierContact"] : null;
    $commentaire = isset($_POST["commentaire"]) ? $_POST["commentaire"] : null;
    $demarcheEffectue = isset($_POST["demarcheEffectue"]) ? $_POST["demarcheEffectue"] : null;
    $proposition = isset($_POST["proposition"]) ? $_POST["proposition"] : null;
    $id_etablissement = isset($_POST["id_etablissement"]) ? $_POST["id_etablissement"] : null;
    $intentionVote = isset($_POST["intentionVote"]) ? $_POST["intentionVote"] : null;
    $id_candidat = isset($_POST["id_candidat"]) ? $_POST["id_candidat"] : null;

    // Validation des champs obligatoires
    if (empty($nom) || empty($prenom) || empty($fonction) || empty($email)) {
        die("Les champs nom, prénom, fonction et email sont obligatoires.");
    }

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO votant (nom_votant, prenom, fonction, email, tel, DernierContact, commentaire, demarcheEffectue, proposition, id_etablissement, intentionVote, id_candidat) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres à la requête préparée
    $stmt->bind_param("ssssssssssss", $nom, $prenom, $fonction, $email, $tel, $DernierContact, $commentaire, $demarcheEffectue, $proposition, $id_etablissement, $intentionVote, $id_candidat);

    // Exécuter la requête
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
