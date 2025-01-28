<?php
// get_vote_data.php
header('Content-Type: application/json');

$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$sql = "SELECT 
    e.nom AS etablissement,
    v.intentionVote,
    COUNT(v.id) AS nombre_votants,
    v.fonction
FROM votant v
JOIN etablissement e ON v.id_etablissement = e.id
GROUP BY e.nom, v.intentionVote, v.fonction
ORDER BY e.nom, v.fonction, v.intentionVote;";

$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etablissement = $row['etablissement'];
        $fonction = strtoupper($row['fonction']);
        $fonction = ($fonction === 'ENSEIGNANT' || $fonction === 'PROF') ? 'Enseignant' : $fonction;
        $intention = ucfirst(strtolower(trim($row['intentionVote'])));
        $nombre_votants = (int)$row['nombre_votants'];

        if (!isset($data[$etablissement])) {
            $data[$etablissement] = [
                'PAT' => ['Indécis' => 0, 'Opposant' => 0, 'Favorable' => 0],
                'Enseignant' => ['Indécis' => 0, 'Opposant' => 0, 'Favorable' => 0]
            ];
        }

        if (isset($data[$etablissement][$fonction]) && 
            array_key_exists($intention, $data[$etablissement][$fonction])) {
            $data[$etablissement][$fonction][$intention] = $nombre_votants;
        }
    }
}

$conn->close();
echo json_encode($data);
?>