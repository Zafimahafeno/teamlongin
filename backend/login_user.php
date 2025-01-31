<?php
session_start();
require_once '../config/db.php';

if (!$conn) {
    die('Erreur : La connexion à la base de données a échoué.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs.';
        header('Location: ../index.php');
        exit;
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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['role'] = 'admin'; // Identifier le rôle
            header('Location: ../dashboard_pat.php'); // Rediriger vers le tableau de bord admin
            exit;
        } else {
            $_SESSION['error'] = 'Mot de passe incorrect.';
            header('Location: ../index.php');
            exit;
        }
    } else {
        $sql_assistant = "SELECT * FROM assistant WHERE email = ?";
        $stmt_assistant = $conn->prepare($sql_assistant);
        $stmt_assistant->bind_param("s", $email);
        $stmt_assistant->execute();
        $result_assistant = $stmt_assistant->get_result();

        if ($result_assistant->num_rows > 0) {
            $user = $result_assistant->fetch_assoc();
            if (password_verify($password, $user['motDePasse'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                $_SESSION['role'] = 'assistant'; // Identifier le rôle
                // header('Location: ../dashboard.php');
                header('Location: ../dashboard_pat.php');
                exit;
            } else {
                $_SESSION['error'] = 'Mot de passe incorrect.';
                header('Location: ../index.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Aucun utilisateur trouvé avec cet email.';
            header('Location: ../index.php');
            exit;
        }
    }

    $stmt_admin->close();
    $stmt_assistant->close();
} else {
    $_SESSION['error'] = 'Requête non valide.';
    header('Location: ../index.php');
    exit;
}

$conn->close();
?>