<?php
    require_once './config/db.php';

// Récupération des données du formulaire
$nom_candidat = $_POST['nom_candidat'];
$prenom_candidat = $_POST['prenom_candidat'];
$partie = $_POST['partie'];
$contact = $_POST['contact'];
$num_electoral = $_POST['num_electoral'];

// Traitement de l'upload de la photo
$upload_dir = "uploads/";
$photo_name = basename($_FILES["photo"]["name"]);
$photo_tmp_name = $_FILES["photo"]["tmp_name"];

// Déplacer le fichier téléchargé vers l'emplacement souhaité
$photo_destination = $upload_dir . $photo_name;
if (move_uploaded_file($photo_tmp_name, $photo_destination)) {
    // Le fichier a été déplacé avec succès
    // Insérer le candidat dans la base de données avec les autres données et le nom de la photo
    $sql_insert_candidat = "INSERT INTO candidat (nom_candidat, prenom_candidat, partie, contact, num_electoral, photo) VALUES ('$nom_candidat', '$prenom_candidat', '$partie', '$contact', '$num_electoral', '$photo_name')";

    // Si l'insertion du candidat s'est déroulée avec succès
    if ($conn->query($sql_insert_candidat) === TRUE) {
        // Récupérer l'ID du candidat nouvellement inséré
        $id_candidat = $conn->insert_id;

        // Insérer une entrée correspondante dans la table des votes
        $sql_insert_vote = "INSERT INTO vote (id_candidat) VALUES ('$id_candidat')";

        // Si l'insertion du vote s'est déroulée avec succès
        if ($conn->query($sql_insert_vote) === TRUE) {
            // Redirection vers view_user.php
            header("Location: view_user.php");
            exit(); // Assurez-vous de terminer le script après la redirection
        } else {
            echo "Erreur lors de l'insertion du vote : " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'insertion du candidat : " . $conn->error;
    }
} else {
    // Erreur lors du déplacement du fichier
    echo "Erreur lors du déplacement du fichier : " . $photo_tmp_name . " vers " . $photo_destination;
}

// Fermer la connexion à la base de données
$conn->close();
?>
