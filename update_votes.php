<?php
header("Content-Type: application/json");

$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_candidat = $_POST['id_candidat'];
    $fonction_votant = $_POST['fonction_votant'];
    $nombreVote = (int)$_POST['nombreVote'];

    if (!is_numeric($nombreVote) || $nombreVote < 0) {
        echo json_encode(["status" => "error", "message" => "Nombre de votes invalide"]);
        exit;
    }

    $queryCheck = "SELECT * FROM voix WHERE id_candidat = ? AND fonction_votant = ?";
    $stmt = $conn->prepare($queryCheck);
    $stmt->bind_param("is", $id_candidat, $fonction_votant);
    $stmt->execute();
    $resultCheck = $stmt->get_result();

    if ($resultCheck->num_rows > 0) {
        $queryUpdate = "UPDATE voix SET nombreVote = ? WHERE id_candidat = ? AND fonction_votant = ?";
        $stmt = $conn->prepare($queryUpdate);
        $stmt->bind_param("iis", $nombreVote, $id_candidat, $fonction_votant);
        $stmt->execute();
    } else {
        $queryInsert = "INSERT INTO voix (id_candidat, fonction_votant, nombreVote) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($queryInsert);
        $stmt->bind_param("isi", $id_candidat, $fonction_votant, $nombreVote);
        $stmt->execute();
    }

    echo json_encode(["status" => "success", "message" => "Vote mis à jour"]);
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
}
?>