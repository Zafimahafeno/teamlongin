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
.nav-tabs {
  display: flex;
  align-items: center;
}

.btn-group .btn {
  padding: 0.375rem 0.75rem;
  font-size: 0.9rem;
}

.btn-group .btn.active {
  background-color: #0d6efd;
  color: white;
  border-color: #0d6efd;
}

.btn-outline-primary:hover:not(.active) {
  background-color: rgba(13, 110, 253, 0.1);
}

@media (max-width: 768px) {
  .btn-group .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
  }
}
</style>
<style>
  .form-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
  }

  .form-container section {
    flex: 1 1 48%; /* 2 colonnes flexibles */
    min-width: 280px; /* Assurer une bonne lisibilité sur mobile */
  }

  .hidden {
    display: none !important;
  }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">

		<ol class="breadcrumb">
			<li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
			<li class="active">Ajout d'un nouveau votant</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content container-fluid">

		<div class="row">

			<div class="col-md-12">
			<header role="heading">
				<ul class="nav nav-tabs">
					<li id="personalinfo1" class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#personalinfo">
						<i class="fa fa-lg fa-info-circle"></i>
						<span class="hidden-mobile hidden-tablet">Information sur le votant</span>
					</a>
					</li>
					<li class="nav-item ms-3 d-flex align-items-center">
						<form action="backend/votant_back.php" method="post" id="contact-form" novalidate="novalidate"
								onsubmit="verify();">
						<div class="btn-group" role="group" aria-label="Type de votant">
							<button type="button" class="btn btn-outline-primary" onclick="selectVoterType('Enseignant', this)">
							Enseignant
							</button>
							<button type="button" class="btn btn-outline-primary" onclick="selectVoterType('PAT', this)">
							PAT
							</button>
						</div>
					</li>
				</ul>
			</header>


			</div>

			<div class="col-md-12">

				<div class="chart-box">


						<div class="tab-content">

							<div class="tab-pane active" id="personalinfo">
								<div class="tabbable tabs-below">
									<div class="tab-content padding-10">
										<div class="tab-pane active" id="AA11">
											<div class="smart-form">
											<div class="fieldset form-container">
												<section>
												<label class="label">Grade de l'enseignant<font color="red">*</font></label>
												<label class="input">
													<i class="icon-append fa fa-user"></i>
													<input type="text" name="grade_enseignant" id="grade_enseignant" placeholder="Grade de l'enseignant">
												</label>
												</section>

												<section>
												<label class="label">IM</label>
												<label class="input">
													<i class="icon-append fa fa-user"></i>
													<input type="text" name="IM" id="IM" placeholder="IM">
												</label>
												</section>

												<section>
												<label class="label">Nom<font color="red">*</font></label>
												<label class="input">
													<i class="icon-append fa fa-user"></i>
													<input type="text" name="nom_votant" id="nom" placeholder="Nom du votant">
												</label>
												</section>

												<section>
												<label class="label">Prénom</label>
												<label class="input">
													<i class="icon-append fa fa-user"></i>
													<input type="text" name="prenom" id="prenom" placeholder="Prénom du votant">
												</label>
												</section>

												<section>
												<label class="label">Corps</label>
												<label class="input">
													<i class="icon-append fa fa-user"></i>
													<input type="text" name="corps" id="corps" placeholder="Corps">
												</label>
												</section>

												<section>
												<label class="label">Établissement</label>
												<label class="select">
													<select name="id_etablissement" id="id_etablissement" class="select2" required>
													<option value="" disabled selected>Choisir un établissement</option>
													</select>
												</label>
												</section>

												<section>
												<!-- <label class="label">Email<font color="red">*</font></label>
												<label class="input">
													<i class="icon-append fa fa-envelope"></i>
													<input type="email" name="email" id="email" placeholder="Adresse email">
												</label>
												</section> -->

												<section>
												<label class="label">Téléphone</label>
												<label class="input">
													<i class="icon-append fa fa-phone"></i>
													<input type="tel" name="tel" id="tel" placeholder="Téléphone">
												</label>
												</section>

												<!-- <section>
												<label class="label">Intention de vote<font color="red">*</font></label>
												<label class="select">
													<select name="intentionVote" id="intentionVote" required>
													<option value="" disabled selected>Intention de vote</option>
													<option value="Favorable">Favorable</option>
													<option value="Indécis">Indécis</option>
													<option value="Opposant">Opposant</option>
													</select>
												</label>
												</section> -->

												<!-- <section>
												<label class="label">Dernier contact</label>
												<label class="input">
													<input type="date" name="DernierContact" id="DernierContact">
												</label>
												</section> -->

												<section>
												<label class="label">Commentaire<font color="red">*</font></label>
												<label class="input">
													<i class="icon-append fa fa-comment"></i>
													<input type="text" name="commentaire" id="commentaire" placeholder="Commentaire...">
												</label>
												</section>
												<!-- <section class="col col-md-6">
															<label class="label">Candidat<font color="red">*</font>
																</label>
															<label class="select">
																<select name="id_candidat" id="id_candidat" required>
																	<option value="" disabled selected>Choisir un
																		candidat</option>
																	<?php
																	// Inclure le fichier backend pour récupérer les candidats
																	include './backend/candidat_back.php';

																	// Vérifier si la requête a renvoyé des résultats
																	if ($result && mysqli_num_rows($result) > 0) {
																		// Parcourir les résultats et créer une option pour chaque candidat
																		while ($row = mysqli_fetch_assoc($result)) {
																			echo '<option value="' . $row['id'] . '">' . 'Candidat N° ' . htmlspecialchars($row['numero']) . ' : ' . htmlspecialchars($row['nom']) . ' ' . htmlspecialchars($row['prenom']) . '</option>';
																		}
																	} else {
																		echo '<option value="" disabled>Aucun candidat disponible</option>';
																	}
																	?>
																</select> -->
																<i></i>
															</label>
															<div style="color: #FF0000;"></div>
														</section>
											</div>

												<div class="fieldset">
													<div class="row">
														<div class="col-md-12 text-right">
															<div class="col-lg-12">
																<footer>
																	<button type="submit" name="submit"
																		class="btn btn-danger">Annuler</button>

																	<button type="submit" name="submit"
																		class="btn btn-primary"
																		id="createuser">Enregistrer</button>
																	<button type="button" class="btn btn-primary"
																		id="processAdd" style="display: none;">
																		<i class="fa fa-spinner fa-spin"></i>
																		Traitement...</button>
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
	<!-- content -->
</div>
<!-- content-wrapper -->


</div>
<script>
function selectVoterType(type, button) {
  // Retire la classe active de tous les boutons
  const buttons = button.parentElement.getElementsByTagName('button');
  Array.from(buttons).forEach(btn => btn.classList.remove('active'));

  // Ajoute la classe active au bouton cliqué
  button.classList.add('active');

  // Sélectionne la section contenant le champ "Corps"
  const corpsSection = document.getElementById('corps').closest('section');
  
  // Récupère l'input pour la fonction
  const fonctionInput = document.getElementById('fonction');

  // Cache ou affiche le champ "Corps" en fonction du type sélectionné
  if (type === 'enseignant') {
    corpsSection.style.display = 'none';
    // Remplir le champ "fonction" avec "Enseignant"
    fonctionInput.value = 'Enseignant';
  } else {
    corpsSection.style.display = 'block';
    // Remplir le champ "fonction" avec "PAT"
    fonctionInput.value = 'PAT';
  }

  console.log(`Type de votant sélectionné : ${type}`);
}
</script>



<?php

include './includes/footer.php';
?>