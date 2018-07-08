<?php 

include('php/defaults/header.php');

function isEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

	// if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		// $messages[] = array('status' => 'error', 'message' => 'Krivi unos e-mail formata.');
	// }			

if(!empty($_POST["submit"]) ) {
	
	$name 		= trim($_POST['userName']);
	$email 		= trim($_POST['userEmail']);
	$subject 	= trim($_POST['subject']);
	$content 	= trim($_POST['content']);
	$antispam	= trim($_POST['antispam']);
	
	$messages = array();
	
	// Check if name 
	if($name == '') {
		$messages[] = array('status' => 'error', 'message' => 'Ime mora biti upisano!');
		if(!strlen ($name)  > 32){
			$messages[] = array('status' => 'error', 'message' => 'Ime ne smije sadržavati više od 32 znaka!');
		}
	}	
		
	if(!isEmail($email)) {
       $messages[] = array('status' => 'error', 'message' => 'Vaš email nije pravilnog formata! ');
    }
	
	if($subject == '') {
       $messages[] = array('status' => 'error', 'message' => 'Naslov mora biti upisan! ');
    }
	if($content == '') {
       $messages[] = array('status' => 'error', 'message' => ' Polje za poruku mora biti ispunjeno! ');
    }
	if($antispam != '12') {
    	  $messages[] = array('status' => 'error', 'message' => ' Krivi odgovor! Molimo pokušajte ponovo! ');
    }
	 
	if(!$messages) {
		
		$toEmail = "testna_mail_adresa@gmail.com";
		$mailHeaders = "Poruka poslana od: \" " . $name . "\" \r\n E-mail adresa za odgovor: <". $email .">\r\n";
		
		if(mail($toEmail, $subject, $content, $mailHeaders)) {
		$message = "Vaša poruka je uspješno poslana! Kotaktirati ćemo Vas uskoro.";
		
		}
	}
	
}


 ?>
    <!-- CONTENT AREA -->
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs text-center">
            <div class="container">
                <div class="page-header">
                    <h1>Kontakt</h1>
                </div>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">

                <div class="row">
                    <div class="col-md-4">
                        <div class="contact-info">

                            <h2 class="block-title"><span>Kontaktirajte nas </span></h2>
                            <div class="media-list">                            
                          
                                <div class="media">
                                    <div class="media-body">
                                        Ako niste pronašli odgovore na pitanja koja ste imali, javite nam se s povjerenjem. </br>Možete nas kontaktirati za vrijeme radnih sati od 8:30 - 19:30 (pon-pet).
                                    </div>
                                </div>
                             
                                <div class="media">
                                    <i class="pull-left fa fa-home"></i>
                                    <div class="media-body">
                                        <strong>Adresa:</strong><br>
                                        Ul. Bartola Kašića, Rijeka
                                    </div>
                                </div>								
								<div class="media">
                                    <i class="pull-left fa fa-phone"></i>
                                    <div class="media-body">
                                        <strong>Telefon:</strong><br>
                                        (051)212-376<br>
										<strong>Mob:</strong><br>
                                        (091)212-376
                                    </div>
                                </div>
                                <div class="media">
                                    <i class="pull-left fa fa-envelope-o"></i>
                                    <div class="media-body">
                                       <strong>E-mail:</strong><br>
                                        <a href="mailto:formula.auto.skola@ri.t-com.hr">formula.auto.skola@ri.t-com.hr</a>
                                    </div>
                                </div>
                            </div>

                        </div> 
                        <!-- /contact-info -->
                    </div>

                    <div class="col-md-8 text-left">
							
					<!-- .row -->
					<?php if(@$messages) : ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Poruke upozorenja
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
								<?php foreach ($messages as $key => $value) : ?>
									<?php 
										if($value['status'] === 'error') {
											$alert_class = 'danger';
										} else {
											$alert_class = 'success';
										}
									?>
									<div class="alert alert-<?=$alert_class;?>">
										<strong><?=$value['message'];?></strong>
									</div>
								<?php endforeach; ?>
								</div>
								<!-- .panel-body -->
							</div>
							<!-- /.panel -->
						</div>
						<!-- /.col-lg-12 -->
					</div>
					<?php endif; ?>
					<!-- /row -->
                        <h2 class="block-title"><span>Kontakt forma</span></h2>
						
                        <!-- Contact form -->						 


						<form name="frmContact" method="post" action="">
								
									<div class="media-body">
									Ime i prezime:	</div>
									<div class="outer required">
										<div class="form-group af-inner">
										<input type="text" name="userName" placeholder="" size="30" class="form-control placeholder" required/>
										</div>
									</div>
								
									<div class="media-body">
									E-mail: </div>
									<div class="outer required">
										<div class="form-group af-inner">
										<input type="text" name="userEmail" placeholder="" size="30" class="form-control placeholder" required/> 
										</div>
									</div>
									
							
									<div class="media-body">
									Naslov	</div>
									<div class="outer required">
										<div class="form-group af-inner">										
										<input type="text" name="subject" size="73" size="30" class="form-control placeholder" required/>										
										</div>
									</div>
										
									<div class="media-body">
									Poruka	</div>									
									<div class="outer required">	
									<div class="form-group af-inner">									
									<textarea name="content" cols="60" rows="6" class="form-control placeholder" required/></textarea>
								
									</div>
									</div>
									
									 <div class="form-group">
			                        	<label for="contact-antispam">Antispam pitanje: 7 + 5 = ?</label>
			                        	<input type="text" name="antispam" placeholder="Vaš odgovor..." class="contact-antispam form-control" id="contact-antispam" required>
			                        </div>
									
									<div class="outer required">	
										<div class="form-group af-inner">									
										<input type="submit" name="submit" value="Pošalji" class="form-button form-button-submit btn btn-theme btn-theme-dark">
										<input type="reset" class="form-button form-button-submit btn btn-theme  btn-theme-transparent" id="reset" value="Obriši" type="reset">	
									
									</div>
									</div>
														
								<div  class="message">
								<?php if(isset($message)): ?> 
									<div class="alert alert-success fade in"><button class="close" data-dismiss="alert" type="button">×</button>
										<strong><?=@$message; ?></strong> 
									</div>														
								<?php endif;?>								
								</div>

						</form>						
						
                        <!-- /Contact form -->

                    </div>

                </div>
				<hr class="page-divider"> </hr>

            </div>
        </section>
        <!-- /PAGE -->

        <!-- PAGE -->
        <section class="page-section no-padding">
            <div class="container full-width">

                <!-- Google map -->
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2805.004666143221!2d14.44129678939676!3d45.328528232887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4764a11e1a79886b%3A0xa1e7a7ab95055b3f!2sUl.+Frana+Kurelca+4%2C+51000%2C+Rijeka!5e0!3m2!1shr!2shr!4v1462106643821" width="1900" height="456" frameborder="0" style="border:0" allowfullscreen></iframe>
				
                <!-- /Google map -->

            </div>
        </section>

<?php include('php/defaults/contact.php'); ?>
				
    </div>
    <!-- /CONTENT AREA -->

	
<?php include('php/defaults/footer.php'); ?>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var elements = document.getElementsByTagName("INPUT");
		for (var i = 0; i < elements.length; i++) {
			elements[i].oninvalid = function(e) {
				e.target.setCustomValidity("");
				if (!e.target.validity.valid) {
					e.target.setCustomValidity("Polje mora biti ispunjeno.");
				}
			};
			elements[i].oninput = function(e) {
				e.target.setCustomValidity("");
			};
		}
	})
</script>

