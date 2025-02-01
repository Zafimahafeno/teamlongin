<?php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $votant_id = $_POST["votant_id"];
    $date_presence = $_POST["date_presence"];
    $statut = $_POST["statut"];

    // Insertion des nouvelles données dans la table "presences"
    $stmt = $conn->prepare("INSERT INTO presences (votant_id, date_presence, statut) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $votant_id, $date_presence, $statut);

    if ($stmt->execute()) {
        echo "Données insérées avec succès.";
    } else {
        echo "Erreur lors de l'insertion des données.";
    }
}
?>
