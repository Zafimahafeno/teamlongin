<?php
session_start();
header('Content-Type: application/json');

// Vérification de la session
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    error_log("Accès refusé - utilisateur non connecté");
    echo json_encode(["success" => false, "message" => "Accès refusé"]);
    exit;
}

// Connexion à la base de données avec gestion des erreurs
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");
    $conn->set_charset("utf8mb4");
    error_log("Connexion à la base de données réussie.");
} catch (Exception $e) {
    error_log("Erreur de connexion MySQL : " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Échec de la connexion à la base de données"]);
    exit;
}

// Vérification des données reçues
$data = json_decode(file_get_contents("php://input"), true);
error_log("Données reçues : " . json_encode($data));

if (!isset($data['id']) || !is_numeric($data['id'])) {
    error_log("ID invalide : " . ($data['id'] ?? 'non défini'));
    echo json_encode(["success" => false, "message" => "ID invalide"]);
    exit;
}

$id = intval($data['id']);
$nom = htmlspecialchars($data['nom'] ?? '', ENT_QUOTES, 'UTF-8');
$prenom = htmlspecialchars($data['prenom'] ?? '', ENT_QUOTES, 'UTF-8');
$fonction = htmlspecialchars($data['fonction'] ?? '', ENT_QUOTES, 'UTF-8');
$id_etablissement = isset($data['id_etablissement']) && is_numeric($data['id_etablissement']) ? intval($data['id_etablissement']) : null;
$email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
$tel = htmlspecialchars($data['tel'] ?? '', ENT_QUOTES, 'UTF-8');
$intentionVote = htmlspecialchars($data['intentionVote'] ?? '', ENT_QUOTES, 'UTF-8');
$DernierContact = htmlspecialchars($data['DernierContact'] ?? '', ENT_QUOTES, 'UTF-8');
$commentaire = htmlspecialchars($data['commentaire'] ?? '', ENT_QUOTES, 'UTF-8');
$demarcheEffectue = htmlspecialchars($data['demarcheEffectue'] ?? '', ENT_QUOTES, 'UTF-8');
$proposition = htmlspecialchars($data['proposition'] ?? '', ENT_QUOTES, 'UTF-8');

error_log("Données après filtrage : ID=$id, Nom=$nom, Prénom=$prenom, Email=$email, Téléphone=$tel");

// Préparation de la requête
$sql = "UPDATE votant SET 
            nom_votant = ?, 
            prenom = ?, 
            fonction = ?, 
            id_etablissement = ?, 
            email = ?, 
            tel = ?, 
            intentionVote = ?, 
            DernierContact = ?, 
            commentaire = ?, 
            demarcheEffectue = ?, 
            proposition = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("Erreur de préparation MySQL : " . $conn->error);
    echo json_encode(["success" => false, "message" => "Erreur interne"]);
    exit;
}

$stmt->bind_param(
    "sssssssssssi",
    $nom,
    $prenom,
    $fonction,
    $id_etablissement,
    $email,
    $tel,
    $intentionVote,
    $DernierContact,
    $commentaire,
    $demarcheEffectue,
    $proposition,
    $id
);

if ($stmt->execute()) {
    error_log("Mise à jour réussie pour l'ID $id.");
    echo json_encode(["success" => true, "message" => "Mise à jour réussie"]);
} else {
    error_log("Erreur d'exécution MySQL : " . $stmt->error);
    echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour"]);
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
error_log("Connexion fermée.");
?>
