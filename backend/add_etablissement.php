<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données envoyées par AJAX
if (isset($_POST['nom'])) {
    $nom = $conn->real_escape_string($_POST['nom']);

    // Insérer le nouvel établissement dans la table
    $sql = "INSERT INTO etablissement (nom) VALUES ('$nom')";
    if ($conn->query($sql) === TRUE) {
        echo "Établissement ajouté avec succès !";
    } else {
        echo "Erreur : " . $conn->error;
    }
} else {
    echo "Nom de l'établissement non spécifié.";
}

$conn->close();
?>
