<?php
require_once '../config/db.php';

header("Content-Type: application/json; charset=UTF-8");

if (!isset($conn)) {
    http_response_code(500);
    echo json_encode(["message" => "Erreur : La connexion à la base de données n'a pas été établie."]);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['nom'], $data['prenom'], $data['email'], $data['motDePasse'])) {
        http_response_code(400);
        echo json_encode(["message" => "Tous les champs (nom, prénom, email, mot de passe) sont obligatoires."]);
        exit;
    }

    $nom = htmlspecialchars($data['nom']);
    $prenom = htmlspecialchars($data['prenom']);
    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $motDePasse = password_hash($data['motDePasse'], PASSWORD_BCRYPT);

    if (!$email) {
        http_response_code(400);
        echo json_encode(["message" => "L'adresse email est invalide."]);
        exit;
    }

    if (strlen($nom) > 50 || strlen($prenom) > 50) {
        http_response_code(400);
        echo json_encode(["message" => "Le nom et le prénom ne doivent pas dépasser 50 caractères."]);
        exit;
    }

    // Vérification de l'existence de l'email
    $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(409);
        echo json_encode(["message" => "Cet email est déjà utilisé."]);
        exit;
    }

    // Insertion dans la base de données
    $stmt = $conn->prepare("INSERT INTO admin (nom, prenom, email, motDePasse) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $prenom, $email, $motDePasse);
    $stmt->execute();

    http_response_code(201);
    echo json_encode([
        "message" => "Administrateur créé avec succès.",
        "administrateur" => [
            "id" => $stmt->insert_id,
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Une erreur serveur est survenue : " . $e->getMessage()]);
}

