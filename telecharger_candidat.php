<?php
require_once('fpdf.php');

class CandidatsPDF extends FPDF {
    // En-tête de page
    function Header() {
        // Logo (à adapter selon vos besoins)
        // $this->Image('logo.png', 10, 6, 30);
        
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        
        // Titre
        $this->Cell(0, 15, 'LISTES DES ENSEIGNANTS', 0, 1, 'C');
        
        // Date d'impression
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 5, 'Date d\'impression : ' . date('d/m/Y'), 0, 1, 'R');
        
        // Saut de ligne
        $this->Ln(10);
    }

    // Pied de page
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Fonction pour créer l'en-tête du tableau
    function CreateTableHeader() {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(40, 80, 155);
        $this->SetTextColor(255, 255, 255);
        
        // En-têtes des colonnes avec largeurs optimisées
        $headers = array(
            array('text' => 'Nom', 'width' => 35),
            array('text' => 'Prénom', 'width' => 35),
            array('text' => 'Fonction', 'width' => 30),
            array('text' => 'Établissement', 'width' => 30),
            array('text' => 'Contact', 'width' => 25),
            array('text' => 'Intention de vote', 'width' => 30),
            array('text' => 'Dernier Contact', 'width' => 35),
            array('text' => 'Commentaire', 'width' => 35)
        );

        foreach ($headers as $header) {
            $this->Cell($header['width'], 10, utf8_decode($header['text']), 1, 0, 'C', true);
        }
        $this->Ln();
    }
}

// Connexion à la base de données
try {
    $conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");
    if ($conn->connect_error) {
        throw new Exception("Erreur de connexion : " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

// Création du PDF
$pdf = new CandidatsPDF('L', 'mm', 'A4');
$pdf->AliasNbPages(); // Pour la numérotation des pages
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// Création de l'en-tête du tableau
$pdf->CreateTableHeader();

// Requête SQL
$sql = "SELECT v.*, e.nom AS nom_etablissement
FROM votant v
LEFT JOIN etablissement e ON v.id_etablissement = e.id_etablissement
WHERE v.fonction = 'enseignant';
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rowCount = 0;
    $pdf->SetFont('Arial', '', 8);
    
    while ($row = $result->fetch_assoc()) {
        // Alternance des couleurs de fond
        $pdf->SetFillColor($rowCount % 2 == 0 ? 245 : 255, $rowCount % 2 == 0 ? 245 : 255, $rowCount % 2 == 0 ? 245 : 255);
        $pdf->SetTextColor(0, 0, 0);

        // Calcul de la hauteur maximale pour la ligne   
        $lineHeight = 6;

        // Affichage des données avec des largeurs correspondant aux en-têtes
        $pdf->Cell(35, $lineHeight, utf8_decode($row['nom_votant']), 1, 0, 'L', true);
        $pdf->Cell(35, $lineHeight, utf8_decode($row['prenom']), 1, 0, 'L', true);
        $pdf->Cell(30, $lineHeight, utf8_decode($row['fonction']), 1, 0, 'L', true);
        $pdf->Cell(30, $lineHeight, utf8_decode($row['nom_etablissement'] ?? 'N/A'), 1, 0, 'L', true);
        $pdf->Cell(25, $lineHeight, utf8_decode($row['tel']), 1, 0, 'C', true);
        $pdf->Cell(30, $lineHeight, utf8_decode($row['intentionVote']), 1, 0, 'C', true);
        $pdf->Cell(35, $lineHeight, utf8_decode($row['DernierContact']), 1, 0, 'C', true);
        $pdf->Cell(35, $lineHeight, utf8_decode($row['commentaire']), 1, 0, 'C', true);

        $pdf->Ln();
        $rowCount++;

        // Vérification de l'espace restant sur la page
        if ($pdf->GetY() > 180) {
            $pdf->AddPage();
            $pdf->CreateTableHeader();
        }
    }
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Aucun votant trouvé dans la base de données.', 0, 1, 'C');
}

// Fermeture de la connexion
$conn->close();

// Génération du PDF
$pdf->Output('D', 'Liste_des_Enseignants_' . date('Y-m-d') . '.pdf');
?>