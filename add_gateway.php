<?php

include 'header.php';
include 'sidebar.php';

?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
        <li class="active">Ajout de nouveau votant</li>
      </ol>
    </section>
    
    <!-- Main content -->
<section class="content container-fluid">

<div class="row">

<div class="col-md-12">
<header role="heading">
							<ul class="nav nav-tabs pull-left in">
		
								<li id="personalinfo1" class="">
									<a data-toggle="tab" href="#personalinfo"> <i class="fa fa-lg fa-info-circle"></i> <span class="hidden-mobile hidden-tablet">Information sur le votant</span> </a>
								</li>
								
							</ul>
						</header>
						</div>
						
<div class="col-md-12">

	<div class="chart-box">
		
		
<form action="backend/votant_back.php" method="post" id="contact-form" novalidate="novalidate" onsubmit="verify();">
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
																		<input type="text" name="nom_votant" value="" id="nom_votant" placeholder="Nom du votant" maxlength="49">
																		<div style="color: #FF0000;"></div>
																	</label>
																</section>
																<section class="col col-md-6">
																	<label class="label">Prenom</label>
																	<label class="input">
																		<i class="icon-append fa fa-user"></i>
																		<input type="text" name="prenom_votant" value="" id="prenom_votant" placeholder="Prenom du votant" maxlength="49">
																	</label>
																	<div style="color: #FF0000;"></div>
																</section>
															</div>
														</div>
														<div class="fieldset">
															<div class="row">
																<section class="col col-md-6">
																	<label class="label">Adresse<font color="red">*</font></label>
																	<label class="input">
																		<i class="icon-append fa fa-envelope"></i>
																		<input type="text" name="adresse_votant" value="" id="adresse_votant" placeholder="Adresse du votant" maxlength="49">
																	</label>
																	<div style="color: #FF0000;"></div>
																</section>
																<section class="col col-md-6">
																	<label class="label">Contact</label>
																	<label class="input">
																		<i class="icon-append fa fa-image"></i>
																		<input type="text" name="contact_votant" value="" id="contact_votant" placeholder="Contact du votant" maxlength="49">
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