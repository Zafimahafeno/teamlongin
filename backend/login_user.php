<?php
  // Démarrerage de la session
  session_start();

  // Connexion à la base de données
  require_once '../config/db.php';

  // Vérification : si le formulaire est soumis
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      // Vérifie que les champs ne sont pas vides
      if (empty($email) || empty($password)) {
          die('Veuillez remplir tous les champs.');
      }

      try {
          // Préparation de la requête SQL pour récupérer l'utilisateur par email
          $sql = "SELECT * FROM admin WHERE email = :email";
          $stmt = $conn->prepare($sql);

          $stmt->execute([':email' => $email]);

          // Vérifie si l'utilisateur existe
          if ($stmt->rowCount() > 0) {
              $user = $stmt->fetch(PDO::FETCH_ASSOC);

              // Vérification du mot de passe
              if (password_verify($password, $user['motDePasse'])) {
                  // Enregistrer les données utilisateur dans la session
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
      } catch (PDOException $e) {
          die('Erreur : ' . $e->getMessage());
      }
  } else {
      echo 'Requête non valide.';
  }
?>