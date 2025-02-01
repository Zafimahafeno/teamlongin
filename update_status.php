<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Non autorisé");
}

$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

if (isset($_POST['votant_id']) && isset($_POST['statut'])) {
    $votant_id = $_POST['votant_id'];
    $statut = $_POST['statut'];
    $date = date('Y-m-d');

    // Vérifier si une présence existe déjà pour aujourd'hui
    $check_sql = "SELECT id FROM presences WHERE votant_id = ? AND date_presence = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("is", $votant_id, $date);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Mettre à jour la présence existante
        $sql = "UPDATE presences SET statut = ? WHERE votant_id = ? AND date_presence = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $statut, $votant_id, $date);
    } else {
        // Insérer une nouvelle présence
        $sql = "INSERT INTO presences (votant_id, date_presence, statut) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $votant_id, $date, $statut);
    }

    if ($stmt->execute()) {
        echo "Statut mis à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Données manquantes";
}

$conn->close();
?>