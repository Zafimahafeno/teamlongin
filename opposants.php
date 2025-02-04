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

<style>
    .table-responsive {
    overflow-x: auto;
    white-space: nowrap;
}
th, td {
    text-align: center;
    vertical-align: middle;
}

.dataTables_filter {
    margin-bottom: 15px; /* Ajoute de l'espace sous la barre de recherche */
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 10px; /* Espacement du champ de recherche */
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}


</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Liste des votants opposants</h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-envelope-o"></i>Vue Global</li>
            <!-- <li class="active"><i class="fa fa-table"></i> Liste</li> -->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-box">
                    <h4>Votants</h4>
                    <!-- Ajout des boutons de filtrage -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <!-- <label><input type="radio" name="colorRadio" checked="checked" value="bind"> All</label>
                                <label><input type="radio" name="colorRadio" value="other"> Active</label> -->
                               
                                <button class="btn btn-primary" onclick="window.location.href='telecharger_candidat.php'" title="Télécharger en fichier pdf">
                                    <i class="fas fa-download"></i>
                                </button>
                                                                                                                    
                            </div>
                        </div>
                    </div>
                   
                    <!-- Tableau responsive pour afficher les données -->
                    <div class="table-responsive">
    <table id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th class="sortable">Nom</th>
                <th class="sortable">Prénom</th>
                <th class="sortable">Fonction</th>
                <th class="sortable">Établissement</th>
                <th class="sortable">Intention de vote</th>
                <th class="sortable">Dernier contact</th>
                <th class="sortable">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connexion à la base de données
            $conn = new mysqli("mysql-mahafeno.alwaysdata.net", "mahafeno", "antso0201", "mahafeno_longin");

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Échec de la connexion à la base de données: " . $conn->connect_error);
            }

            // Requête SQL avec jointure pour l'établissement
            $sql = "SELECT v.*, e.nom as nom_etablissement 
        FROM votant v 
        LEFT JOIN etablissement e ON v.id_etablissement = e.id_etablissement 
        WHERE  v.intentionVote = 'opposant' 
        ORDER BY v.nom_votant";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // echo "<tr id='row-" . $row['IM'] . "'>";
                    echo "<td data-field='nom_votant'>" . htmlspecialchars($row["nom_votant"]) . "</td>";
                    echo "<td data-field='prenom'>" . htmlspecialchars($row["prenom"]) . "</td>";
                    echo "<td data-field='fonction'>" . htmlspecialchars($row["fonction"]) . "</td>";
                    echo "<td data-field='id_etablissement'>" . htmlspecialchars($row["nom_etablissement"] ?? "Aucun établissement") . "</td>";
                    echo "<td>
                        <select id='vote-" . $row['id'] . "' onchange='updateVote(" . $row['id'] . ", this.value)' class='form-select'>
                            <option value='favorable'" . ($row['intentionVote'] == 'favorable' ? ' selected' : '') . ">Favorable</option>
                            <option value='opposant'" . ($row['intentionVote'] == 'opposant' ? ' selected' : '') . ">Opposant</option>
                            <option value='indécis'" . ($row['intentionVote'] == 'indécis' ? ' selected' : '') . ">Indécis</option>
                        </select>
                    </td>";
                    echo "<td>
                        <input type='date' id='date-" . $row['id'] . "' value='" . htmlspecialchars($row['DernierContact']) . "' 
                        onchange='updateDate(" . $row['id'] . ", this.value)' class='form-control'>
                    </td>";
                    echo "<td class='action-col'>";
                    echo "<label>";
                    echo "<a href='#' class='btn btn-default btn-icon btn-xs tip detail-btn' 
                    data-nom='" . $row["nom_votant"] . "' 
                    data-prenom='" . $row["prenom"] . "' 
                    data-fonction='" . $row["fonction"] . "' 
                    data-etablissement='" . ($row["nom_etablissement"] ? $row["nom_etablissement"] : "Aucun établissement") . "' 
                   
                    data-tel='" . $row["tel"] . "' 
                    data-vote='" . $row["intentionVote"] . "' 
                    data-derniercontact='" . $row["DernierContact"] . "' 
                    data-commentaire='" . $row["commentaire"] . "' 
                    
                    title='Info' data-toggle='modal' data-target='#detailModal'>
                    <i class='fa fa-info-circle'></i>
                </a>";
                                                echo "</label>";
                    echo "<label>";
                    echo "<a href='./backend/update_votant.php?id=" . $row["id"] . "' class='btn btn-default btn-icon btn-xs tip' title='Modifier' rel='tooltip' data-toggle='tooltip' data-placement='top' data-original-title='Modifier'>";
                    echo "<i class='fa fa-edit text-info'></i>";
                    echo "</a>";
                    echo "</label>";
                    echo "<label>";
                    echo "<a href='delete_votant.php?id=" . $row["id"] . "' class='btn btn-default btn-icon btn-xs tip' title='Supprimer' rel='tooltip' data-toggle='modal' data-placement='top' data-original-title='Supprimer' onclick='getDelSmppClient(\"" . $row["id"] . "\", \"" . $row["nom_votant"] . "\");'>";
                    echo "<i class='fa fa-trash-o text-danger'></i>";
                    echo "</a>";
                    echo "</label>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Aucune donnée disponible</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
                </div>
            </div>
        </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Détails du votant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <table class="table table-bordered">
                    <tbody>
                        <!-- <tr>
                            <th style="width: 30%;">IM</th>
                            <td id="modalId"></td>
                        </tr> -->
                        <tr>
                            <th style="width: 30%;">Nom</th>
                            <td id="modalNom"></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Prénom</th>
                            <td id="modalPrenom"></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Fonction</th>
                            <td id="modalFonction"></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Établissement</th>
                            <td id="modalEtablissement"></td>
                        </tr>
                       
                        <tr>
                            <th style="width: 30%;">Téléphone</th>
                            <td id="modalTel"></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Intention de vote</th>
                            <td id="modalVote"></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Dernier contact</th>
                            <td id="modalDernierContact"></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Commentaire</th>
                            <td id="modalCommentaire"></td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

    <!-- content --> 
</div>
<!-- content-wrapper --> 
<script>
   $(document).ready(function() {
    $(".detail-btn").click(function() {
        // Récupération des données depuis les attributs data-*
        // var IM = $(this).data("IM");
        var nom = $(this).data("nom");
        var prenom = $(this).data("prenom");
        var fonction = $(this).data("fonction");
        var etablissement = $(this).data("etablissement");
        var email = $(this).data("email");
        var tel = $(this).data("tel");
        var vote = $(this).data("vote");
        var dernierContact = $(this).data("derniercontact");
        var commentaire = $(this).data("commentaire");
        var demarcheEffectue = $(this).data("demarcheeffectue");
        var proposition = $(this).data("proposition");

        // Injection des données dans le modal
        $("#modalNom").text(nom);
        $("#modalPrenom").text(prenom);
        $("#modalFonction").text(fonction);
        $("#modalEtablissement").text(etablissement);
        $("#modalEmail").text(email);
        $("#modalTel").text(tel);
        $("#modalVote").text(vote);
        $("#modalDernierContact").text(dernierContact);
        $("#modalCommentaire").text(commentaire);
        $("#modalDemarcheEffectue").text(demarcheEffectue);
        $("#modalProposition").text(proposition);
    });
});

</script>

<script>
                        let deleteId = null;

                        function setDeleteId(id) {
                            deleteId = id;
                            document.getElementById("confirmDeleteBtn").onclick = function () {
                                supprimerVotant(deleteId);
                            };
                        }

                        function updateVote(id, newVote) {
                            fetch('update_vote.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'id=' + id + '&vote=' + newVote
                            })
                                .then(response => response.text())
                                .then(data => {
                                    if (data === 'success') {
                                        alert('Vote mis à jour avec succès');
                                    } else {
                                        alert('Erreur lors de la mise à jour');
                                    }
                                });
                        }

                        function modifierVotant(id) {
                            window.location.href = 'modifier_votant.php?id=' + id;
                        }

                        function supprimerVotant(id) {
                            fetch('supprimer_votant.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'id=' + id
                            })
                                .then(response => response.text())
                                .then(data => {
                                    if (data === 'success') {
                                        document.getElementById('row-' + id).remove();
                                        alert('Votant supprimé avec succès');
                                    } else {
                                        alert('Erreur lors de la suppression');
                                    }
                                });

                            let modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
                            modal.hide();
                        }

                        function updateDate(id, newDate) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "update_date.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log("Mise à jour réussie : " + xhr.responseText);
                                }
                            };

                            xhr.send("id=" + id + "&DernierContact=" + newDate);
                        }

                        $(document).ready(function() {
    $('#example1').DataTable({
        "language": {
            "search": "Rechercher :",
            "lengthMenu": "Afficher _MENU_ entrées",
            "zeroRecords": "Aucune donnée trouvée",
            "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            }
        },
        "autoWidth": false, // Désactive l'ajustement automatique de la largeur
        "responsive": true // Rend le tableau plus fluide
    });
});


                    </script>


<script src="./includes/updateVotant.js"></script>
<?php
include './includes/footer.php';
?>
