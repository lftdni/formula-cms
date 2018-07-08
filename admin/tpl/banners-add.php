<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}
include('tpl/classes/functions.php');

date_default_timezone_set('Europe/Zagreb');

//get acutal date in format
$current_datetime = date('Y-m-d H:i:s');

// Main HTML Data
$html_data = array(
	'title' 		=> 'Unos slike - '.BRANDNAME,
	'description'	=> '',
	'author' 		=> 'Autoškola Formula',
	'page_title'	=> 'Unos banera',
	'button'		=> array('name' => 'add_banner', 'value' => 'true', 'text' => 'Dodaj sliku')
);

 //echo '<pre>',print_r($_POST),'</pre>'; 

if(@$_POST['add_banner'] === 'true' OR @$_POST['edit_banner'] === 'true') {
	
	$cptn		= trim($_POST['caption']);
	$txt 		= trim($_POST['text']);
	$desc 		= trim($_POST['description']);
	$declared 	= trim($_POST['declaration']);
		
	// Initialize banner_data array with trimed values	
	$banner_data = array();	
	
	foreach($_POST as $value => $key) {
		$banner_data[$value] = trim($key);
 	}
	
	$messages = array();
	// Check if caption has lower then 32 chars
	if(strlen($cptn) > 32) {
		$messages[] = array('status' => 'error', 'message' => 'Naslov može sadržavati maksimalno 32 znaka.');
	}	
	// Check if msg has lower then 128 chars
	if(strlen($txt) > 128) {
		$messages[] = array('status' => 'error', 'message' => 'Poruka može sadržavati maksimalno 128 znaka.');
	}	
	// Check if description has lower then 255 chars
	if(strlen($desc) > 634) {
		$messages[] = array('status' => 'error', 'message' => 'Opis može sadržavati maksimalno 255 znaka.');
	}	
	//Check if declaration is 0 or 1
	if(!$declared === '0' OR !$declared  === '1'){
		$messages[] = array('status' => 'error', 'message' => 'Odabir nije valjani.');	
	} 
		
	// IF empty messages(no errors) continue
	if(!$messages) {	
		
		// echo '<pre>',$desc,'</pre>'; 
		
		//If post add_banner is true continue
		if(@$_POST['add_banner'] === 'true') { // ADD Banner in DB
		
			unset($banner_data['add_banner']);
			
			//Add id_admin to $banner_data array		
			$banner_data['id_admin'] = $_SESSION['user_id'];
			
			//Initialize 
			$banner_data['creation_datetime'] 	= $current_datetime;		
			$banner_data['lastupdate_datetime'] 	= $current_datetime;	
	
			//If global variable $_FILES isset continue
			if (isset ($_FILES['baner_slika']) === true) {	
				//if array is empty echo error
				if(empty($_FILES['baner_slika']['name']) === true){
					echo '<p>Molimo odaberite sliku!</p>';		
					//else initialize values
				} else {
					//declare what type of picture is allowed
					$allowed = array('jpg', 'jpeg', 'gif', 'png');
					
					//set global $_FILES array with values
					$file_name = $_FILES['baner_slika']['name'];
					
					//get string in lower case explode it and check for dot at the end of file name for its type
					$file_extn = strtolower(end(explode('.', $file_name)));
					
					// get key value for file_temp
					$file_temp = $_FILES['baner_slika']['tmp_name'];
							
					$var = 'naslovna';					
					//use sanitize_title_with_dashes function for creating permalink
					$permalink = sanitize_title_with_dashes($_POST['caption']).'-'.sanitize_title_with_dashes($var);
					
					
					if (in_array($file_extn, $allowed) === true){
					$banner_data['path'] = $db->real_escape_string(uploadBannerImage($file_temp, $file_extn, $permalink));	
					} else {
						echo 'Nedozvoljen tip slike.';
						//echo allowed types with comma 
						echo implode(', ',$allowed);	
						
					}												
				}										
			}
			
			// insert values
			$add_banner_query = 'INSERT INTO `formuladb`.`banner` (`'.implode('`, `', array_keys($banner_data)).'`) VALUES (\''.implode('\', \'', $banner_data).'\')';
			
			// check proces of inserting		
			if($db->query($add_banner_query)) {
				$array_message = 'Banner '.$banner_data['caption'].' je uspješno unesen u bazu podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
			//if edit_banner condition is true continue
		} elseif (@$_POST['edit_banner'] === 'true') { // UPDATE Banner in DB
			
			$banner_id = $db->real_escape_string($banner_data['id']);
			
			$banner_data['lastupdate_datetime'] 	= $current_datetime;	
			
			//unset values 
			unset(
				$banner_data['id'],
				$banner_data['creation_datetime'],
				$banner_data['edit_banner']
			);
			
			if (isset ($_FILES['baner_slika']) === true) {	
			
				if(empty($_FILES['baner_slika']['name']) === true){
					echo 'Molimo odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');
					
					$file_name = $_FILES['baner_slika']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['baner_slika']['tmp_name'];
					$var = 'naslovna';
					$permalink = sanitize_title_with_dashes($_POST['caption']).'-'.sanitize_title_with_dashes($var);
			
					if (in_array($file_extn, $allowed) === true){
					$banner_data['path'] = $db->real_escape_string(uploadBannerImage($file_temp, $file_extn, $permalink));	
					} else {
						echo 'Nedozvoljen tip slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}
			
			//initialize string for query
			$sql_update_data = ' ';			
			foreach($banner_data as $key => $value) {
				// get keys and values for query; escape chars 
				if($value == end($banner_data)) {
					$sql_update_data .= $key.'=\''.$value.'\' '; //Space at end
				} else {
					$sql_update_data .= $key.'=\''.$value.'\', '; //Space with comma on end
				}
			}			
			
			$update_driver_query = 	'UPDATE `formuladb`.`banner` SET '.$sql_update_data.' WHERE id= '.$banner_id.'';
			 // var_dump($update_driver_query); exit;
			if($db->query($update_driver_query)) {
				$array_message = 'Banner "'.$banner_data['caption'].'" je uspješno ažuriran u bazi podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
		}
	}
}

// Delete
//get requested page and id
if(@$request_arr[1] === 'delete' AND !empty(@$request_arr[2])) {
	
	if(is_numeric($request_arr[2])) {
		
		$banner_id = $db->real_escape_string($request_arr[2]);
		$delete_banner_query = 'DELETE FROM banner WHERE id = \''.$banner_id.'\'';

		if($db->query($delete_banner_query)) {
			
			if($db->affected_rows === 1) {
				header('Location: /admin/banners');
				$messages[] = array('status' => 'success', 'message' => 'Baner je uspješno obrisan.');
			} else {
				$messages[] = array('status' => 'error', 'message' => 'Baner ne postoji.');
			}
		} else {
			$messages[] = array('status' => 'error', 'message' => 'Baner nije obrisan. Nešto nije u redu s bazom podataka.');
		}
	} else {
		header('Location: /admin/banners'); exit;
	}
}

// Edit 
//get requested page and id
if(@$request_arr[1] === 'edit' AND !empty(@$request_arr[2])) {
	
	if(is_numeric($request_arr[2])) {
		// Fetch costumer data from database by id
		$banner_id = $db->real_escape_string($request_arr[2]);
		 $banner_data_query = '
				 SELECT * FROM banner WHERE id = \''.$banner_id.'\'';		
		
		$banner_data = $db->query($banner_data_query);
		if(!$banner_data = $banner_data->fetch_assoc()) {
			header('Location: /admin/banners-add'); exit;
		}
		
	} else {
		header('Location: /admin/banners-add'); exit;
	}
	
	// HTML Data for EDIT
	$html_data = array(
		'title' 		=> 'Uredi baner - '.BRANDNAME,
		'description'	=> '',
		'author' 		=> 'Autoškola Formula',
		'page_title'	=> 'Uredi baner ('.$banner_data['caption'].')',
		'button'		=> array('name' => 'edit_banner', 'value' => 'true', 'text' => 'Izmjeni')
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
	<!-- DataTables CSS -->
    <link href="<?=BASE_URL?>tpl/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="<?=BASE_URL?>tpl/css/dataTables.responsive.css" rel="stylesheet">
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
						Dodaj baner
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form role="form" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="bannerForm">																												
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" style="min-width: 150px;">Naslov </span>
											<input class="form-control" type="text" name="caption" maxlength="32" placeholder="Naslov banera" value="<?=@$banner_data['caption'];?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" style="min-width: 150px;">Poruka </span>
											<input class="form-control" type="text" name="text" maxlength="32" placeholder="Poruka banera" value="<?=@$banner_data['text'];?>" required>
										</div>
									</div>
									<div class="form-group">
										<label form="description">Opis </label>
										<textarea class="form-control" name="description" rows="5" placeholder="Opis poruke banera nije obavezan" value="<?=@$banner_data['description'];?>" required> </textarea>
									</div>
									
									<div class="form-group">								
										<label class="control-label">Odaberite sliku </label>
										<input id="input-2" name="baner_slika" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" value="<?=@$banner_data['path'];?>" >																		
									</div>
									&nbsp;&nbsp;
									<div class="input-group">
										<span class="input-group-addon" style="min-width: 150px;" >Dizajn prikaza</span>
										<select class="selectpicker" name="banner_type" id="banner_type" >
										<?php
											if(@$banner_data['banner_type'] === '0') {
												$option0 = ' selected';
											}
											if(@$banner_data['banner_type'] === '1') {
												$option1 = ' selected';
											}
											if(@$banner_data['banner_type'] === '2') {
												$option2 = ' selected';
											}
											
										?>
											<option value="0"<?=@$option0;?>>Glavni</option>
											<option value="1"<?=@$option1;?>>Pozdravni</option>
											<option value="2"<?=@$option2;?>>S poveznicom</option>
											</select>
									</div>				
									
									&nbsp;&nbsp;
									<div class="input-group">
										<span class="input-group-addon" style="min-width: 150px;" >Objaviti na stranicama</span>
										<select class="selectpicker" name="declaration" id="declaration" >
										<?php
											if(@$banner_data['declaration'] === '0') {
												$option0 = ' selected';
											}
											if(@$banner_data['declaration'] === '1') {
												$option1 = ' selected';
											}
											
										?>
											<option value="0"<?=@$option0;?>>Ne</option>
											<option value="1"<?=@$option1;?>>Da</option>
											</select>
									</div>	
									&nbsp;&nbsp;

									
									<hr/>																																											
																					
									<?php
									if(@$request_arr[1] === 'edit') {
										echo '<input type="hidden" name="id" value="'.$request_arr[2].'">'."\r\n"; 
									}
									?>									
									<button type="submit" class="btn btn-default" name="<?=$html_data['button']['name'];?>" value="<?=$html_data['button']['value'];?>"> <?=$html_data['button']['text'];?></button>
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
											<dt>Naslov</dt>											
											<dd><pre>Primjer 1: Autoškola Formula <br />Primjer 2: Dobrodošli!</pre> </dd>
											<dt>Poruka</dt>
											<dd><pre>Primjer: Upoznajte nas! </pre></dd>
											<dt>Opis</dt>
											<dd><pre>Primjer: Dođite i uvjerite se u našu kvalitetu! <br />Primjer 2: -prazno- </pre></dd>
											<dt>Slika</dt>
											<dd><pre>Napomena: Odabrati sliku za objacu na početnoj stranici </pre></dd>
											<dt>Dizajn prikaza</dt>
											<dd><pre>Napomena: Postoje 3 tipa prikaza slike i pozdravnih poruka: <br/>Tip "Glavni" namijenjen je za dobrodošlicu<br/>Primjer: Tip "S poveznicom" namijenjen je za pozdravnu sliku koja vodi na stranicu liste vozila <br/>Tip "Pozdravni" može biti namijenjen za kratke informacije<br/>Napomena: Zadnji objavljen prikazuje se prvi na vašoj početnoj</pre></dd>	
											<dt>Objaviti na stranicama</dt>
											<dd><pre>Napomena: Potrebno je objaviti sliku na web-stranicama, ali nije obavezno  </pre></dd>												
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
		document.getElementById("bannerForm").reset();
	}
	</script>	
	
	
</body>
</html>