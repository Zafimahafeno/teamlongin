  <!-- Main Footer -->
  <footer class="main-footer dark-bg">
    <!-- <div class="pull-right hidden-xs">DEVELOPED BY Origami Tech</div> -->
    Copyright &copy; 2025 Origami Tech. Tous droits réservés. </footer>
</div>
<!-- wrapper --> 

<!-- jQuery --> 
<script src="dist/js/jquery.min.js"></script> 
<script src="bootstrap/js/bootstrap.min.js"></script> 

<script src="dist/js/chosen.jquery.min.js"></script>
<script src="dist/js/chosen.order.jquery.min.js"></script>
<script src="dist/js/jquery.maskedinput.min.js"></script> 
<script src="dist/js/ovio.js"></script> 
<script src="dist/js/select2.min.js"></script> 
<script src="dist/js/main.js"></script>
<!-- DataTables -->
<script src="dist/js/jquery.dataTables.min.js"></script>
<script src="dist/js/dataTables.bootstrap.min.js"></script>
<!-- charts --> 



<script src="plugins/stepform/jq.stepform.js"></script>


<script>
  $(function () {
    $('#example1, #example3').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
    
</script>


<!-- Script pour activer Select2 et gérer l'affichage du champ -->
<script>
    $(document).ready(function () {
        // Initialiser Select2
        $('#id_etablissement').select2({
            placeholder: "Choisir un établissement",
            allowClear: true,
        });

        // Charger les établissements existants
        function loadEtablissements() {
            $.ajax({
                url: './backend/get_etablissements.php',
                type: 'GET',
                success: function (response) {
                    $('#id_etablissement').html(response).trigger('change'); // Mise à jour de la liste
                },
                error: function () {
                    alert("Erreur lors du chargement des établissements !");
                },
            });
        }

        // Charger les établissements au chargement de la page
        loadEtablissements();

        // Afficher le champ "Ajouter un autre établissement" si l'option correspondante est sélectionnée
        $('#id_etablissement').on('change', function () {
            if ($(this).val() === 'other') {
                $('#new_etablissement').show();
            } else {
                $('#new_etablissement').hide();
            }
        });

        // Ajouter un nouvel établissement
        $('#add_etablissement_btn').on('click', function () {
            const newEtablissement = $('#new_etablissement_input').val();
            if (newEtablissement.trim() === '') {
                alert('Veuillez entrer un nom pour le nouvel établissement.');
                return;
            }

            $.ajax({
                url: './backend/add_etablissement.php',
                type: 'POST',
                data: { nom: newEtablissement },
                success: function () {
                    $('#new_etablissement_input').val(''); // Réinitialiser le champ
                    $('#new_etablissement').hide(); // Cacher le champ
                    loadEtablissements(); // Recharger la liste des établissements
                },
                error: function () {
                    alert("Erreur lors de l'ajout de l'établissement !");
                },
            });
        });
    });
</script>




</body>
</html>