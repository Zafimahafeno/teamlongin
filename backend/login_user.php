<?php
// Démarrer la session
session_start();

// Connexion à la base de données
require_once '../config/db.php';

if (!$conn) {
    die('Erreur : La connexion à la base de données a échoué.');
}

// Vérification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifie que les champs ne sont pas vides
    if (empty($email) || empty($password)) {
        die('Veuillez remplir tous les champs.');
    }

    // Rechercher l'utilisateur dans la table `admin`
    $sql_admin = "SELECT * FROM admin WHERE email = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        // L'utilisateur est un admin
        $user = $result_admin->fetch_assoc();
        if (password_verify($password, $user['motDePasse'])) {
            // Enregistrer les données admin dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['role'] = 'admin'; // Identifier le rôle

            header('Location: ../dashboard.php'); // Rediriger vers le tableau de bord admin
            exit;
        } else {
            echo 'Mot de passe incorrect.';
        }
    } else {
        // Rechercher l'utilisateur dans la table `assistant`
        $sql_assistant = "SELECT * FROM assistant WHERE email = ?";
        $stmt_assistant = $conn->prepare($sql_assistant);
        $stmt_assistant->bind_param("s", $email);
        $stmt_assistant->execute();
        $result_assistant = $stmt_assistant->get_result();

        if ($result_assistant->num_rows > 0) {
            // L'utilisateur est un assistant
            $user = $result_assistant->fetch_assoc();
            if (password_verify($password, $user['motDePasse'])) {
                // Enregistrer les données assistant dans la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                $_SESSION['role'] = 'assistant'; // Identifier le rôle

                header('Location: ../dashboard.php'); // Rediriger vers un tableau de bord assistant
                exit;
            } else {
                echo 'Mot de passe incorrect.';
            }
        } else {
            echo 'Aucun utilisateur trouvé avec cet email.';
        }
    }

    // Fermer les requêtes
    $stmt_admin->close();
    $stmt_assistant->close();
} else {
    echo 'Requête non valide.';
}

// Fermer la connexion
$conn->close();
?>
