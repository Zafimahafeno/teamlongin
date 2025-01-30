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
        <h1>Liste des PAT</h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-envelope-o"></i>Vue Global</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-box">
                    <h4>VOTANTS PAT</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Fonction</th>
                                <th>Etablissement</th>
                                <th>Dernier Contact</th>
                                <th>Intention de Vote</th>
                                <th>Actions</th>
                            </tr>

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
                            // Vérifier si la connexion est encore active avant d'exécuter la requête
                            if ($conn) {
                                $sql = "SELECT id, nom_votant,prenom, fonction, intentionVote FROM votant WHERE fonction = 'PAT' ORDER BY nom_votant";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr id='row-" . $row['id'] . "'>";
                                        echo "<td>" . htmlspecialchars($row['nom_votant']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['fonction']) . "</td>";
                                        echo "<td>
                                            <select id='vote-" . $row['id'] . "' onchange='updateVote(" . $row['id'] . ", this.value)' class='form-select'>
                                                <option value='favorable'" . ($row['intentionVote'] == 'favorable' ? ' selected' : '') . ">Favorable</option>
                                                <option value='opposant'" . ($row['intentionVote'] == 'opposant' ? ' selected' : '') . ">Opposant</option>
                                                <option value='indécis'" . ($row['intentionVote'] == 'indécis' ? ' selected' : '') . ">Indécis</option>
                                            </select>
                                        </td>";
                                        echo "<td>
                                            <button class='btn btn-success btn-sm' onclick='modifierVotant(" . $row['id'] . ")'>Modifier</button>
                                            <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmModal' onclick='setDeleteId(" . $row['id'] . ")'>Supprimer</button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Aucun votant trouvé.</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Erreur de connexion à la base de données.</td></tr>";
                            }
                            ?>
                        </table>
                    </div>

                    <!-- Modal de Confirmation de Suppression -->
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmModalLabel">Confirmation de Suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer ce votant ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button type="button" class="btn btn-danger"
                                        id="confirmDeleteBtn">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bootstrap JS -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                    </script>

                    <?php
                    // Fermer la connexion à la fin du script
                    if ($conn) {
                        $conn->close();
                    }
                    ?>
    </section>
</div>

<?php
include './includes/footer.php';
?>