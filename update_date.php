<?php
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['DernierContact'])) {
    $id = intval($_POST['id']);
    $dernierContact = $_POST['DernierContact'];

    $sql = "UPDATE votant SET DernierContact = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $dernierContact, $id);

    if ($stmt->execute()) {
        echo "Mise à jour réussie.";
    } else {
        echo "Erreur lors de la mise à jour.";
    }

    $stmt->close();
}

$conn->close();
?>
