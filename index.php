<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Compagne UF</title>
  <link rel="stylesheet" href="./dist/css/style.css">
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
      <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
  	</div>
  </div>
</body>
</html>
