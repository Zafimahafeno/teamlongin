<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Non autorisé";
    exit;
}

$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

$votant_id = $_POST['votant_id'];
$statut = $_POST['statut'];
$date_presence = date('Y-m-d');

// Vérifier si une entrée existe déjà pour ce votant aujourd'hui
$check_sql = "SELECT * FROM presences WHERE votant_id = ? AND date_presence = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("is", $votant_id, $date_presence);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    // Mettre à jour le statut
    $update_sql = "UPDATE presences SET statut = ? WHERE votant_id = ? AND date_presence = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sis", $statut, $votant_id, $date_presence);
    if ($update_stmt->execute()) {
        echo "Statut mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du statut.";
    }
} else {
    // Insérer une nouvelle entrée
    $insert_sql = "INSERT INTO presences (votant_id, date_presence, statut) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iss", $votant_id, $date_presence, $statut);
    if ($insert_stmt->execute()) {
        echo "Présence enregistrée avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de la présence.";
    }
}

$conn->close();
?>