<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Envoyer un message</title>
  
</head>
<body>
  
  <?php include 'header.php'; ?>
  <?php include 'sidebar.php'; ?>

  <div class="alert-container"></div>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        MESSAGE
        <small>Veuillez remplir le formulaire de message ci-dessous</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
        <li class="active">Message</li>
      </ol>
    </section>

    <section class="content container-fluid">
      <form id="smsForm">
        <div class="form-group">
            <label for="expediteur">Nom de l'expéditeur :</label>
            <input type="text" id="expediteur" name="expediteur" required>
        </div>
        <div class="form-group">
            <label for="destinataires">Numéros des destinataires (séparés par des virgules) :</label>
            <input type="text" id="destinataires" name="destinataires" required>
        </div>
        <div class="form-group">
            <label for="message">Message à envoyer :</label>
            <textarea id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
      </form>
    </section>

  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
<style>
/* styles.css */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    margin-top: 5px;
}

button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

</style>
<script>
document.getElementById('smsForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Fetch form values
    var expediteur = document.getElementById('expediteur').value;
    var destinataires = document.getElementById('destinataires').value.split(','); // Splitting multiple recipients by comma
    var message = document.getElementById('message').value;

    // Constructing the payload for Sinch API
    var payload = {
      "from": expediteur,
      "to": destinataires,
      "body": message
    };

    // Sending the payload to Sinch API using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "backend/messageback.php");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("Authorization", "Bearer a7591a9b549e4b99941ccf34e557242d");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          // Successful response, you can handle it here
          console.log("Message sent successfully!");
        } else {
          // Error handling
          console.error("Failed to send message. Status code: " + xhr.status);
        }
      }
    };
    xhr.send(JSON.stringify(payload));
});
</script>
