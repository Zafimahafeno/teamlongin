<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $id_candidat = $_POST["id_candidat"];
    
    // Vérifier si le candidat a déjà des votes
    $check_sql = "SELECT id FROM voix WHERE id_candidat = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id_candidat);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Le candidat existe déjà, faire une mise à jour
        $update_sql = "UPDATE voix SET nombreVote = nombreVote + ? WHERE id_candidat = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $nombre, $id_candidat);
        
        if ($update_stmt->execute()) {
            header("Location: ../statistique_votes.php?success=1");
        } else {
            header("Location: ../statistique_votes.php?error=1");
        }
        $update_stmt->close();
    } else {
        // Nouveau candidat, faire une insertion
        $insert_sql = "INSERT INTO voix (nombreVote, id_candidat) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $nombre, $id_candidat);
        
        if ($insert_stmt->execute()) {
            header("Location: ../statistique_votes.php?success=1");
        } else {
            header("Location: ../statistique_votes.php?error=1");
        }
        $insert_stmt->close();
    }
    
    $check_stmt->close();
    $conn->close();
}
?>