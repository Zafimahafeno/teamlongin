<?php
// Connexion à la base de données (remplacez les informations par les vôtres)
$conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupérer les candidats depuis la base de données
$sql_candidats = "SELECT id, nom FROM candidat";
$result_candidats = $conn->query($sql_candidats);


?>

<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>

<div class="content-wrapper"> 
    <section class="content-header">
        <h1>Ajout de nouveau vote </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active">Ajout de nouveau vote </li>
        </ol>
    </section>
    
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-box">
                    <form action="backend/add_vote_back.php" method="post" id="contact-form" novalidate="novalidate" onsubmit="verify();">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalinfo">
                                <div class="tabbable tabs-below">
                                    <div class="tab-content padding-10">
                                        <div class="tab-pane active" id="AA11">
                                            <div class="smart-form">
                                                <div class="fieldset">
                                                    <div class="row">
                                                        <section class="col col-md-6">
                                                            <label class="label">Nombre<font color="red">*</font></label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-user"></i>
                                                                <input type="text" name="nombre" value="" id="nombre" placeholder="Nombre de voie dans une zone" maxlength="49">
                                                                <div style="color: #FF0000;"></div>
                                                            </label>
                                                        </section>
                                                        <section class="col col-md-6">
                                                            <label class="label">Candidat</label>
                                                            <label class="select">
                                                                <select name="id_candidat">
                                                                    <?php 
                                                                    // Afficher les options des candidats
                                                                    if ($result_candidats->num_rows > 0) {
                                                                        while($row = $result_candidats->fetch_assoc()) {
                                                                            echo "<option value='".$row["id"]."'>".$row["nom"]."</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </label>
                                                        </section>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="fieldset">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <div class="col-lg-12">
                                                                <footer>
                                                                    <a href="view_user.php"><button type="button" name="cancel" class="btn btn-danger">Annuler</button></a>
                                                                    <button type="submit" name="submit" class="btn btn-primary" id="createuser">Enregistrer</button>
                                                                    <button type="button" class="btn btn-primary" id="processAdd" style="display: none;">
                                                                        <i class="fa fa-spinner fa-spin"></i> Processing
                                                                    </button>
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
