<?php

include './includes/header.php';
include './includes/sidebar.php';
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">

		<ol class="breadcrumb">
			<li><a href="./dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>
			<li class="active">Ajout d'un nouvel utilisateur</li>
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
									class="hidden-mobile hidden-tablet">Information sur le nouvel utilisateur</span> </a>
						</li>

					</ul>
				</header>
			</div>

			<div class="col-md-12">

				<div class="chart-box">


					<form action="./backend/add_utilisateur.php" method="post" id="contact-form" novalidate="novalidate"
						onsubmit="verify();" enctype="multipart/form-data">

						<div class="tab-content">

							<div class="tab-pane active" id="personalinfo">
								<div class="tabbable tabs-below">
									<div class="tab-content padding-10">
										<div class="tab-pane active" id="AA11">
											<div class="smart-form">
												<div class="fieldset">

													<!-- Nom -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Nom<font color="red">*</font></label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="nom_utilisateur" value=""
																	id="nom_utilisateur" placeholder="Nom de l'utilisateur">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

													<!-- Prénom -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Prénom<font color="red">*</font>
																</label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="prenom_utilisateur" value=""
																	id="prenom_utilisateur"
																	placeholder="Prénom de l'utilisateur">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

													<!-- Email -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Email<font color="red">*</font>
																</label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="email_utilisateur" value=""
																	id="email_utilisateur"
																	placeholder="Email">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

													<!-- Mot de passe -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Mot de passe<font color="red">*</font>
																</label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="pwd_utilisateur" value=""
																	id="pwd_utilisateur"
																	placeholder="Mot de passe">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

													<!-- Photo de profil -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Photo de profil<font color="red">*</font>
																</label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="file" name="photo_utilisateur" value=""
																	id="photo_utilisateur">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

												</div>

												<!-- Boutons pour Annuler et Soumettre -->
												<div class="fieldset">
													<div class="row">
														<div class="col-md-12 text-right">
															<div class="col-lg-12">
																<footer>
																	<a href="view_user.php"><button type="button"
																			name="cancel"
																			class="btn btn-danger">Annuler</button></a>

																	<button type="submit" name="submit"
																		class="btn btn-primary"
																		id="createuser">Enregistrer</button>
																	<button type="button" class="btn btn-primary"
																		id="processAdd" style="display: none;">
																		<i class="fa fa-spinner fa-spin"></i>
																		Processing</button>
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