<?php
include 'header.php';
include 'sidebar.php';
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
                    
                    <div class="bind box1 table-responsive">
                        <table id="example1" class="table table-responsive table-bordered">
						<?php

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
        echo '<td class="text-truncate"><img src="uploads/' . $row["photo"] . '" alt="Photo du candidat"width="100" height="100"></td>';
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

?>

                        </table>
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
include 'footer.php';
?>
