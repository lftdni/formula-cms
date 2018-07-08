<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}

include('tpl/classes/functions.php');
date_default_timezone_set('Europe/Zagreb');
$current_datetime = date('Y-m-d H:i:s');

//echo '<pre>',print_r($_POST),'</pre>'; exit;


// HTML Info Podaci
$html_data = array (
	'title' 		=> 'Unos korisnika',
	'description'	=> '',
	'author' 		=> '',
	'page_title'	=> 'Unos korisnika',
	'button'		=> array('name' => 'add_user', 'value' => 'true', 'text' => 'Dodaj korisnika')	
);

$user_data = array();

if(@$_POST['add_user'] === 'true' OR @$_POST['edit_user'] === 'true') {
	
	// Make user_data array with trimed values
	$user_data = array();
	foreach($_POST as $value => $key) {
		$user_data[$value] = trim($key);
 	}
	
	$messages = array();
	// Check if name has lower then 32 chars
	if(strlen($user_data['first_name']) > 32) {
		$messages[] = array('status' => 'error', 'message' => 'Ime može sadržavati maksimalno 32 znaka.');
	}	
	
	// Check if surname has lower then 32 chars
	if(strlen($user_data['last_name']) > 32) {
		$messages[] = array('status' => 'error', 'message' => 'Prezime može sadržavati maksimalno 32 znaka.');
	}	
	// Check if username has lower then 16 chars
	if(strlen($user_data['username']) > 16) {
		$messages[] = array('status' => 'error', 'message' => 'Korisničko ime može sadržavati maksimalno 16 znakova.');
	}	
	// Validate email format
	if(!filter_var($user_data['email'], FILTER_VALIDATE_EMAIL)) {
		$messages[] = array('status' => 'error', 'message' => 'Krivi unos e-mail formata.');
	}	
	// Check if password is less then 8 chars
	if(strlen($user_data['password']) < 8) {
		$messages[] = array('status' => 'error', 'message' => 'Lozinka mora imat minimalno 8 znakova!');
	}	
	// Check if password are equal
	if($user_data['password'] !== $user_data['password2']) {
		$messages[] = array('status' => 'error', 'message' => 'Lozinke se ne poklapaju.');
	}
	if(!$user_data['permission'] === '0' OR !$user_data['permission'] === '1'){
		$messages[] = array('status' => 'error', 'message' => 'Tip korisničkog račina nije u redu.');
	}
	
	// IF empty messages(no errors) continue
	if(!$messages) {
		
		unset(
			$user_data['password2'],		
			$user_data['add_user']
		);
		
		if(username_exists($user_data['username'])) {
			$messages[] = array('status' => 'error', 'message' => 'Korisničko ime već postoji.');
		}		
		if(email_exists($user_data['email'])) {
			$messages[] = array('status' => 'error', 'message' => 'E-Mail već postoji.');
		}
			
		if(!$messages) {
			
			// Add and change key(s) in user_data array
			$user_data['password'] 				= sha1($user_data['password']);
			$user_data['creation_datetime'] 	= $current_datetime;
			$user_data['lastupdate_datetime'] 	= $current_datetime;

			$add_user_query = 'INSERT INTO `formuladb`.`users` (`'.implode('`, `', array_keys($user_data)).'`) VALUES (\''.implode('\', \'', $user_data).'\')';
			
			//echo '<pre>',print_r($user_data),'</pre>'; exit;
			
			if($user_data['permission'] === '0') {
				$acc_type_name = 'Korisnički ';
			} else {
				$acc_type_name = 'Administracijski ';
			}

			if($db->query($add_user_query)) {
				$messages[] = array('status' => 'success', 'message' => $user_data['username'].' je uspješno kreiran.');
			} else {
				$messages[] = array('status' => 'error', 'message' => 'Nešto nije u redu sa bazom podataka.');
			}
		}
	}
}

// Delete Users

// Edit Users
if(@$request_arr[1] === 'edit' AND !empty(@$request_arr[2])) {
	
	if(is_numeric($request_arr[2])) {
		
		$user_id 			= $db->real_escape_string($request_arr[2]);
		$user_data_query 	= 'SELECT * FROM users WHERE id = \''.$user_id.'\'';
		$user_data 			= $db->query($user_data_query);
		$user_data 			= $user_data->fetch_assoc();
					
	} else {
		header('Location: /users-add'); exit;
	}
	
	$html_data = array(
		'title' 		=> 'Uredi korisnika  ',
		'description'	=> '',
		'author' 		=> ' ',
		'page_title'	=> 'Uredi korisnika ('.$user_data['username'].')',
		'button'		=> array('name' => 'edit_user', 'value' => 'true', 'text' => 'Uredi korisnika')
		
	);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$html_data['description'];?>">
    <meta name="author" content="<?=$html_data['author'];?>">

    <title><?=$html_data['title'];?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=BASE_URL;?>tpl/css/bootstrap.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?=BASE_URL;?>tpl/css/metisMenu.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="<?=BASE_URL;?>tpl/css/timeline.css" rel="stylesheet">
	<!-- MetisMenu CSS -->
    <link href="<?=BASE_URL;?>tpl/css/metisMenu.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=BASE_URL;?>tpl/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=BASE_URL;?>tpl/css/font-awesome.css" rel="stylesheet" type="text/css">
	
	<!-- Bootstrap dropdown-menu -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>			

	
</head>

<body>

    <div id="wrapper">

	<?php include('tpl/include/navigation.html'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$html_data['page_title'];?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<?php if(@$messages) : ?>
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Poruke sustava
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
            <!-- /.row -->
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Ispunite informacije o korisniku
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form role="form" method="POST" accept-charset="UTF-8">
									<div class="form-group">
										<label>Ime</label>
										<input class="form-control" type="text" name="first_name" maxlength="32" value="<?=@$user_data['first_name'];?>" required>
									</div>
									<div class="form-group">
										<label>Prezime</label>
										<input class="form-control" type="text" name="last_name" maxlength="32" value="<?=@$user_data['last_name'];?>" required>
									</div>
									<div class="form-group">
										<label>Korisničko Ime</label>
										<input class="form-control" type="text" name="username" maxlength="16" value="<?=@$user_data['username'];?>" required>
									</div>
									<div class="form-group">
										<label>E-mail</label>
										<input class="form-control" type="email" name="email" value="<?=@$user_data['email'];?>" required>
									</div>
									<div class="form-group">
										<label>Lozinka</label>
										<input class="form-control" type="password" name="password" value="" autofocus required>
										<p class="help-block">Napomena: Lozinka mora sadržavati minimalno 8 znakova.</p>
									</div>	
									<div class="form-group">
										<label>Lozinka ponovo</label>
										<input class="form-control" type="password" name="password2" value="" required>
										<p class="help-block">Napomena: Lozinka mora sadržavati minimalno 8 znakova.</p>
									</div>
									<div class="form-group">
									<label>Tip Racuna</label>
									<select class="form-control" name="permission">
										<?php
											if(@$user_data['permission'] === '0') {
												$option0 = ' selected';
											}
											if(@$user_data['permission'] === '1') {
												$option1 = ' selected';
											}
										?>
										<option value="0"<?=@$option0;?>>Korisnik</option>
										<option value="1"<?=@$option1;?>>Administrator</option>
									</select>
									</div>
							
									<hr />
									<button type="submit" class="btn btn-default" name="<?=$html_data['button']['name'];?>" value="<?=$html_data['button']['value'];?>"><?=$html_data['button']['text'];?></button>
								</form>
							</div>
							<!-- /.col-lg-6 (nested) -->
							<div class="col-lg-5 pull-right">
								<div class="panel panel-default">
									<div class="panel-heading">
										Pomoć
									</div>
									<div class="panel-body">
										<dl>
											<dt>Ime</dt>
											<dd><pre>Primjer: Zdravko</pre></dd>
											<dt>Prezime</dt>
											<dd><pre>Primjer: Dren</pre></dd>
											<dt>Korisničko Ime</dt>
											<dd><pre>Primjer: Zdravko123</pre></dd>
											<dt>E-mail</dt>
											<dd><pre>Primjer: zdravko.dren@gmail.com</pre></dd>
											<dt>Lozinka</dt>
											<dd><pre>Primjer: zdravko1234 <br/>Napomena: Sve lozinke se pohranjuju u bazu šifrirane i zastićene, moguće ih je promijeniti, ali ne i pregledati</pre></dd>
										</dl>
									</div>
									<!-- /.panel-body -->
								</div>
							</div>
							<!-- /.col-lg-5 (nested) -->
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


	<!-- jQuery -->
	
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=BASE_URL;?>tpl/js/bootstrap.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=BASE_URL;?>tpl/js/metisMenu.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="<?=BASE_URL;?>tpl/js/sb-admin-2.js"></script>	
	
	<!-- Dropdown Menu Latest compiled and minified JavaScript -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> 
	 
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 
	
	
	<!-- Edit HTML5 Required Message -->
	<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var elements = document.getElementsByTagName("INPUT");
		for (var i = 0; i < elements.length; i++) {
			elements[i].oninvalid = function(e) {
				e.target.setCustomValidity("");
				if (!e.target.validity.valid) {
					e.target.setCustomValidity("Molimo ispunite polje.");
				}
			};
			elements[i].oninput = function(e) {
				e.target.setCustomValidity("");
			};
		}
	})
	</script>
	
</body>
</html>