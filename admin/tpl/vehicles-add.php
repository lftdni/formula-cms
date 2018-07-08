<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}

include('tpl/classes/functions.php');
include('tpl/classes/validations.class.php');

$validations = new Validations();

date_default_timezone_set('Europe/Zagreb');
$current_datetime = date('Y-m-d H:i:s');

// Get categories_data
 $categories_data_query = '
	SELECT
	licensing_categories.id AS id_licence_category,
	licensing_categories.label
	FROM licensing_categories
	ORDER BY licensing_categories.label ASC ';

 $categories_data = $db->query($categories_data_query);
 $categories_data = $categories_data->fetch_all(MYSQLI_ASSOC);
 
// Main HTML Data
$html_data = array(
	'title' 		=> 'Unos vozila - '.BRANDNAME,
	'description'	=> ' ',
	'author' 		=> 'Autoškola Formula',
	'page_title'	=> 'Unos vozila',
	'button'		=> array('name' => 'add_vehicle', 'value' => 'true', 'text' => 'Dodaj vozilo')
);

// echo '<pre>',print_r($_POST),'</pre>'; exit;

if(@$_POST['add_vehicle'] === 'true' OR @$_POST['edit_vehicle'] === 'true') {
	
	// Make costumers_data array with trimed values
	$vehicle_data = array();
	
	foreach($_POST as $value => $key) {
		$vehicle_data[$value] = trim($key);
 	}
	
	$messages = array();
	
	// Check if name has lower than 32 chars
	if(strlen($vehicle_data['model']) > 32) {
		$messages[] = array('status' => 'error', 'message' => 'Model može sadržavati maksimalno 128 znaka. ');
	}	
	// Check if year is numeric and has 4 chars
	if(!is_numeric($vehicle_data['year']) & isset($vehicle_data['year'][4]) ) {
		$messages[] = array('status' => 'error', 'message' => 'Godina može sadržavati samo brojčane znakove i maksimalno 4 znaka. ');
	}		
	
	// Check if description has lower than 32 chars
	if(strlen($vehicle_data['description']) > 255) {
		$messages[] = array('status' => 'error', 'message' => 'Opis može sadržavati maksimalno 255 znaka. ');
	}
	// Check if surname has 6 chars or lower 
	if(isset($vehicle_data['engine_power'][6]) ) {
		$messages[] = array('status' => 'error', 'message' => 'Snaga motora može sadržavati maksimalno 3 znaka. ');
	}	
	//Check if type is 0 or 1
	if($vehicle_data['manual_automatic'] === '0' OR $vehicle_data['manual_automatic'] === '1') {
	} else {
		$messages[] = array('status' => 'error', 'message' => 'Vrsta mjenjača nije u redu. ');
	}
	//Check if vehicle_type is 0 or 1
	if($vehicle_data['vehicle_type'] === '0' OR $vehicle_data['vehicle_type'] === '1') {
		
	} else {
		$messages[] = array('status' => 'error', 'message' => 'Vrsta vozila nije u redu. ');
	}
	//Check if vehicle_type is 0 or 1
	if($vehicle_data['fuel_type'] === '0' OR $vehicle_data['fuel_type'] === '1' OR $vehicle_data['fuel_type'] === '2' OR $vehicle_data['fuel_type'] === '3' ) {
	} else {
		$messages[] = array('status' => 'error', 'message' => 'Vrsta motora nije u redu. ');
	}
	//Check if wheel_drive is 0 or 1
	if($vehicle_data['wheel_drive'] === '0' OR $vehicle_data['wheel_drive'] === '1' OR $vehicle_data['wheel_drive'] === '2') {
	} else {
		$messages[] = array('status' => 'error', 'message' => 'Vrsta pogona nije u redu. ');
	}


	// IF empty messages(no errors) continue
	if(!$messages) {

		unset(				
			$vehicle_data['add_vehicle']			
		);		
		
		if(@$_POST['add_vehicle'] === 'true') { // ADD
		
		$vehicle_data['id_admin'] = $_SESSION['user_id'];
		
			$vehicle_data['creation_datetime'] 	= $current_datetime;
			$vehicle_data['lastupdate_datetime'] 	= $current_datetime;					
			
			if (isset ($_FILES['avozilo_slika']) === true) {				
				if(empty($_FILES['avozilo_slika']['name']) === true){
					echo 'Odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');
					
					$file_name = $_FILES['avozilo_slika']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['avozilo_slika']['tmp_name'];					
					$permalink = sanitize_title_with_dashes($_POST['model']).'-'.sanitize_title_with_dashes($_POST['year']);
					
					if (in_array($file_extn, $allowed) === true){
					$vehicle_data['permalink'] = $db->real_escape_string(uploadVehicleImage($file_temp, $file_extn, $permalink));	
					} else {
						
						echo 'Nedozvoljen tip slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}		
			
			$add_vehicle_query = 'INSERT INTO `formuladb`.`vehicles` (`'.implode('`, `', array_keys($vehicle_data)).'`) VALUES (\''.implode('\', \'', $vehicle_data).'\')';			
		
			if($db->query($add_vehicle_query)) {
				$array_message = 'Vozilo '.$vehicle_data['model'].' je uspješno uneseno u bazu podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);
				
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
		} elseif (@$_POST['edit_vehicle'] === 'true') { // UPDATE IN DATABASE
			
			//$vehicle_id = $vehicle_data['id'];
			$vehicle_id = $db->real_escape_string($vehicle_data['id']);
			
			//unset values			
			unset(
				$vehicle_data['id'],
				$vehicle_data['creation_datetime'], 
				$vehicle_data['edit_vehicle']
				);
				
			$vehicle_data['lastupdate_datetime'] 	= $current_datetime;
			
			if (isset ($_FILES['avozilo_slika']) === true) {				
				if(empty($_FILES['avozilo_slika']['name']) === true){
					echo 'Odaberite sliku!';					
				} else {
					$allowed = array('jpg', 'jpeg', 'gif', 'png');
					
					$file_name = $_FILES['avozilo_slika']['name'];
					$file_extn = strtolower(end(explode('.', $file_name)));
					$file_temp = $_FILES['avozilo_slika']['tmp_name'];					
					$permalink = sanitize_title_with_dashes($_POST['model']).'-'.sanitize_title_with_dashes($_POST['year']);
					
					if (in_array($file_extn, $allowed) === true){
					$vehicle_data['permalink'] = $db->real_escape_string(uploadVehicleImage($file_temp, $file_extn, $permalink));	
					} else {
						
						echo 'Nedozvoljen tip slike.';
						echo implode (', ', $allowed);
					}												
				}										
			}		
				
			$sql_update_data = '';
			
			foreach($vehicle_data as $key => $value) {
				if($value == end($vehicle_data)) {
					$sql_update_data .= $key.'=\''.$value.'\' '; // Space at end
				} else {
					$sql_update_data .= $key.'=\''.$value.'\', '; // Space with comma on end
				}
			}			
			
			$update_vehicle_query = 'UPDATE `formuladb`.`vehicles` SET '.$sql_update_data.' WHERE id = '.$vehicle_id.'';
			
			//var_dump($update_vehicle_query); exit;
			if($db->query($update_vehicle_query)) {
				$array_message = 'Vozilo "'.$vehicle_data['model'].'" je uspješno ažurirano u bazi podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
		}

	}
}

// Delete
if(@$request_arr[1] === 'delete' AND !empty(@$request_arr[2])) {	
	if(!is_numeric($request_arr[2])) {	
	header('Location: /admin/vehicles-add');

	} else {
		$vehicle_id = $request_arr[2];
			$delete_vehicle_query  = 'DELETE FROM vehicles WHERE id = \''.$vehicle_id.'\'';

			if($db->query($delete_vehicle_query )) {
			$array_message = 'Vozilo je uspješno obrisano! ';
			$messages[] = array('status' => 'success', 'message' => $array_message);			
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);			
			}
	}
}
		
	
	

// Edit Users request_arr by URL

if(@$request_arr[1] === 'edit' AND !empty(@$request_arr[2])) {	

	if(is_numeric($request_arr[2])) {
		// Fetch vehicle data from database by id
		
		$vehicle_id = $db->real_escape_string($request_arr[2]);
		$vehicle_data_query = ' SELECT * FROM vehicles WHERE id = \''.$vehicle_id.'\' ';	
				
		$vehicle_data = $db->query($vehicle_data_query);
		if(!$vehicle_data = $vehicle_data->fetch_assoc()) {
			header('Location: /vehicles-add'); exit;
		}
	} else {
		header('Location: /vehicles-add'); exit;
	}
	
	// HTML Data for EDIT
	$html_data = array(
		'title' 		=> 'Uredi vozilo - '.BRANDNAME,
		'description'	=> ' ',
		'author' 		=> 'Nives Miletić',
		'page_title'	=> 'Uredi vozilo ('.$vehicle_data['model'].')',
		'button'		=> array('name' => 'edit_vehicle', 'value' => 'true', 'text' => 'Izmjeni')
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
    <!-- File Input -->
	<link href="<?=BASE_URL?>tpl/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
 
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

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
						Unos novog vozila
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form role="form" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="vehiclesForm">
									<div class="form-group">
										<div class="form-group">
														&nbsp;&nbsp;	
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 100px;" >Vrsta vozila </span>
												<select class="selectpicker" name="vehicle_type" id="vehicle_type" >
												<?php
													if(@$vehicle_data['vehicle_type'] === '0') {
														$option0 = ' selected';
													}
													if(@$vehicle_data['vehicle_type'] === '1') {
														$option1 = ' selected';
													}													
												?>
													<option value="0"<?=@$option0;?>>Automobil</option>
													<option value="1"<?=@$option1;?>>Motocikl</option>
												</select>
											</div>		
											&nbsp;&nbsp;
											<div class="input-group">											
												<span class="input-group-addon" style="max-width: 100px;">Pretražite kategoriju </span>			
												
												<select class="selectpicker" data-live-search="true" id="id_licence_category" name="id_licence_category" value="<?=@$id_licence_category;?>" required>												
													<?php foreach ($categories_data as $key => $value) : ?>																			  																						
													<option id="<?=$value['id_licence_category'];?>" value="<?php echo $value['id_licence_category'];?>"> <?php echo $value['label']; ?> </option>
													<?php endforeach; ?>																						
												</select>																							
											</div>	
								
											&nbsp;&nbsp;																													
											<hr />	
											
											<div class="input-group ">
												<span class="input-group-addon" style="min-width: 100px;">Model </span>
												<input class="form-control" type="text" name="model" placeholder="Model" value="<?=@$vehicle_data['model'];?>" autofocus required>  <!-- autofocus required -->
											</div>
											&nbsp;&nbsp; 
											<div class="input-group ">
											<span class="input-group-addon" style="min-width: 100px;">Godina </span>
											
												<select class="selectpicker" name="year" value="<?$vehicle_data['year']?> " >
												<span class="input-group-addon" style="min-width: 100px;" > </span>																							
														<script language="javascript">
														var d = new Date();
														var i = d.getFullYear();
															for (var i; i > 2005; i--) {
																document.write("<option value=\"" + i + "\">" + i + "</option>\n");
															}
														</script>
														<option value="year"></option>
												</select>
											</div>
											&nbsp;&nbsp; 
										
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 100px;" >Tip motora </span>
												<select class="selectpicker" name="fuel_type" id="fuel_type" >
												<?php
													if(@$vehicle_data['fuel_type'] === '0') {
														$option0 = ' selected';
													}
													if(@$vehicle_data['fuel_type'] === '1') {
														$option1 = ' selected';
													}
													if(@$vehicle_data['fuel_type'] === '2') {
														$option2 = ' selected';
													}
													if(@$vehicle_data['fuel_type'] === '3') {
														$option3 = ' selected';
													}
												?>
													<option value="0"<?=@$option0;?>>Benzin</option>
													<option value="1"<?=@$option1;?>>Diesel</option>
													<option value="2"<?=@$option2;?>>Benzin+Plin</option>													
													<option value="3"<?=@$option3;?>>Diesel+Plin</option>													
													</select>
											</div>											
											&nbsp;&nbsp;
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 100px;" >Pogon </span>
												<select class="selectpicker" name="wheel_drive" id="wheel_drive" >
												<?php
													if(@$vehicle_data['wheel_drive'] === '0') {
														$option0 = ' selected';
													}
													if(@$vehicle_data['wheel_drive'] === '1') {
														$option1 = ' selected';
													}
													if(@$vehicle_data['wheel_drive'] === '2') {
														$option2 = ' selected';
													}
												?>
													<option value="0"<?=@$option0;?>>Prednji pogon</option>
													<option value="1"<?=@$option1;?>>Zadnji pogon</option>
													<option value="2"<?=@$option2;?>>4x4 pogon</option>	
													
													</select>
											</div>											
											&nbsp;&nbsp;
											<div class="input-group">
												<span class="input-group-addon" style="min-width: 100px;" >Tip mjenjača </span>
												<select class="selectpicker" name="manual_automatic" id="manual_automatic" >
												<?php
													if(@$vehicle_data['manual_automatic'] === '0') {
														$option0 = ' selected';
													}
													if(@$vehicle_data['manual_automatic'] === '1') {
														$option1 = ' selected';
													}
													
												?>
													<option value="0"<?=@$option0;?>>Mehanički</option>
													<option value="1"<?=@$option1;?>>Automatski</option>
													</select>
											</div>	
											&nbsp;&nbsp;
											<div class="input-group ">
												<span class="input-group-addon" style="min-width: 100px;"> Snaga motora (u kW) </span>
												<input class="form-control" type="text" name="engine_power" maxlength="32"  value="<?=@$vehicle_data['engine_power'];?> " required>
											</div>
											&nbsp;&nbsp;		
											<hr />
											<div class="form-group">
												<label form="description">Opis vozila </label>
												<textarea class="form-control" name="description" id="description" rows="5" value="<?=@$vehicle_data['description'];?>" required></textarea>
											</div>
											&nbsp;&nbsp; 
											<div class="form-group">								
												<label class="control-label"> Odaberite sliku vozila </label>
												<input id="input-2" name="avozilo_slika" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" value="<?=@$vehicle_data['permalink'];?>" required>																		
											</div>																						
										<hr />													
										</div>
									</div>								
									<hr />
									
									<?php
									if(@$request_arr[1] === 'edit') {
										echo '<input type="hidden" name="id" value="'.$request_arr[2].'">'."\r\n";
									}
									?>
									
									<button type="submit" class="btn btn-default" name="<?=$html_data['button']['name'];?>" value="<?=$html_data['button']['value'];?>"><?=$html_data['button']['text'];?></button>
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
											<dt>Vrsta vozila</dt>
											<dd><pre>Primjer: Automobil </pre></dd>	
											<dt>Kategorija</dt>
											<dd><pre>Primjer: B </pre></dd>												
											<dt>Model </dt>
											<dd><pre>Fiat Bravo 1.9 GT TD 100</pre></dd>
											<dt>Godina </dt>
											<dd><pre>Primjer: 1998</pre></dd>											
										
											<dt>Tip motora</dt>
											<dd><pre>Primjer: Diesel</pre></dd>
											<dt>Pogon</dt>											
											<dd><pre>Primjer: Prednji pogon</pre></dd>	
											<dt>Tip mjenjača</dt>
											<dd><pre>Primjer: Prednji pogon</pre></dd>	
											<dt>Snaga motora</dt>												
											<dd><pre>Primjer (potrebno unijeti samo broj): 74</pre></dd>										
											<dt>Opis </dt>
											<dd><pre>Primjer: Ovo je opis vozila Fiat </pre></dd>
											<dt>Slika vozila </dt>
											<dd><pre>Napomena: Slika mora biti srednje veličine </pre></dd>
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
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 
	
	<!-- Edit HTML5 Required Message -->
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

	<script>
	function myFunction() {
		document.getElementById("vehiclesForm").reset();
		}
	</script>



</body>
</html>