<?php

include 'header.php';
?>

<?php
include 'sidebar.php';

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
									<a data-toggle="tab" href="#personalinfo"> <i class="fa fa-lg fa-info-circle"></i> <span class="hidden-mobile hidden-tablet">Information sur le Candidat</span> </a>
								</li>
								
							</ul>
						</header>
						</div>
						
<div class="col-md-12">

	<div class="chart-box">
		
		
<form action="" method="post" id="contact-form" novalidate="novalidate" onsubmit="verify();">
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
																		<input type="text" name="nom" value="" id="nom" placeholder="Nom du candidat" maxlength="49">
																		<div style="color: #FF0000;"></div>
																	</label>
																</section>
																<section class="col col-md-6">
																	<label class="label">Prenom</label>
																	<label class="input">
																		<i class="icon-append fa fa-user"></i>
																		<input type="text" name="prenom" value="" id="prenom" placeholder="Prenom du candidat" maxlength="49">
																	</label>
																	<div style="color: #FF0000;"></div>
																</section>
															</div>
														</div>
														<div class="fieldset">
															<div class="row">
																<section class="col col-md-6">
																	<label class="label">Partie Politique<font color="red">*</font></label>
																	<label class="input">
																		<i class="icon-append fa fa-envelope"></i>
																		<input type="text" name="partie" value="" id="partie" placeholder="Partie politique du candidat" maxlength="49">
																	</label>
																	<div style="color: #FF0000;"></div>
																</section>
																<section class="col col-md-6">
																	<label class="label">Photo</label>
																	<label class="input">
																		<i class="icon-append fa fa-image"></i>
																		<input type="file" name="photo" value="" id="photo" placeholder="Photo du candidat" maxlength="49">
																	</label>
																	<div style="color: #FF0000;"></div>
																</section>
															</div>
														</div>
														<div class="fieldset">
															<div class="row">
																<section class="col col-md-6">
																	<label class="label">Contact<font color="red">*</font></label>
																	<div class="input">
																		<span class="icon-prepend">+261</span>
																		<input type="text" class="form-control" name="contact" value="" id="contact">
																		<i class="icon-append fa fa-phone"></i>
																		<div style="color: #FF0000;"></div>
																	</div>
																</section>
																<section class="col col-md-6">
																	<label class="label">Numero sur la liste Electorale<font color="red">*</font></label>
																	<label class="input">
																		<i class="icon-append fa fa-sort-numeric-asc"></i>
																		<input type="text" name="num_electoral" value="" id="num_electoral" placeholder="Numero du candidat sur la liste Electorale" maxlength="49">
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
															<button type="submit" name="submit" class="btn btn-danger">Cancel</button>
															
															<button type="submit" name="submit" class="btn btn-primary" id="createuser">Create</button>
															<button type="button" class="btn btn-primary" id="processAdd" style="display: none;">
																					<i class="fa fa-spinner fa-spin"></i> Processing</button>
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
							</form>	  </div>



</div>
</div>



</section>
    <!-- content --> 
  </div>
  <!-- content-wrapper --> 
  
 
</div>

<?php

include 'footer.php';
?>