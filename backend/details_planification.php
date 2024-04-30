<?php
// Connexion à la base de données
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Vérifier si la date est passée en paramètre
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    // Requête SQL pour récupérer les détails de la planification pour la date cliquée
    $query = "SELECT * FROM planing WHERE date_event = '$date'";

    // Exécution de la requête
    $result = mysqli_query($conn, $query);

    // Vérifier s'il y a des résultats
    if (mysqli_num_rows($result) > 0) {
        // Affichage des détails de la planification dans un formulaire
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <form>
                <div class="form-group">
                    <label>Titre de l'événement</label>
                    <input type="text" class="form-control" value="<?php echo $row['titre']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Lieu</label>
                    <input type="text" class="form-control" value="<?php echo $row['lieu']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Date de l'événement</label>
                    <input type="text" class="form-control" value="<?php echo $row['date_event']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Heure</label>
                    <input type="TIME" class="form-control" value="<?php echo $row['heure']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Acteur</label>
                    <input type="text" class="form-control" value="<?php echo $row['acteur']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" value="<?php echo $row['description']; ?>" readonly>
                </div>
                <!-- Ajoutez d'autres champs de formulaire pour d'autres détails de la planification si nécessaire -->
            </form>
            <?php
            // Insérer une ligne rouge après chaque formulaire
    echo '<hr style="border-top: 5px solid red;">';
        }
    } else {
        echo "Aucune planification trouvée pour la date spécifiée.";
    }
} else {
    echo "Date non spécifiée.";
}
?>
