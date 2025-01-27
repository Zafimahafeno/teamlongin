<?php
// Inclure le fichier de connexion à la base de données
include './config/db.php';

// Vérifier si un identifiant est passé en paramètre GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Suppression du candidat de la base de données
    $sql = "DELETE FROM candidat WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" pour lier l'id comme entier
    $stmt->execute();

    // Rediriger après la suppression
    header("Location: view_user.php?message=Candidat supprimé avec succès!");
    exit();  // S'assurer que le script s'arrête après la redirection
}
?>

