<?php
include './includes/header.php';
include './includes/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestion de planning
            <small>Calendrier</small>
            <a href="add_planing.php" class="btn btn-primary">Ajouter un nouveau planning</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
            <li class="active">Gestion de planing</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
        <!-- Calendrier -->
        <div id="calendar"></div>
    </section>
    <!-- /.content --> 
</div>
<!-- /.content-wrapper -->

<?php
include './includes/footer.php';
?>
<!-- Modal pour afficher les détails de la planification -->
<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailsLabel">Détails de la planification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Les détails de la planification seront affichés ici -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Plugin jQuery FullCalendar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

<!-- Script d'initialisation du calendrier -->
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: 'backend/recuperation_event.php',
                dataType: 'json',
                success: function(events) {
                    events.forEach(function(event) {
                        event.start = moment.parseZone(event.start);
                        event.end = moment.parseZone(event.end);
                    });
                    callback(events);
                }
            });
        },
        // Événement déclenché lorsqu'une date est cliquée dans le calendrier
        dayClick: function(date, jsEvent, view) {
            var clickedDate = moment(date).format('YYYY-MM-DD'); // Format de la date cliquée
            // Effectuer une requête AJAX pour obtenir les détails de la planification pour la date cliquée
            $.ajax({
                url: 'backend/details_planification.php',
                type: 'GET',
                data: {
                    date: clickedDate // Envoyer la date cliquée au backend pour récupérer les détails de la planification
                },
                success: function(response) {
                    // Afficher les détails de la planification dans une modal ou une autre zone de la page
                    // Par exemple, vous pouvez utiliser Bootstrap modal pour afficher les détails
                    $('#modalDetails .modal-body').html(response);
                    $('#modalDetails').modal('show'); // Afficher la modal
                },
                error: function(xhr, status, error) {
                    // Gérer les erreurs
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>