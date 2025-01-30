<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST["fonction"]);
    // Récupérer les données du formulaire
    $nom = isset($_POST["nom_votant"]) ? $_POST["nom_votant"] : null;
    $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : null;
    $fonction = isset($_POST["fonction"]) ? $_POST["fonction"] : null;
    $tel = isset($_POST["tel"]) ? $_POST["tel"] : null;
    $commentaire = isset($_POST["commentaire"]) ? $_POST["commentaire"] : null;
    $id_etablissement = isset($_POST["id_etablissement"]) ? $_POST["id_etablissement"] : null;
    $grade_enseignant = isset($_POST["grade_enseignant"]) ? $_POST["grade_enseignant"] : null;
    $IM = isset($_POST["IM"]) ? $_POST["IM"] : null;
    $corps = isset($_POST["corps"]) ? $_POST["corps"] : null;

    // Validation des champs obligatoires
    // if (empty($nom) || empty($prenom) || empty($fonction)) {
    //     die("Les champs nom, prénom, fonction et email sont obligatoires.");
    // }

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO votant (nom_votant,grade_enseignant, IM, corps, prenom, fonction, email, tel, commentaire, id_etablissement) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres à la requête préparée
    $stmt->bind_param("ssssssssss", $nom,$grade_enseignant, $IM, $corps, $prenom, $fonction, $tel, $DernierContact, $commentaire, $id_etablissement);

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
