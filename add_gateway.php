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

		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
			<li class="active">Ajout d'un nouveau votant</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content container-fluid">

		<div class="row">

			<div class="col-md-12">
				<header role="heading">
					<ul class="nav nav-tabs pull-left in">

						<li id="personalinfo1" class="">
							<a data-toggle="tab" href="#personalinfo"> <i class="fa fa-lg fa-info-circle"></i> <span
									class="hidden-mobile hidden-tablet">Information sur le votant</span> </a>
						</li>

					</ul>
				</header>
			</div>

			<div class="col-md-12">

				<div class="chart-box">


					<form action="backend/votant_back.php" method="post" id="contact-form" novalidate="novalidate"
						onsubmit="verify();">
						<div class="tab-content">

							<div class="tab-pane active" id="personalinfo">
								<div class="tabbable tabs-below">
									<div class="tab-content padding-10">
										<div class="tab-pane active" id="AA11">
											<div class="smart-form">
												<div class="fieldset">
													<div class="row">
														<section class="col col-md-6">
															<label class="label">Nom<font color="red">*</font></label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="nom_votant" value="" id="nom_votant"
																	placeholder="Nom du votant">
																<div style="color: #FF0000;"></div>
															</label>
														</section>
														<section class="col col-md-6">
															<label class="label">Prénom</label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="prenom" value=""
																	id="prenom" placeholder="Prenom du votant">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>
												</div>
												<div class="fieldset">
													<div class="row">
														<section class="col col-md-6">
															<label class="label">Fonction<font color="red">*</font>
																</label>
															<label class="select">
																<select name="fonction" id="fonction" required>
																	<option value="" disabled selected>Choisir une
																		fonction</option>
																	<option value="Enseignant">Enseignant</option>
																	<option value="PAT">PAT</option>
																</select>
																<i></i>
															</label>
															<div style="color: #FF0000;"></div>
														</section>

														<section class="col col-md-6">
															<label class="label">Établissement</label>
															<label class="select">
																<!-- Liste déroulante avec recherche -->
																<select name="id_etablissement" id="id_etablissement"
																	class="select2" style="width: 100%;" required>
																	<option value="" disabled selected>Choisir un
																		établissement</option>
																	<!-- Les options seront chargées dynamiquement -->
																</select>
															</label>
															<div style="color: #FF0000;"></div>

															<!-- Champ pour ajouter un nouvel établissement -->
															<div id="new_etablissement"
																style="display: none; margin-top: 15px;">
																<label class="label">Nouvel établissement</label>
																<label class="input">
																	<i class="icon-append fa fa-plus"></i>
																	<input type="text" name="new_etablissement"
																		id="new_etablissement_input"
																		placeholder="Nom de l'établissement" />
																</label>
																<button id="add_etablissement_btn" type="button"
																	style="margin-top: 10px;">Ajouter</button>
															</div>
														</section>

													</div>
												</div>
												<div class="fieldset">
													<div class="row">
														<section class="col col-md-6">
															<label class="label">Email<font color="red">*</font></label>
															<label class="input">
																<i class="icon-append fa fa-envelope"></i>
																<input type="text" name="email" value=""
																	id="email" placeholder="Adresse email">
															</label>
															<!-- <div style="color: #FF0000;"></div> -->
														</section>
														<section class="col col-md-6">
															<label class="label">Téléphone</label>
															<label class="input">
																<i class="icon-append fa fa-phone"></i>
																<input type="text" name="tel" value=""
																	id="tel" placeholder="Contact du votant">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>
												</div>
												<div class="fieldset">
													<div class="row">

														<section class="col col-md-6">
															<label class="label">Intention de vote<font color="red">*
																</font></label>
															<label class="select">
																<select name="intentionVote" id="intentionVote" required>
																	<option value="" disabled selected>Intention de vote
																	</option>
																	<option value="Favorable">Favorable</option>
																	<option value="Indécis">Indécis</option>
																	<option value="Opposant">Opposant</option>
																</select>
																<i></i>
															</label>
															<div style="color: #FF0000;"></div>
														</section>
														<section class="col col-md-6">
															<label class="label">Dernier contact</label>
															<label class="input">
																<!-- <i class="icon-append fa fa-image"></i> -->
																<input type="date" name="DernierContact" value=""
																	id="DernierContact" placeholder="Contact du votant">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>
												</div>
												<div class="fieldset">
													<div class="row">
														<section class="col col-md-6">
															<label class="label">Commentaire<font color="red">*</font>
																</label>
															<label class="input">
																<i class="icon-append fa fa-comment"></i>
																<input type="text" name="commentaire" value=""
																	id="commentaire" placeholder="Commentaire...">
															</label>
															<!-- <div style="color: #FF0000;"></div> -->
														</section>
														<section class="col col-md-6">
															<label class="label">Démarche effectuée</label>
															<label class="input">
																<i class="icon-append fa fa-tasks"></i>
																<input type="text" name="demarcheEffectue" value=""
																	id="demarcheEffectue"
																	placeholder="Démarche effectuée">
															</label>
															<!-- <div style="color: #FF0000;"></div> -->
														</section>
													</div>
												</div>
												<div class="fieldset">
													<div class="row">
														<section class="col col-md-6">
															<label class="label">Proposition<font color="red">*</font>
																</label>
															<label class="input">
																<i class="icon-append fa fa-comments"></i>
																<input type="text" name="proposition" value=""
																	id="proposition"
																	placeholder="Description de la proposition">
															</label>
															<!-- <div style="color: #FF0000;"></div> -->
														</section>
														<section class="col col-md-6">
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
																</select>
																<i></i>
															</label>
															<div style="color: #FF0000;"></div>
														</section>


													</div>
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

<?php

include './includes/footer.php';
?>