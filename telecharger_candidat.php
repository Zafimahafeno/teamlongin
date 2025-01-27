<?php
// Inclure la bibliothèque FPDF
require_once('fpdf.php');  // Assurez-vous que le chemin vers fpdf.php est correct

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

// Créer une instance de FPDF
$pdf = new FPDF();
$pdf->SetAutoPageBreak(true, 15); // Activation du saut de page automatique avec marge de 15mm
$pdf->AddPage(); // Ajouter une page

// Définir la police pour le titre
$pdf->SetFont('Arial', 'B', 16);

// Ajouter un titre
$pdf->Cell(0, 10, 'Liste des Candidats', 0, 1, 'C');

// Saut de ligne
$pdf->Ln(10);

// Définir la police pour les données
$pdf->SetFont('Arial', '', 12);

// Afficher les en-têtes des colonnes
$pdf->Cell(40, 10, 'Numero', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nom', 1, 0, 'C');
$pdf->Cell(60, 10, 'Prenom', 1, 0, 'C');
$pdf->Cell(50, 10, 'Photo', 1, 1, 'C'); // Dernière cellule avec un saut de ligne

// Remplir les données du tableau
$sql = "SELECT numero, nom, prenom, photo FROM candidat";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $numero_candidat = htmlspecialchars($row['numero']);
        $nom_candidat = htmlspecialchars($row['nom']);
        $prenom_candidat = htmlspecialchars($row['prenom']);
        $photo_candidat = htmlspecialchars($row['photo']);  // Photo (nom du fichier ou URL)

        // Afficher les données dans le tableau
        $pdf->Cell(40, 10, $numero_candidat, 1, 0, 'C');
        $pdf->Cell(60, 10, $nom_candidat, 1, 0, 'C');
        $pdf->Cell(60, 10, $prenom_candidat, 1, 0, 'C');
        $pdf->Cell(50, 10, $photo_candidat, 1, 1, 'C');  // Affiche le nom du fichier photo
    }
} else {
    // Si aucun candidat trouvé
    $pdf->Cell(0, 10, 'Aucun candidat trouvé.', 0, 1, 'C');
}

// Fermer la connexion à la base de données
mysqli_close($conn);

// Générer et télécharger le PDF
$pdf->Output('D', 'liste_candidats.pdf');  // 'D' pour télécharger le fichier
?>
