<?php

include './includes/header.php';
?>

<?php
include './includes/sidebar.php';

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">

		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
			<li class="active">Ajout de nouveau candidat</li>
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
									class="hidden-mobile hidden-tablet">Information sur le Candidat</span> </a>
						</li>

					</ul>
				</header>
			</div>

			<div class="col-md-12">

				<div class="chart-box">


					<form action="./backend/candidat_back.php" method="post" id="contact-form" novalidate="novalidate"
						onsubmit="verify();" enctype="multipart/form-data">
						<input type="hidden" name="action" value="add">
						<div class="tab-content">
							<div class="tab-pane active" id="personalinfo">
								<div class="tabbable tabs-below">
									<div class="tab-content padding-10">
										<div class="tab-pane active" id="AA11">
											<div class="smart-form">
												<div class="fieldset">

													<!-- Numero sur la liste Electorale -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Numero sur la liste Electorale<font
																	color="red">*</font></label>
															<label class="input">
																<i class="icon-append fa fa-sort-numeric-asc"></i>
																<input type="text" name="num_electoral" value=""
																	id="num_electoral"
																	placeholder="Numero du candidat sur la liste Electorale"
																	maxlength="49">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

													<!-- Nom -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Nom<font color="red">*</font></label>
															<label class="input">
																<i class="icon-append fa fa-user"></i>
																<input type="text" name="nom_candidat" value=""
																	id="nom_candidat" placeholder="Nom du candidat"
																	maxlength="49">
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
																<input type="text" name="prenom_candidat" value=""
																	id="prenom_candidat"
																	placeholder="Prenom du candidat" maxlength="49">
															</label>
															<div style="color: #FF0000;"></div>
														</section>
													</div>

													<!-- Photo -->
													<div class="row">
														<section class="col col-md-12">
															<label class="label">Photo du candidat</label>
															<label class="input">
																<i class="icon-append fa fa-camera"></i>
																<input type="file" name="photo_candidat"
																	id="photo_candidat" accept="image/*">
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
																	<a href="view_user.php">
																		<button type="button" name="cancel"
																			class="btn btn-danger">Annuler</button>
																	</a>
																	<button type="submit" name="submit"
																		class="btn btn-primary"
																		>Enregistrer</button>
																	
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