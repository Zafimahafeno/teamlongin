<?php
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Échec de la connexion à la base de données: " . $conn->connect_error)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $echeance = $_POST['echeance'];
    $priorite = $_POST['priorite'];
    $status = $_POST['status']; // Assurez-vous que le champ "status" existe dans votre formulaire HTML
    $responsable = $_POST['responsable'];
    $lieu = $_POST['lieu'];

    $query = "INSERT INTO tache (titre, description, echeance, priorite, status, responsable, lieu) VALUES ('$titre', '$description', '$echeance', '$priorite', '$status', '$responsable', '$lieu')";

    if ($conn->query($query) === TRUE) {
        // Redirection vers tache.php
        header("Location: ../tache.php");
        exit(); // Assurez-vous de quitter le script après la redirection
    } else {
        echo json_encode(array("success" => false, "message" => "Erreur lors de la création de la tâche: " . $conn->error));
    }
} else {
    $query = "SELECT * FROM tache";
    $result = $conn->query($query);
    $tasks = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }

    echo json_encode(array("success" => true, "tasks" => $tasks));
}

$conn->close();
?>
