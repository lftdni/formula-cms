<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}

include('tpl/classes/functions.php');
include('tpl/classes/validations.class.php');

// Loading Classes
$validations = new Validations();

date_default_timezone_set('Europe/Zagreb');
$current_datetime = date('Y-m-d H:i:s');

 $vehicles_data_query = '	
	SELECT
	vehicles.id AS id_vehicle,	
	vehicles.model	
	FROM vehicles	
	ORDER BY vehicles.model ASC';
	
 $vehicles_data = $db->query($vehicles_data_query);
 $vehicles_data = $vehicles_data->fetch_all(MYSQLI_ASSOC);
 
// Main HTML Data
$html_data = array(
	'title' 		=> 'Unos instruktora - '.BRANDNAME,
	'description'	=> '',
	'author' 		=> 'Nives Miletić',
	'page_title'	=> 'Unos instruktora',
	'button'		=> array('name' => 'add_driver', 'value' => 'true', 'text' => 'Dodaj instruktora')
	
);
 // echo '<pre>',print_r($_POST),'</pre>'; 

if(@$_POST['add_driver'] === 'true' OR @$_POST['edit_driver'] === 'true') {

	$driver_data = array();
	
	foreach($_POST as $value => $key) {
		$driver_data[$value] = trim($key);
 	}
	
	$messages = array();
	
	// Check if name has lower then 32 chars
	if(strlen($driver_data['name']) > 32) {
		$messages[] = array('status' => 'error', 'message' => 'Ime može sadržavati maksimalno 32 znaka. ');
	}	
	// Check if surname has lower then 32 chars
	if(strlen($driver_data['surname']) > 32) {
		$messages[] = array('status' => 'error', 'message' => 'Prezime može sadržavati maksimalno 32 znaka. ');
	}
	// Check if mobile_phone has lower then 18 chars
	if(strlen($driver_data['mobile_phone']) > 19) {
		$messages[] = array('status' => 'error', 'message' => 'Br. mobitela mora biti postavljenog formata. ');
	}
	// Check if remark has lower then 255 chars
	if(strlen($driver_data['remark']) > 634 ){
		$messages[] = array('status' => 'error', 'message' => 'Opis je predugačak. ');
	}

	// Validate email format
	if(!filter_var($driver_data['email'], FILTER_VALIDATE_EMAIL)) {
		$messages[] = array('status' => 'error', 'message' => 'Krivi unos e-mail formata.');
	}	
		
	if($error = $validations->upcoming(array($driver_data['birth_day'], $driver_data['birth_month'], $driver_data['birth_year']))) {
		$messages[] = $error;
	 }

	// IF empty messages(no errors) continue
	if(!$messages) {

		$driver_data['creation_datetime']	= 	$current_datetime;
		$driver_data['lastupdate_datetime']	= 	$current_datetime;
		$driver_data['birthdate'] = $driver_data['birth_year'].'-'.$driver_data['birth_month'].'-'.$driver_data['birth_day'];
			
		unset (
			$driver_data['birth_day'],
			$driver_data['birth_month'],
			$driver_data['birth_year'],
			$driver_data['add_driver']			 
		);
		
		// Get id_admin from session
		$driver_data['id_admin'] = $_SESSION['user_id'];
		
		// Add in db			
		if(@$_POST['add_driver'] === 'true') { //Add driver in DB
		//var_dump($_POST['add_driver']);
		
			//	if isset Files
			if (isset ($_FILES['instruktor_slika']) === true) {	
			
					$search = array("ć","č","ž","š","đ");
					$replacement = array("c","c","z","s","dj");
					$string_name = str_replace($search,$replacement,$_POST['name']);
					$string_surname = str_replace($search,$replacement,$_POST['surname']);
					var_dump($string_name);
					
			
				//	if Files is empty - echo; else - get file			
				if(empty($_FILES['instruktor_slika']['name']) === true){
					echo 'Molimo odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');					
					$file_name = $_FILES['instruktor_slika']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					
					$file_temp = $_FILES['instruktor_slika']['tmp_name'];
					
				
					$permalink = sanitize_title_with_dashes($string_name).'-'.sanitize_title_with_dashes($string_surname);
					//if vars are true - upload
					if (in_array($file_extn, $allowed) === true){
					$driver_data['permalink'] = $db->real_escape_string(uploadDriverImage($file_temp, $file_extn, $permalink));	
					} else {
						echo 'Nedozvoljen format slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}
			
			if (isset ($_FILES['instruktor_licenca']) === true) {				
				if(empty($_FILES['instruktor_licenca']['name']) === true){
					echo 'Molimo odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');					
					$file_name = $_FILES['instruktor_licenca']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['instruktor_licenca']['tmp_name'];					
					$permalink = sanitize_title_with_dashes($string_name).'-'.sanitize_title_with_dashes($_POST['birth_year']);
			
					if (in_array($file_extn, $allowed) === true){
					$driver_data['licence'] = $db->real_escape_string(uploadLicenceImage($file_temp, $file_extn, $permalink));	
					} else {
						echo 'Nedozvoljen tip slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}

			$add_driver_query = 'INSERT INTO `formuladb`.`drivers` (`'.implode('`, `', array_keys($driver_data)).'`) VALUES (\''.implode('\', \'', $driver_data).'\')';
			
			if($db->query($add_driver_query)) {
				$array_message = 'Instruktor "'.$driver_data['name'].'" je uspješno unesen u bazu podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);			
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}				
			
		} elseif (@$_POST['edit_driver'] === 'true') { // UPDATE IN DATABASE
		
			 $driver_id = $driver_data['id'];	
			 $driver_data['lastupdate_datetime']	= 	$current_datetime;
			 
			unset(			
				$driver_data['id'],
				$driver_data['creation_datetime'],
				$driver_data['edit_driver']
		
				);
				
				
			if (isset ($_FILES['instruktor_slika']) === true) {	
				//	if Files is empty - echo; else - get file			
				if(empty($_FILES['instruktor_slika']['name']) === true){
					echo 'Molimo odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');					
					$file_name = $_FILES['instruktor_slika']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['instruktor_slika']['tmp_name'];
					
					$permalink = sanitize_title_with_dashes($string_name).'-'.sanitize_title_with_dashes($string_surname);
					//if vars are true - upload
					if (in_array($file_extn, $allowed) === true){
					$driver_data['permalink'] = $db->real_escape_string(uploadDriverImage($file_temp, $file_extn, $permalink));	
					} else {
						echo 'Nedozvoljen format slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}
			
			if (isset ($_FILES['instruktor_licenca']) === true) {				
				if(empty($_FILES['instruktor_licenca']['name']) === true){
					echo 'Molimo odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');					
					$file_name = $_FILES['instruktor_licenca']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['instruktor_licenca']['tmp_name'];					
					$permalink = sanitize_title_with_dashes($string_name).'-'.sanitize_title_with_dashes($_POST['birth_year']);
			
					if (in_array($file_extn, $allowed) === true){
					$driver_data['licence'] = $db->real_escape_string(uploadLicenceImage($file_temp, $file_extn, $permalink));	
					} else {
						echo 'Nedozvoljen tip slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}				
				
			$sql_update_data ='';
			
			foreach($driver_data as $key => $value) {
				if($value == end($driver_data)) {
					$sql_update_data .= $key.'=\''.$value.'\' '; //Space at end
				} else {
					$sql_update_data .= $key.'=\''.$value.'\', '; //Space with comma on end
				}
			}			
			
			$update_driver_query = 'UPDATE `formuladb`.`drivers` SET '.$sql_update_data.' WHERE id = '.$driver_id.'';
			
			if($db->query($update_driver_query)) {
				$array_message = 'Instruktor '.$driver_data['name'].' je uspješno ažuriran u bazi podataka.';
				
				$messages[] = array('status' => 'success', 'message' => $array_message);
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
		}

	}
}

// Delete Drivers
if(@$request_arr[1] === 'delete' AND !empty(@$request_arr[2])) {
	
	if(is_numeric($request_arr[2])) {
		
		$driver_id 					= $db->real_escape_string($request_arr[2]);
		$delete_driver_query 		= 'DELETE FROM drivers WHERE id = \''.$driver_id.'\'';

		if($db->query($delete_driver_query)) {
			if($db->affected_rows === 1) {
				header('Location: /admin/drivers');
				$messages[] = array('status' => 'success', 'message' => 'Instruktor je uspješno obrisan.');	
			 } else {
				 $messages[] = array('status' => 'error', 'message' => 'Instruktor ne postoji.');
			 }
		} else {
			$messages[] = array('status' => 'error', 'message' => 'Instruktor nije obrisan. Nešto nije u redu sa bazom podataka.');
		}
	} else {
		header('Location: /drivers'); exit;
	}
}

// Edit Drivers
if(@$request_arr[1] === 'edit' AND !empty(@$request_arr[2])) {	

	if(is_numeric($request_arr[2])) {	
	
		// Fetch data from database by id
		$driver_id = $db->real_escape_string($request_arr[2]);
		$driver_data_query = '
		SELECT *,
		DATE_FORMAT(birthdate, \'%d\') AS birth_day,
		DATE_FORMAT(birthdate, \'%m\') AS birth_month,
		DATE_FORMAT(birthdate, \'%Y\') AS birth_year
		FROM drivers WHERE id = \''.$driver_id.'\'';	
		
	$driver_data = $db->query($driver_data_query);
	if(!$driver_data = $driver_data->fetch_assoc()) {
		header('Location: /drivers-add'); exit;
	}				
	 } // else {
		// header('Location: /drivers-add'); exit;
	// }
	
	// HTML Data for EDIT
	$html_data = array(
		'title' 		=> 'Uredi instruktora - '.BRANDNAME,
		'description'	=> ' ',
		'author' 		=> 'Autoškola Formula',
		'page_title'	=> 'Uredi instruktora ('.$driver_data['name'].')',
		'button'		=> array('name' => 'edit_driver', 'value' => 'true', 'text' => 'Izmjeni')
	);
	
}


?>

<!DOCTYPE html>

<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$html_data['description'];?>">
    <meta name="author" content="<?=$html_data['author'];?>">

    <title><?=$html_data['title'];?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=BASE_URL?>tpl/css/bootstrap.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?=BASE_URL?>tpl/css/metisMenu.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=BASE_URL?>tpl/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?=BASE_URL?>tpl/css/font-awesome.css" rel="stylesheet" type="text/css">
	
	<!-- Bootstrap dropdown-menu -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>	
	
	<!-- FileUpload -->
	<link href="<?=BASE_URL?>tpl/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
	

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
                            <div class="alert alert-<?=@$alert_class;?>">
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
					OSOBNI PODACI INSTRUKTORA		
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form role="form" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="driversAdd")>																		
									<hr />
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 150px;">Ime </span>
												<input class="form-control" type="text" name="name" maxlength="32" placeholder="Ime" value="<?=@$driver_data['name'];?>" required>
											</div>
										</div>
										&nbsp;&nbsp;										
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 150px;">Prezime </span>
												<input class="form-control" type="text" name="surname" maxlength="32" placeholder="Prezime" value="<?=@$driver_data['surname'];?>" required>
											</div>
										</div>
										&nbsp;&nbsp;
										
										<div class="input-group">
												<span class="input-group-addon" style="min-width: 150px;">Datum rođenja</span>
												<div class="form-inline">
													<div class="form-group">
														<select class="form-control" name="birth_day" required>
															<option value="" selected>Dan</option>
															<?php
															foreach (range(1, 31) as $day) {
																if($day == @$driver_data['birth_day']) {
																	$selected = ' selected';
																} else {
																	$selected = '';
																}
																echo '<option'.$selected.' value='.$day.'>'.$day.'</option>';
															}
															?>
														</select>
													</div>
													<div class="form-group">
														<select class="form-control" name="birth_month" required>
															<option value="" selected>Mjesec</option>
															<?php
															foreach (range(1, 12) as $month) {
																if($month == @$driver_data['birth_month']) {
																	$selected = ' selected';
																} else {
																	$selected = '';
																}
																echo '<option'.$selected.' value='.$month.'>'.$month.'</option>';
															}
															?>
														</select>
													</div>
													<div class="form-group">
														<select class="form-control" name="birth_year" required>
															<option value="" selected>Godina</option>
															<?php
															foreach (range(date('Y'), 1950) as $year) {
																if($year == @$driver_data['birth_year']) {
																	$selected = ' selected';
																} else {
																	$selected = '';
																}
																echo '<option'.$selected.' value='.$year.'>'.$year.'</option>';
															}
															?>
														</select>
													</div>
												</div>
										</div>

										&nbsp;&nbsp;
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 150px;">Mobitel </span>
												<input class="form-control bfh-phone" type="text" data-format="+385 (dd) ddd-dddd" name="mobile_phone" maxlength="32" placeholder="Mobitel" value="<?=@$driver_data['mobile_phone'];?>" required>
											</div>
										</div>
										&nbsp;&nbsp;
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 150px;">Email </span>
											<input class="form-control" type="email" name="email" value="<?=@$driver_data['email'];?>" >
											</div>
										</div>
										&nbsp;&nbsp;
										<div class="input-group">											
										<span class="input-group-addon" style="max-width: 100px;">Pretražite vozilo </span>
										
										<select class="selectpicker" data-live-search="true" id="id_vehicle" name="id_vehicle" value="<?=@$id_vehicle;?>" required>												
											<?php foreach ($vehicles_data as $key => $value) : ?>																			  																						
											<option id="<?php echo $value['id_vehicle'];?>"  
											value="<?php echo $value['id_vehicle'];?>"> <?php echo $value['model'];?> 
											</option>
											<?php endforeach; ?>
											
										</select>												
										</div>											
										&nbsp;&nbsp;																				
										<div class="form-group">								
											<label class="control-label">Odaberite sliku s vozilom </label>
											<input id="input-2" name="instruktor_slika" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" value="<?=@$driver_data['permalink'];?>" required>																		
										</div>
										&nbsp;&nbsp;										
										<div class="form-group">								
											<label class="control-label">Odaberite sliku licence </label>
											<input id="input-2" name="instruktor_licenca" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" value="<?=@$driver_data['licence'];?>">																		
										</div>
										&nbsp;&nbsp;	
										<div class="form-group">
											<label form="remark">Opaska </label>
											<textarea class="form-control" name="remark" rows="5" value="<?=@$driver_data['remark'];?>" required> </textarea>
										</div>
										
										<hr />						
									
									<?php
									if(@$request_arr[1] === 'edit') {
										echo '<input type="hidden" name="id" value="'.$request_arr[2].'">'."\r\n";
									}
									?>
									
									<button type="submit" class="btn btn-default" name="<?=$html_data['button']['name'];?>" value="<?=$html_data['button']['value'];?>"><?=$html_data['button']['text'] ;?></button>
									<!-- <button type="reset" class="btn btn-default">Reset Button</button> -->				

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
											<dd><pre>Primjer 1: Ivan <br />Primjer 2: Ivan - Marko</pre></dd>
											<dt>Prezime</dt>
											<dd><pre>Primjer 1: Marković <br />Primjer 2: Marković - Perković</pre></dd>
											<dt>Pretražite vozilo</dt>
											<dd><pre>Napomena: Polje je predviđeno za odabir vozila instruktora </pre></dd>											
											<dt>Datum rođenja</dt>
											<dd><pre>Primjer: 27.3.1985</pre></dd>	
											<dt>Mobitel</dt>
											<dd><pre>Primjer: +385(91)525-2552</pre></dd>	
											<dt>Email</dt>
											<dd><pre>Primjer: zdravkodren@gmail.com </pre></dd>											
											<dt>Slika s vozilom</dt>
											<dd><pre>Napomena: Polje je predviđeno za upload slike instruktora s vozilom </pre></dd>
											<dt>Slika s licencom</dt>
											<dd><pre>Napomena: Polje je predviđeno za upload slike instruktora s licencom </pre></dd>
											<dt>Opaska </dt>
											<dd><pre>Napomena: Polje je predviđeno unos dodatnih informacija o instruktoru </pre></dd>											
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

	
    <!-- Bootstrap Core JavaScript -->

    <script src="<?=BASE_URL?>tpl/js/bootstrap.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=BASE_URL?>tpl/js/metisMenu.js"></script>
	<!-- Custom Theme JavaScript -->
    <script src="<?=BASE_URL?>tpl/js/sb-admin-2.js"></script>	

	<script src="<?=BASE_URL?>tpl/js/fileinput.min.js" type="text/javascript"></script> <!--- Provjeri js-ove --->
	<!-- bootstrap.js below is only needed if you wish to use the feature of viewing details of text file preview via modal dialog -->	 

	<script src="<?=BASE_URL?>tpl/js/plugins/bootstrap-formhelpers.min.js" type="text/javascript"></script>	
	<script src="<?=BASE_URL?>tpl/js/bootstrap-formhelpers-phone.js" type="text/javascript"></script>

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

<script>
function myFunction() {
	document.getElementById("driversAdd").reset();
}
</script>	


</body>
</html>