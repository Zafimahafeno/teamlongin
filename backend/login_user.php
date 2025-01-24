<?php
// Démarrer la session
session_start();

// Connexion à la base de données
require_once '../config/db.php';

if (!$conn) {
    die('Erreur : La connexion à la base de données a échoué.');
}

// Vérification : si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifie que les champs ne sont pas vides
    if (empty($email) || empty($password)) {
        die('Veuillez remplir tous les champs.');
    }

    // Préparation de la requête SQL
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Vérification si la requête a été préparée avec succès
    if (!$stmt) {
        die('Erreur : La requête SQL est incorrecte.');
    }

    // Lier les paramètres
    $stmt->bind_param("s", $email);

    // Exécution de la requête
    $stmt->execute();

    // Obtenir le résultat
    $result = $stmt->get_result();

    // Vérifie si un utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $user['motDePasse'])) {
            // Enregistrement des données utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            header('Location: ../dashboard.php');
            exit;
        } else {
            echo 'Mot de passe incorrect.';
        }
    } else {
        echo 'Aucun utilisateur trouvé avec cet email.';
    }

    // Fermer la requête
    $stmt->close();
} else {
    echo 'Requête non valide.';
}
?>
