<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    include '../config/db.php';

    // Récupération des données du formulaire
    $nom = htmlspecialchars(trim($_POST['nom_utilisateur']));
    $prenom = htmlspecialchars(trim($_POST['prenom_utilisateur']));
    $email = htmlspecialchars(trim($_POST['email_utilisateur']));
    $motDePasse = password_hash(trim($_POST['pwd_utilisateur']), PASSWORD_DEFAULT); 
    $statut = 1; 

    // Gestion de l'upload de l'image
    $photo = $_FILES['photo_utilisateur'];
    $photoName = $photo['name'];
    $photoTmpName = $photo['tmp_name'];
    $photoSize = $photo['size'];
    $photoError = $photo['error'];
    $photoType = $photo['type'];

    // Vérifier l'extension de l'image
    $photoExt = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (in_array($photoExt, $allowed)) {
        if ($photoError === 0) {
            if ($photoSize <= 2000000) { // Limite à 2MB
                // Générer un nom unique pour l'image
                $photoNewName = uniqid('profile_', true) . "." . $photoExt;
                $photoDestination = './uploads/' . $photoNewName;

                // Déplacer l'image dans le dossier "uploads"
                if (move_uploaded_file($photoTmpName, $photoDestination)) {
                    // Insertion dans la base de données
                    $stmt = $conn->prepare("INSERT INTO assistant (photoProfil, nom, prenom, email, motDePasse, statut) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssi", $photoNewName, $nom, $prenom, $email, $motDePasse, $statut);

                    if ($stmt->execute()) {
                        echo "Assistant ajouté avec succès.";
                    } else {
                        echo "Erreur lors de l'ajout : " . $stmt->error;
                    }
                } else {
                    echo "Erreur lors du déplacement de l'image.";
                }
            } else {
                echo "Le fichier est trop volumineux. Taille maximale : 2MB.";
            }
        } else {
            echo "Erreur lors de l'upload de l'image.";
        }
    } else {
        echo "Seuls les fichiers JPG, JPEG, et PNG sont autorisés.";
    }

    $conn->close();
}
?>