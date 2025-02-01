<?php
if (isset($_POST['id_presence']) && isset($_POST['newDate'])) {
    $id_presence = $_POST['id_presence'];
    $newDate = $_POST['newDate'];

    // Connexion à la base de données
    $conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

    if ($conn->connect_error) {
        die("Échec de connexion : " . $conn->connect_error);
    }

    // Mise à jour de la date de présence dans la base de données
    $sql = "UPDATE presences SET date_presence = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newDate, $id_presence);
    $stmt->execute();

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();

    echo "Date de présence mise à jour";
}
?>
