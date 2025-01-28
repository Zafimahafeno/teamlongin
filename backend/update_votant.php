<?php
// update_votant.php
header('Content-Type: application/json');

// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion']);
    exit;
}

// Préparer la requête UPDATE
$fields = [
    'nom_votant', 'prenom', 'fonction', 'email', 
    'tel', 'intentionVote', 'DernierContact', 
    'commentaire', 'demarcheEffectue', 'proposition',
    'id_etablissement', 'id_candidat'
];

$updates = [];
$params = [];
$types = '';

foreach ($fields as $field) {
    if (isset($data[$field])) {
        $updates[] = "`$field` = ?";
        $params[] = $data[$field];
        $types .= $field === 'id_etablissement' || $field === 'id_candidat' ? 'i' : 's';
    }
}

if (empty($updates)) {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée à mettre à jour']);
    exit;
}

$sql = "UPDATE votant SET " . implode(', ', $updates) . " WHERE id = ?";
$types .= 'i'; // for id
$params[] = $data['id'];

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

$success = $stmt->execute();

echo json_encode([
    'success' => $success,
    'message' => $success ? 'Mise à jour réussie' : 'Erreur lors de la mise à jour: ' . $stmt->error
]);

$stmt->close();
$conn->close();
?>