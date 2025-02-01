<?php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $votant_id = $_POST["votant_id"];
    $date_presence = $_POST["date_presence"];
    $statut = $_POST["statut"];

    // Vérifier si une présence existe déjà pour ce votant à cette date
    $stmt = $conn->prepare("SELECT id FROM presences WHERE votant_id = ? AND date_presence = ?");
    $stmt->bind_param("is", $votant_id, $date_presence);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mise à jour du statut si une présence existe déjà
        $stmt = $conn->prepare("UPDATE presences SET statut = ? WHERE votant_id = ? AND date_presence = ?");
        $stmt->bind_param("sis", $statut, $votant_id, $date_presence);

        if ($stmt->execute()) {
            echo "Présence mise à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    } else {
        // Insérer un nouvel enregistrement si aucun n'existe
        $stmt = $conn->prepare("INSERT INTO presences (votant_id, date_presence, statut) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $votant_id, $date_presence, $statut);

        if ($stmt->execute()) {
            echo "Nouvelle présence enregistrée avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement.";
        }
    }
}
?>
