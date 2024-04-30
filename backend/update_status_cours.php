<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérifier si les données ont été envoyées via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs requis sont présents
    if (isset($_POST['taskId'])) {
        // Préparer la requête SQL avec une instruction préparée
        $sql = "UPDATE tache SET status='Validation' WHERE id=?";

        // Préparer l'instruction SQL
        $stmt = $conn->prepare($sql);

        // Vérifier si la préparation a réussi
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        // Lier les paramètres à la requête
        $stmt->bind_param("i", $_POST['taskId']);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Le statut de la tâche a été mis à jour avec succès";
        } else {
            echo "Erreur lors de la mise à jour du statut de la tâche : " . $stmt->error;
        }

        // Fermer l'instruction
        $stmt->close();
    } else {
        echo "Les données envoyées sont incomplètes.";
    }
} else {
    echo "La méthode de requête HTTP n'est pas prise en charge.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
