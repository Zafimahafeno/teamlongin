<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Vérification si l'ID est passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Requête de suppression
    $sql = "DELETE FROM votant WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Le votant a été supprimé avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression du votant.";
    }

    $stmt->close();
}

// Redirection vers la page de liste
header("Location: view_gateway.php");
exit;
?>
