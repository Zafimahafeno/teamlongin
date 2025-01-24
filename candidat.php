<?php
include './includes/header.php';
include './includes/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Liste des Candidats</h1>
        <a href="add_user.php" class="btn btn-primary">Ajouter un nouveau Candidat</a>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-envelope-o"></i>Liste des Candidats</li>
            <li class="active"><i class="fa fa-table"></i> Vue Globale</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-box">
                    <h4>Vue Globale des Listes des candidats</h4>
                    
                    <?php
// Connexion à la base de données - Remplacez les valeurs par les vôtres
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);
// echo 'Connexion à la base de données établie :)';
// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM candidat";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-4">Liste des Candidats</h2>';
    echo '<a href="add_user.php" class="btn btn-primary mb-3">Ajouter un nouveau Candidat</a>';
    echo '<table class="table table-striped table-bordered">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th scope="col">#</th>';
    echo '<th scope="col">Numéro</th>';
    echo '<th scope="col">Nom</th>';
    echo '<th scope="col">Prénom</th>';
    echo '<th scope="col">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Affichage des candidats
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<th scope="row">' . $row["id"] . '</th>';
        echo '<td>' . $row["numero"] . '</td>';
        echo '<td>' . $row["nom"] . '</td>';
        echo '<td>' . $row["prenom"] . '</td>';
        echo '<td>';
        echo '<a href="edit.php?id=' . $row["id"] . '" class="btn btn-warning btn-sm">Éditer</a>';
        echo ' ';
        echo '<a href="delete.php?id=' . $row["id"] . '" class="btn btn-danger btn-sm">Supprimer</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo "Aucun résultat trouvé";
}

$conn->close();
?>

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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clearSenderForm();">×</button>
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
                                            <label class="col-md-4 control-label" style="line-height: 30px;">Sender ID:</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control ctl-name" name="txtSenderId" id="txtSenderId" maxlength="6">
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
                                        <button class="btn btn-primary butt_padd" id="add" onclick="AddSenderId('abbsnl-num','INUSER311');" value="Add">Add</button>
                                        <button type="button" class="btn btn-primary" id="senprocessAdd" style="display: none; margin-left: -10px;">
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
                                                <input type="radio" name="uploadscope0" id="auploadscope" checked="checked">
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
                                                <span class="button" style="padding: 10px 14px; padding-top : 0px;"><i class=" btn-label glyphicon glyphicon-cloud-upload" id="txtrefresh" style="padding: 8px 12px;"></i><label id="">Upload</label><label></label><input type="file" id="attachsenderfile" name="txtFile-name" onchange="addBulkSenderId();"></span>
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
                                        <th>Sender ID</th><th>Privilege</th><th>Status</th><th>Action</th>
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
