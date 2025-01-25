<?php
session_start();

// Afficher le message d'erreur s'il existe
if (isset($_SESSION['error'])) {
  echo '<div id="error" class="error">';
  echo '<div class="error-message">' . $_SESSION['error'] . '<span id="closeButton">X</span></div>';
  echo '</div>';
  unset($_SESSION['error']); // Supprimer le message après l'avoir affiché
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Compagne et Élection UF</title>
  <link rel="stylesheet" href="./dist/css/style.css">
  <style>
    :root {
      --blue: #06bbcc;
      --brown: #333;
      --light-blue: #06bbaa;
      --light-grey: #f4f4f4;
      --text-primary: #181d38;
      --text-secondary: #666;
      --white: #fff;
    }
    .body-greeting {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #1e88e5;
    }

    .greeting-container {
      text-align: center;
      background: var(--white);
      padding: 20px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .body-login {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: var(--light-grey);
    }

    .form-container {
      text-align: center;
      background: var(--white);
      padding: 20px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h1 {
      color: var(--blue);
      margin-bottom: 20px;
    }

    p {
      color: var(--text-secondary);
    }

    .buttons {
      margin-top: 20px;
    }

    .btn {
      display: inline-block;
      text-decoration: none;
      color: var(--white);
      background-color: var(--light-blue);
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      margin: 10px;
      transition: background 0.3s ease;
      cursor: pointer;
    }

    .btn:hover {
      background-color: var(--light-blue);
    }

    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      color: var(--brown);
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
      box-sizing: border-box;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: var(--blue);
      outline: none;
    }
    .error {
      position: relative;
    }
    .error-message {
      position: absolute;
      top: 20px;
      right: 20px;
      color: red;
      background-color: #ffe6e6;
      padding: 10px;
      border: 1px solid red;
      border-radius: 5px;
      text-align: center;
      transition: transform 1s ease;
      transform: translateX(-10%);
    }
    .error-message span {
      position: absolute;
      top: 0;
      right: 2px;
      font-weight: bold;
      cursor: pointer;
      transition: color 3s ease;
      color: red;
    }
    .error-message span:hover {
      color: rgb(248, 7, 7);
    }
  </style>
</head>
<body>
  <div class="body-login">
    <div class="form-container">
      <h1>Connexion</h1>
      <form action="./backend/login_user.php" method="POST">
        <div class="form-group">
          <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Votre email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
        </div>
        <button type="submit" class="btn">Se connecter</button>
      </form>
      <!-- <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p> -->
  	</div>
  </div>
  <script>
    const errorMessage = document.getElementById('error')
    const closeButton = document.getElementById('closeButton')
    if (closeButton) {
      closeButton.addEventListener('click', () => {
        // console.log("Coucou");
        setTimeout(() => {
          errorMessage.style.display = 'none';
        }, 1000);
      })
    }
  </script>
</body>
</html>
