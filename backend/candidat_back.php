<?php
// Connexion à la base de données
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ajouter un candidat
if (isset($_POST['submit']) && $_POST['action'] == 'add') {
    $num_electoral = $_POST['num_electoral'];
    $nom_candidat = $_POST['nom_candidat'];
    $prenom_candidat = $_POST['prenom_candidat'];
    $photo_candidat = '';

    // Gérer l'upload de la photo
    if (isset($_FILES['photo_candidat']) && $_FILES['photo_candidat']['error'] == 0) {
        $targetDir = "../uploads/";
        $photo_candidat = $targetDir . basename($_FILES["photo_candidat"]["name"]);
        if (!move_uploaded_file($_FILES["photo_candidat"]["tmp_name"], $photo_candidat)) {
            die("Erreur lors de l'upload de la photo.");
        }
    }

    // Insérer les données dans la base
    $sql = "INSERT INTO candidat (numero, nom, prenom, photo) VALUES ('$num_electoral', '$nom_candidat', '$prenom_candidat', '$photo_candidat')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../view_user.php");
    } else {
        die("Erreur : " . $conn->error);
    }
}

// Modifier un candidat
if (isset($_POST['submit']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $num_electoral = $_POST['num_electoral'];
    $nom_candidat = $_POST['nom_candidat'];
    $prenom_candidat = $_POST['prenom_candidat'];
    $photo_candidat = $_POST['existing_photo']; // Garder la photo existante par défaut

    // Gérer l'upload de la nouvelle photo si elle existe
    if (isset($_FILES['photo_candidat']) && $_FILES['photo_candidat']['error'] == 0) {
        $targetDir = "../uploads/";
        $photo_candidat = $targetDir . basename($_FILES["photo_candidat"]["name"]);
        if (!move_uploaded_file($_FILES["photo_candidat"]["tmp_name"], $photo_candidat)) {
            die("Erreur lors de l'upload de la photo.");
        }
    }

    // Mettre à jour les données
    $sql = "UPDATE candidat SET numero='$num_electoral', nom='$nom_candidat', prenom='$prenom_candidat', photo='$photo_candidat' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../view_user.php?message=Candidat modifié avec succès.");
    } else {
        die("Erreur : " . $conn->error);
    }
}

// Supprimer un candidat
if (isset($_POST['submit']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM candidat WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../view_user.php?message=Candidat supprimé avec succès.");
    } else {
        die("Erreur : " . $conn->error);
    }
}

// Afficher tous les candidats
$sql = "SELECT * FROM candidat";
$result = mysqli_query($conn, $sql);
?>

