<?php
// Connexion à la base de données
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les données des votants
$sql = "
    SELECT 
        e.nom AS etablissement,
        v.intentionVote,
        COUNT(v.id) AS nombre_votants,
        v.fonction
    FROM votant v
    JOIN etablissement e ON v.id_etablissement = e.id
    GROUP BY e.nom, v.intentionVote, v.fonction
    ORDER BY e.nom, v.fonction, v.intentionVote;
";

$result = $conn->query($sql);

// Tableau pour stocker les données
$data = [];

// Vérifier si la requête a retourné des résultats
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Organiser les données par établissement et fonction de votant
        $etablissement = $row['etablissement'];
        
        // Normalisation de la fonction
        $fonction = strtoupper($row['fonction']); // Convertir en majuscules
        if ($fonction === 'ENSEIGNANT' || $fonction === 'PROF') {
            $fonction = 'Enseignant';  // Normaliser 'ENSEIGNANT' ou 'PROF' en 'Enseignant'
        }
        
        // Normalisation de l'intention de vote
        $intention = ucfirst(strtolower(trim($row['intentionVote']))); // Mettre la première lettre en majuscule et le reste en minuscule, en enlevant les espaces inutiles

        // Affichage pour déboguer les valeurs récupérées
        echo "Valeur récupérée : $etablissement - $fonction - $intention - Nombre de votants : " . $row['nombre_votants'] . "<br>";

        $nombre_votants = $row['nombre_votants'];

        // Initialiser les données pour l'établissement si ce n'est pas déjà fait
        if (!isset($data[$etablissement])) {
            $data[$etablissement] = [
                'PAT' => ['Indécis' => 0, 'Opposant' => 0, 'Favorable' => 0],
                'Enseignant' => ['Indécis' => 0, 'Opposant' => 0, 'Favorable' => 0]
            ];
        }

        // Vérifier si la fonction et l'intention existent et ajouter les données
        if (isset($data[$etablissement][$fonction])) {
            // Vérifier si l'intention de vote existe et ajouter
            if (array_key_exists($intention, $data[$etablissement][$fonction])) {
                $data[$etablissement][$fonction][$intention] += $nombre_votants;
            } else {
                // Si l'intention de vote est invalide, afficher un avertissement
                echo "Avertissement : Intention de vote '$intention' invalide pour $etablissement, $fonction.<br>";
            }
        } else {
            // Si la fonction n'est pas valide, afficher un avertissement
            echo "Avertissement : Fonction '$fonction' invalide pour $etablissement.<br>";
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner les données sous forme de JSON
echo json_encode($data);
?>
