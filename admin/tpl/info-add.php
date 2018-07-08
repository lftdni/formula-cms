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


//echo '<pre>',print_r($_POST),'</pre>'; exit;

// HTML Info Data
$html_data = array(
	'title' 		=> 'Unos vijesti - ' .BRANDNAME,
	'description'	=> '',
	'author' 		=> 'Autoškola Formula',
	'page_title'	=> 'Unos vijesti',
	'button'		=> array('name' => 'add_info', 'value' => 'true', 'text' => 'Dodaj vijest')
);

if(@$_POST['add_info'] === 'true' OR @$_POST['edit_info'] === 'true') {
	
	// Make info_data array with trimed values	
	$info_data = array();
	
	foreach($_POST as $value => $key) {
		$info_data[$value] = trim($key);
 	}
	
	$messages = array();
	// Check if info has lower then 128 chars
	if(strlen($info_data['description']) > 255) {
		$messages[] = array('status' => 'error', 'message' => 'Vijest može sadržavati maksimalno 255 znaka.');
	}	

	if($error = $validations->upcoming(array($info_data['day'], $info_data['month'], $info_data['year']))) {
	 $messages[] = $error;
	}
	
	// IF empty messages(no errors) continue
	if(!$messages) {		
	
		$info_data['creation_datetime'] 	= $current_datetime;
		$info_data['lastupdate_datetime'] 	= $current_datetime;	
		$info_data['date'] = $info_data['year'].'-'.$info_data['month'].'-'.$info_data['day'];
		
		unset (			
	
			$info_data['day'],
			$info_data['month'],
			$info_data['year'],		
			$info_data['add_info']
		);
		
		$info_data['id_admin'] = $_SESSION['user_id'];
				
		if(@$_POST['add_info'] === 'true') { 	// ADD in Db
			
			$add_info_query = 'INSERT INTO `formuladb`.`info` (`'.implode('`, `', array_keys($info_data)).'`) VALUES (\''.implode('\', \'', $info_data).'\')';

			if($db->query($add_info_query)) {
				
				$array_message = 'Vijest "'.$info_data['description'].'" je uspješno unesena u bazu podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);					
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
		}elseif (@$_POST['edit_info'] === 'true') { // UPDATE IN DATABASE
		
			$info_id = $db->real_escape_string($info_data['id']);
			
			$info_data['lastupdate_datetime'] 	= $current_datetime;
		
		
			unset (			
			$info_data['id'],				
			$info_data['creation_datetime'],
			$info_data['edit_info']
			);
			
			$sql_update_data = ' ';
			
			foreach($info_data as $key => $value) {
				if($value == end($info_data)) {
					$sql_update_data .= $key.'=\''.$value.'\' '; //Space at end
				} else {
					$sql_update_data .= $key.'=\''.$value.'\', '; //Space with comma on end
				}
			}		
				
			$update_info_query = 'UPDATE `formuladb`.`info` SET '.$sql_update_data.' WHERE id ='.$info_id.'';
			 // var_dump($update_info_query); exit;
			 
			if($db->query($update_info_query)) {
				$array_message = 'Vijest za tečaj dana "'.$info_data['date'].'" je uspješno ažurirana u bazi podataka.';
				$messages[] = array('status' => 'success', 'message' => $array_message);
			} else {
				$messages[] = array('status' => 'error', 'message' => $db->error);
			}
			
		}			
		
	}
}

// Delete 

if(@$request_arr[1] === 'delete' AND !empty(@$request_arr[2])) {	
	if(is_numeric($request_arr[2])) {
		
		$info_id = $db->real_escape_string($request_arr[2]);	
		$delete_info_query = 'DELETE FROM info WHERE id = \''.$info_id.'\'';

		if($db->query($delete_info_query)) {

			if($db->affected_rows === 1) {
				//header('Location: /info');
				$messages[] = array('status' => 'success', 'message' => 'Vijest je uspješno obrisana.');
			} else {				
				header('Location: admin/info');
			}
		} else {
			$messages[] = array('status' => 'error', 'message' => 'Vijest nije obrisana. Nešto nije u redu sa bazom podataka.');
		}
	} else {
		// $messages[] = array('status' => 'error', 'message' => 'Hack protection!');
		header('Location: /home'); exit;
	}	
}

// Edit 
if(@$request_arr[1] === 'edit' AND !empty(@$request_arr[2])) {
	
	if(is_numeric($request_arr[2])) {
		
		$info_id 			= $db->real_escape_string($request_arr[2]);
		$info_data_query 	= '
		SELECT *,
		DATE_FORMAT(date, \'%d\') AS day,
		DATE_FORMAT(date, \'%m\') AS month,
		DATE_FORMAT(date, \'%Y\') AS year
		FROM info WHERE id = \''.$info_id.'\'';
		$info_data 			= $db->query($info_data_query);
		$info_data 			= $info_data->fetch_assoc();
					
	} else {
		header('Location: \info-add'); exit;
	}
	
	$html_data = array(
		'title' 		=> 'Uredi Vijest' .BRANDNAME,
		'description'	=> '',
		'author' 		=> 'Autoškola Formula',
		'page_title'	=> 'Uredi vijest',
		'button'		=> array('name' => 'edit_info', 'value' => 'true', 'text' => 'Dodaj vijest')
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

	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Bootstrap 
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  
  
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
						Ispunite informacije o novoj obavijesti
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form role="form" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="NewsForm" "<?php $_PHP_SELF ?>">
								
									<div class="form-group">
										<label>Vijest</label>
										<input class="form-control" type="text" name="description" maxlength="255" placeholder="Unesite obavijest" value="<?=@$info_data['description'];?>" required>
										<p class="help-block">(primjer: Novi tečaj počinje u utorak 29.03.2016. u 11:00 ili 14:30 ili 18:00 sati ili po dogovoru individualno)</p>
									</div>
									&nbsp;&nbsp;	             
									<div class="input-group">
									<span class="input-group-addon" style="min-width: 150px;">Datum predavanja</span>
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="day" required>
													<option value="" selected>Dan</option>
													<?php
													foreach (range(1, 31) as $day) {
														if($day == @$info_data['day']) {
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
												<select class="form-control" name="month" required>
													<option value="" selected>Mjesec</option>
													<?php
													foreach (range(1, 12) as $month) {
														if($month == @$info_data['month']) {
															$selected = ' selected';
														} else {
															$selected = '';
														}
														echo '<option'.$selected.' value='.$month.'>'.$month.'</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group" >
												<select class="form-control" name="year" id="year" required>
													<option value="" selected>Godina</option>
													<?php
													foreach (range(date('Y'), 2000) as $year) {
														if($year == @$info_data['year']) {
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
									<p class="help-block">(napomena: Ovdje ponovo odabirete datum predavanja koji ste naveli)</p>
	
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
											<dt>Vijest</dt>
											<dd><pre>U polje vijest navodi se i vrijeme idućeg predavanja </br>(datum i različito vrijeme).</pre></dd>											
										</dl>
										<dl>
											<dt>Datum</dt>
											<dd><pre>Napomena: Ponovo odabirete kako bi se u administracijskom panelu </br> moglo prikazati preostalo dana do navedenog datuma predavanja</pre></dd>											
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
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 	
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=BASE_URL?>tpl/js/bootstrap.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=BASE_URL?>tpl/js/metisMenu.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="<?=BASE_URL?>tpl/js/sb-admin-2.js"></script>	
	
	<!-- Dropdown Menu Latest compiled and minified JavaScript -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> 

    <!-- Bootstrap DatePicker -->
    <script src="http://localhost/tpl/js/bootstrap-datepicker.js"></script> 

	
	
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


<script type="text/javascript">
	$(document).ready(function () {                
		$('#datepicker').datepicker({
			format: "dd/mm/yyyy"
		});  
	});
</script>


<script>
function myFunction() {
	document.getElementById("NewsForm").reset();
	}
</script>

<script>
function myFunction() {
	document.getElementById("year").reset();
	}
</script>


</body>
</html>