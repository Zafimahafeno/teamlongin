<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
include './includes/header.php';
include './includes/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Liste des utilisateurs</h1>
        <a href="add_utilisateur.php" class="btn btn-primary">Ajouter un nouvel utilisateur</a>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-envelope-o"></i>Liste des utilisateurs</li>
            <li class="active"><i class="fa fa-table"></i> Vue Globale</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Liste des utilisateurs</h4>
                </div>
                <div class="card-body" style="padding: 10px;">
                    <div class="row" style="">
                        <?php
                        // Connexion à la base de données
                        include './config/db.php';

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Effectuer la requête SQL pour récupérer les données des utilisateurs
                        $sql = "SELECT * FROM assistant";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="border col-md-4 mb-4" style="border: 1px solid #ddd; width: 300px; padding: 10px;">'; // Colonne pour chaque carte
                                echo '<div class="card shadow-sm border-0 h-100">'; // Début de la carte
                                echo '<div class="card-body">';
                                
                                // Récupérer et afficher la photo de profil
                                $photoProfil = $row["photoProfil"];
                                if (!empty($photoProfil)) {
                                  echo '<div class="text-center">';
                                    echo '<img src="./backend/uploads/' . htmlspecialchars($photoProfil) . '" alt="Photo de profil" class="rounded-circle" style="width:100px; height:100px; object-fit:cover; border-raduis: 50% !important;">';
                                  echo '</div>';
                                } else {
                                    echo '<img src="./dist/img/user.png" alt="Photo de profil par défaut" class="rounded-circle mb-3" style="width:100px; height:100px; border-raduis: 50% !important;">';
                                }

                                // Afficher les informations de l'utilisateur
                                echo '<h5 class="card-title mb-0"><strong class="text-muted">Nom et prénom :</strong> ' . htmlspecialchars($row["nom"]) . ' ' . htmlspecialchars($row["prenom"]) . '</h5>';
                                echo '<p class="text-muted"><strong>Email :</strong> ' . htmlspecialchars($row["email"]) . '</p>';
                                echo '<p class="text-success"><strong>Statut :</strong> ' . ($row["statut"] == 1 ? 'Actif' : 'Inactif') . '</p>';

                                // Boutons d'action
                                echo '<div class="d-flex justify-content-between gap-2">';
                                echo '<button class="btn btn-info btn-sm me-2" title="Éditer"><i class="fa fa-edit"></i> Éditer</button>';
                                echo '<button class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash-o"></i> Supprimer</button>';
                                echo '</div>';

                                echo '</div>'; // Fin du body de la carte
                                echo '</div>'; // Fin de la carte
                                echo '</div>'; // Fin de la colonne
                            }
                        } else {
                            echo '<div class="alert alert-warning text-center w-100">Aucun utilisateur trouvé</div>';
                        }

                        // Fermer la connexion
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- content -->
</div>
<!-- content-wrapper -->

<!-- Add Sender ID Modal -->
<div id="addsender_inbound" class="modal fade in" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <!-- Modal Header -->
            <div class="modal-header btn-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                    onclick="clearSenderForm();">×</button>
                <h4 class="modal-title"><i class="icon-notification"></i><span id="heading">Add Sender ID</span></h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body with-padding">
                <div class="alert alert-danger fade in block-inner" style="display: none;" id="sendererrid">
                    <button type="button" class="close" onclick="clearSenderForm();">×</button>
                    <i class="icon-cancel-circle"></i>
                    <span id="sendererraction"></span>
                </div>
                <div class="alert alert-success fade in block-inner" style="display: none;" id="sendersuccess">
                    <button type="button" class="close" onclick="clearSenderForm();">×</button>
                    <i class="icon-checkmark-circle"></i>
                    <span id="senderpassaction"></span>
                </div>
                <div id="addSenderIdContentForm">
                    <div id="xSender">
                        <div class="form-horizontal1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" style="line-height: 30px;">Sender
                                                ID:</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control ctl-name" name="txtSenderId"
                                                    id="txtSenderId" maxlength="6">
                                                <div style="color: #FF0000;" id="errorSendertext"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="scope" id="scope">
                                            <option value="1">Allowed</option>
                                            <option value="0">Blocked</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary butt_padd" id="add"
                                            onclick="AddSenderId('abbsnl-num','INUSER311');" value="Add">Add</button>
                                        <button type="button" class="btn btn-primary" id="senprocessAdd"
                                            style="display: none; margin-left: -10px;">
                                            <i class="fa fa-spinner fa-spin"></i> Processing</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-8 smart-form">
                                    <div class="form-group">
                                        <div class="inline-group">
                                            <label class="radio" style="margin-right: 15px; margin-left: 20px;">
                                                <input type="radio" name="uploadscope0" id="auploadscope"
                                                    checked="checked">
                                                <i></i>All
                                            </label>
                                            <label class="radio" style="margin-right: 15px;">
                                                <input type="radio" name="uploadscope0" id="buploadscope">
                                                <i></i>Alpha
                                            </label>
                                            <label class="radio" style="margin-right: 15px;">
                                                <input type="radio" name="uploadscope0" id="cuploadscope">
                                                <i></i>Numeric
                                            </label>
                                            <label class="radio" style="margin-right: 15px;">
                                                <input type="radio" name="uploadscope0" id="duploadscope">
                                                <i></i>AlphaNumeric
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="demo-btn text-right" style="margin-top: -6px;">
                                        <section class="smart-form">
                                            <div class="input input-file">
                                                <span class="button" style="padding: 10px 14px; padding-top : 0px;"><i
                                                        class=" btn-label glyphicon glyphicon-cloud-upload"
                                                        id="txtrefresh" style="padding: 8px 12px;"></i><label
                                                        id="">Upload</label><label></label><input type="file"
                                                        id="attachsenderfile" name="txtFile-name"
                                                        onchange="addBulkSenderId();"></span>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable_fixed_column">
                                <thead>
                                    <tr>
                                        <th>Sender ID</th>
                                        <th>Privilege</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer1"></div>
                </div>
            </div>
            <!-- Modal Footer -->
            <input type="hidden" name="txtHiddenUserId" value="abbsnl-num" id="txtHiddenUserId">
            <input type="hidden" name="txtHiddenSystemId" value="INUSER311" id="txtHiddenSystemId">
            <!-- <div class="modal-footer">
            </div> -->
        </div>
    </div>
</div>

<!-- Preview Modal for IP Address -->
<div id="addipaddress_inbound" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <!-- Modal Content -->
</div>

<!-- Preview Modal for Key -->
<div id="addkey_inbound" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <!-- Modal Content -->
</div>

<?php
include './includes/footer.php';
?>