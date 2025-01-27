<?php
include './includes/header.php';
include './includes/sidebar.php';

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

// Récupérer l'ID du candidat à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour obtenir les détails du candidat
    $sql = "SELECT * FROM candidat WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Aucun candidat trouvé.");
    }
} else {
    die("Aucun ID spécifié.");
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active">Modification du candidat</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <header role="heading">
                    <ul class="nav nav-tabs pull-left in">
                        <li id="personalinfo1" class="">
                            <a data-toggle="tab" href="#personalinfo"> <i class="fa fa-lg fa-info-circle"></i> <span class="hidden-mobile hidden-tablet">Information sur le Candidat</span> </a>
                        </li>
                    </ul>
                </header>
            </div>

            <div class="col-md-12">
                <div class="chart-box">
                    <form action="backend/candidat_back.php" method="post" id="contact-form" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                        <div class="tab-content">
                            <div class="tab-pane active" id="personalinfo">
                                <div class="tabbable tabs-below">
                                    <div class="tab-content padding-10">
                                        <div class="tab-pane active" id="AA11">
                                            <div class="smart-form">
                                                <div class="fieldset">

                                                    <!-- Numero sur la liste Electorale -->
                                                    <div class="row">
                                                        <section class="col col-md-12">
                                                            <label class="label">Numero sur la liste Electorale<font color="red">*</font></label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-sort-numeric-asc"></i>
                                                                <input type="text" name="num_electoral" value="<?php echo htmlspecialchars($row['numero']); ?>" id="num_electoral" placeholder="Numero du candidat sur la liste Electorale" maxlength="49">
                                                            </label>
                                                        </section>
                                                    </div>

                                                    <!-- Nom -->
                                                    <div class="row">
                                                        <section class="col col-md-12">
                                                            <label class="label">Nom<font color="red">*</font></label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-user"></i>
                                                                <input type="text" name="nom_candidat" value="<?php echo htmlspecialchars($row['nom']); ?>" id="nom_candidat" placeholder="Nom du candidat" maxlength="49">
                                                            </label>
                                                        </section>
                                                    </div>

                                                    <!-- Prénom -->
                                                    <div class="row">
                                                        <section class="col col-md-12">
                                                            <label class="label">Prénom<font color="red">*</font></label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-user"></i>
                                                                <input type="text" name="prenom_candidat" value="<?php echo htmlspecialchars($row['prenom']); ?>" id="prenom_candidat" placeholder="Prenom du candidat" maxlength="49">
                                                            </label>
                                                        </section>
                                                    </div>

                                                    <!-- Photo -->
                                                    <div class="row">
                                                        <section class="col col-md-12">
                                                            <label class="label">Photo du candidat</label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-camera"></i>
                                                                <input type="file" name="photo_candidat" id="photo_candidat" accept="image/*">
                                                            </label>
                                                            <div class="existing-photo">
                                                                <?php if (!empty($row['photo'])): ?>
                                                                    <img src="backend/uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo actuelle" style="width: 100px; height: 100px; border-radius: 5px;">
                                                                <?php else: ?>
                                                                    <p>Aucune photo disponible</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </section>
                                                    </div>

                                                </div>

                                                <!-- Boutons pour Annuler et Soumettre -->
                                                <div class="fieldset">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <div class="col-lg-12">
                                                                <footer>
                                                                    <a href="view_user.php">
                                                                        <button type="button" name="cancel" class="btn btn-danger">Annuler</button>
                                                                    </a>
                                                                    <button type="submit" name="submit" class="btn btn-primary">Enregistrer</button>
                                                                </footer>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include './includes/footer.php'; ?>
