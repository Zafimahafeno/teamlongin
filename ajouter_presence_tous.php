<?php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die("Échec de connexion : " . $conn->connect_error);
}

$date_presence = date("Y-m-d");

// Insérer tous les votants qui n'ont pas encore une présence aujourd'hui
$sql = "INSERT INTO presences (votant_id, date_presence, statut)
        SELECT v.id, '$date_presence', 'Absent'
        FROM votant v
        WHERE NOT EXISTS (
            SELECT 1 FROM presences p WHERE p.votant_id = v.id AND p.date_presence = '$date_presence'
        )";

if ($conn->query($sql) === TRUE) {
    echo "Présences ajoutées pour tous les votants.";
} else {
    echo "Erreur : " . $conn->error;
}
?>
