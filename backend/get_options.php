<?php
// get_options.php
header('Content-Type: application/json');

$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connexion échouée']));
}

$type = $_GET['type'] ?? '';
$result = [];

switch ($type) {
    case 'id_etablissement':
        $sql = "SELECT id_etablissement, nom FROM etablissement ORDER BY nom";
        break;
    case 'id_candidat':
        $sql = "SELECT id_candidat, numero,prenom, nom FROM candidat ORDER BY numero";
        break;
    default:
        die(json_encode(['error' => 'Type invalide']));
}

$query = $conn->query($sql);
while ($row = $query->fetch_assoc()) {
    $result[] = $row;
}

echo json_encode($result);
$conn->close();
?>