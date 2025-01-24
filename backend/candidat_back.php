<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "./config/db.php";

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Récupérer tous les candidats
        $stmt = $pdo->prepare("SELECT * FROM candidat");
        $stmt->execute();
        $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($candidats);
        break;

    case 'POST': // Ajouter un candidat
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['nom'], $data['prenom'], $data['numero'])) {
            $stmt = $pdo->prepare("INSERT INTO candidat (nom, prenom, numero) VALUES (?, ?, ?)");
            $stmt->execute([$data['nom'], $data['prenom'], $data['numero']]);
            echo json_encode(["message" => "Candidat ajouté avec succès.", "id" => $pdo->lastInsertId()]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides."]);
        }
        break;

    case 'DELETE': // Supprimer un candidat
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM candidat WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(["message" => "Candidat supprimé avec succès."]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "ID non spécifié."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Méthode non autorisée."]);
        break;
}
?>
