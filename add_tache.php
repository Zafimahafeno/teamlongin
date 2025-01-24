<?php
include './includes/header.php';
include './includes/sidebar.php';
?>
<head>
    <style>
        /* Style du modal */
        .modal {
            display: none; /* Par défaut, le modal est caché */
            position: fixed; /* Position fixe pour couvrir toute la fenêtre */
            z-index: 1; /* Position en avant des autres éléments */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Ajout de défilement si nécessaire */
            background-color: rgba(0,0,0,0.4); /* Fond semi-transparent */
        }

        /* Contenu du modal */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Centrer le modal verticalement et horizontalement */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* Bouton de fermeture */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestion de tâche
            <small>Tâche par individu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active">Gestion de tâche</li>
        </ol>
    </section>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalText"></p>
            <button id="modalOkButton" class="btn btn-primary">OK</button>
        </div>
    </div>

    <!-- Main content -->
    <section class="content container-fluid">
        <!-- Formulaire pour créer une nouvelle tâche -->
        <form action="backend/tache_backend.php" method="post" id="contact-form" novalidate="novalidate" onsubmit="verify();">
            <div class="tab-content">

                <div class="tab-pane active" id="personalinfo">
                    <div class="tabbable tabs-below">
                        <div class="tab-content padding-10">
                            <div class="tab-pane active" id="AA11">
                                <div class="smart-form">
                                    <div class="fieldset">
                                        <div class="row">
                                            <section class="col col-md-6">
                                                <label class="label">Titre<font color="red">*</font></label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-task"></i>
                                                    <input type="text" name="titre" value="" id="titre" placeholder="Titre" maxlength="49">
                                                    <div style="color: #FF0000;"></div>
                                                </label>
                                            </section>
                                            <section class="col col-md-6">
                                                <label class="label">Description</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="description" value="" id="description" placeholder="Description du tâche" maxlength="49">
                                                </label>
                                                <div style="color: #FF0000;"></div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="fieldset">
                                        <div class="row">
                                            <section class="col col-md-6">
                                                <label class="label">Date d'echéance<font color="red">*</font></label>
                                                <label class="input">
                                                    <input type="date" name="echeance" value="" id="echeance" placeholder="Date d'echéance du tâche" maxlength="49">
                                                </label>
                                                <div style="color: #FF0000;"></div>
                                            </section>
                                            <section class="col col-md-6">
                                                <label class="label">Status</label>
                                                <label class="select">
                                                    <select id="status" name="status" required>
                                                        <option value="En attente">En attente</option>
                                                        <option value="En cours">En cours</option>
                                                        <option value="Validation">Validation</option>
                                                        <option value="Terminée">Terminée</option>
                                                    </select>
                                                    <i></i>
                                                </label>
                                                <div style="color: #FF0000;"></div>
                                            </section>
                                        </div>
                                    </div>
                                    <section class="col col-md-6">
                                        <label class="label">Niveau de priorité</label>
                                        <label class="select">
                                            <select id="priorite" name="priorite" required>
                                                <option value="Moyen">Moyen</option>
                                                <option value="Élevée">Élevée</option>
                                                <option value="Urgent">Urgent</option>
                                            </select>
                                            <i></i>
                                        </label>
                                        <div style="color: #FF0000;"></div>
                                    </section>

                                    <section class="col col-md-6">
                                        <label class="label">Responsable<font color="red">*</font></label>
                                        <label class="input">
                                            <input type="text" name="responsable" value="" id="responsable" placeholder="Responsable du tâche" maxlength="49">
                                        </label>
                                        <div style="color: #FF0000;"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="label">Lieu<font color="red">*</font></label>
                                        <label class="input">
                                            <input type="text" name="lieu" value="" id="lieu" placeholder="Lieu pour effectuer la tâche" maxlength="49">
                                        </label>
                                        <div style="color: #FF0000;"></div>
                                    </section>
                                </div>
                                <div style="color: #FF0000;"></div>
                            </div>
                            <div class="fieldset">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <div class="col-lg-12">
                                            <footer>
                                                <button type="submit" name="submit" class="btn btn-danger">Cancel</button>
                                                <button type="submit" name="submit" class="btn btn-primary" id="createuser">Create</button>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>	
    </section>
</div>
<script>
    document.getElementById('taskForm').addEventListener('submit', function(event) {
        document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch('backend/tache_backend.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.success) {
            document.getElementById('modalText').innerText = 'Tâche créée avec succès';
            document.getElementById('myModal').style.display = 'block';
            getTasks();
        } else {
            document.getElementById('modalText').innerText = 'Erreur lors de la création de la tâche';
            document.getElementById('myModal').style.display = 'block';
        }
    });
});


    document.getElementById('modalOkButton').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'none';
    });

    function getTasks() {
        fetch('backend/tache_backend.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('taskList').innerHTML = '';
            data.tasks.forEach(task => {
                var taskElement = document.createElement('div');
                taskElement.innerHTML = `
                    <p><strong>${task.titre}</strong></p>
                    <p>${task.description}</p>
                    <p>Date d'échéance : ${task.echeance}</p>
                    <p>Priorité : ${task.priorite}</p>
                    <hr>
                `;
                document.getElementById('taskList').appendChild(taskElement);
            });
        });
    }

    getTasks();

</script>
