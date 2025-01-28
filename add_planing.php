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


<div class="modal" id="myModal">
	<div class="modal-content">
		<span class="close">&times;</span>
		<p id="modalText"></p>
		<button id="modalOkButton" class="btn btn-primary">OK</button>
	</div>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Gestion de planning
			<small>Ajout de nouveau planning</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
			<li class="active">Ajout de nouveau planing</li>
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
									class="hidden-mobile hidden-tablet">Information sur le planing</span> </a>
						</li>

					</ul>
				</header>
			</div>

			<div class="col-md-12">

				<div class="chart-box">


					<form action="backend/add_planing_back.php" method="post" id="contact-form" novalidate="novalidate"
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
															<label class="label">Titre de l'événement<font color="red">*
																</font></label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="titre" value="" id="titre"
																	placeholder="Titre" maxlength="49">
																<div style="color: #FF0000;"></div>
															</label>
														</section>
														<section class="col col-md-6">
															<label class="label">Lieu</label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="lieu" value="" id="lieu"
																	placeholder="Lieu de l'evenement" maxlength="49">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>
												</div>
												<div class="fieldset">
													<div class="row">
														<section class="col col-md-6">
															<label class="label">Date de l'evenement<font color="red">*
																</font></label>
															<label class="input">

																<input type="date" name="date_event" value=""
																	id="date_event" placeholder="Date de l'evenement"
																	maxlength="49">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
														<section class="col col-md-6">
															<label class="label">Heure</label>
															<label class="input">

																<input type="Time" name="heure" value="" id="heure"
																	placeholder="Heure de l'evenement" maxlength="49">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>
												</div>
												<section class="col col-md-6">
													<label class="label">Responsable</label>
													<label class="input">
														<i class="icon-append fa fa-user"></i>
														<input type="text" name="acteur" value="" id="acteur"
															placeholder="Nom des acteur(separé par des virgules)"
															maxlength="49">
													</label>
													<div style="color: #FF0000;"></div>
												</section>
												<section class="col col-md-6">
													<label class="label">Objectif</label>
													<label class="input">
														<i class="icon-append fa fa-user"></i>
														<input type="text" name="description" value="" id="description"
															placeholder="Description de l'evenement" maxlength="49">
													</label>
													<div style="color: #FF0000;"></div>
												</section>
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
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include 'footer.php';
?>

<script>
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal
	span.onclick = function () {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	// Afficher la modal avec le texte donné
	function showModal(text) {
		var modalText = document.getElementById("modalText");
		modalText.innerHTML = text;
		modal.style.display = "block";
	}
	// Récupérer le formulaire
	var form = document.getElementById("contact-form");

	// Écouter l'événement de soumission du formulaire
	form.addEventListener("submit", function (event) {
		// Empêcher le comportement par défaut du formulaire
		event.preventDefault();

		// Créer une nouvelle requête XHR
		var xhr = new XMLHttpRequest();

		// Définir la fonction de rappel pour gérer la réponse du serveur
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					// Afficher la modal avec le texte de la réponse
					showModal(xhr.responseText);
				} else {
					// Afficher une alerte en cas d'erreur
					alert("Erreur lors de l'envoi du formulaire : " + xhr.status);
				}
			}
		};

		// Ouvrir la requête XHR
		xhr.open("POST", form.action, true);

		// Envoyer les données du formulaire
		xhr.send(new FormData(form));
	});
	// Get the modal OK button
	var modalOkButton = document.getElementById("modalOkButton");

	// Ajoutez un gestionnaire d'événements pour le clic sur le bouton "OK"
	modalOkButton.addEventListener("click", function () {
		// Redirection vers planing.php
		window.location.href = "planning.php";
	})

</script>
<!-- Styles pour la modal -->
<style>
	.modal {
		display: none;
		position: absolute;
		z-index: 1;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgba(0, 0, 0, 0.4);
		padding-top: 60px;
	}

	.modal-content {
		background-color: #fefefe;
		margin: 5% auto;
		padding: 20px;
		border: 1px solid #888;
		width: 50%;
	}

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