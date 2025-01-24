<?php
include './includes/header.php';
include './includes/sidebar.php';

$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Échec de la connexion à la base de données: " . $conn->connect_error)));
}

// Effectuer la requête SQL pour récupérer les données des candidats depuis la base de données
$sql = "SELECT * FROM candidat";
$result = mysqli_query($conn, $sql);

// Vérifier s'il y a des données retournées
if (mysqli_num_rows($result) > 0) {
    // Afficher les données dans le tableau
    echo '<table id="example1" class="table table-responsive table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th class="sortable">Photo</th>';
    echo '<th class="sortable">Nom</th>';
    echo '<th class="sortable">Prenom</th>';
    echo '<th class="sortable">Partie politique</th>';
    echo '<th class="sortable">Contact</th>';
    echo '<th class="sortable">Numero</th>';
    echo '<th class="sortable">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    // Parcourir les données et afficher chaque ligne dans le tableau
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td class="text-truncate"><img src="' . $row["photo"] . '" alt="Photo du candidat"></td>';
        echo '<td class="text-truncate">' . $row["nom_candidat"] . '</td>';
        echo '<td class="text-truncate">' . $row["prenom_candidat"] . '</td>';
        echo '<td class="text-truncate">' . $row["partie"] . '</td>';
        echo '<td class="text-truncate">' . $row["contact"] . '</td>';
        echo '<td class="text-truncate">' . $row["num_electoral"] . '</td>';
        // Ajouter des boutons d'action si nécessaire
        echo '<td class="action-col">';
        echo '<button class="btn btn-default btn-icon btn-xs tip" title="Editer"><i class="fa fa-edit text-info"></i></button>';
        echo '<button class="btn btn-default btn-icon btn-xs tip" title="Supprimer"><i class="fa fa-trash-o text-danger"></i></button>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    // Si aucune donnée n'est trouvée dans la base de données
    echo "Aucun résultat trouvé";
}

// Fermer la connexion à la base de données
mysqli_close($conn);

include 'footer.php';
?>
