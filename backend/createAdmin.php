<?php

require_once '../config/db.php';

header("Content-Type: application/json; charset=UTF-8");

if (!isset($conn)) {
  http_response_code(500);
  echo json_encode(["message" => "Erreur : La connexion à la base de données n'a pas été établie."]);
  exit;
}

try {
    // Récupération des données envoyées via POST (JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification des champs obligatoires
    if (!isset($data['nom'], $data['prenom'], $data['email'], $data['motDePasse'])) {
        http_response_code(400);
        echo json_encode(["message" => "Tous les champs (nom, prénom, email, mot de passe) sont obligatoires."]);
        exit;
    }

    // Préparer et valider les données
    $nom = htmlspecialchars($data['nom']);
    $prenom = htmlspecialchars($data['prenom']);
    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $motDePasse = password_hash($data['motDePasse'], PASSWORD_BCRYPT); // Hachage du mot de passe

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

    // Vérifier si l'email existe déjà
    $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(["message" => "Cet email est déjà utilisé."]);
        exit;
    }

    // Insérer dans la base de données
    $stmt = $conn->prepare("INSERT INTO admin (nom, prenom, email, motDePasse) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $motDePasse]);

    // Réponse de succès
    http_response_code(201);
    echo json_encode([
        "message" => "Administrateur créé avec succès.",
        "administrateur" => [
            "id" => $conn->lastInsertId(),
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email
        ]
    ]);

} catch (PDOException $e) {
    // Gestion des erreurs
    http_response_code(500);
    echo json_encode(["message" => "Une erreur serveur est survenue." . $e->getMessage()]);
}
?>
