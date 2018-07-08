<?php

	if(!$is_logged_in) {
		header('Location: /login'); exit;
	}
	include('tpl/classes/functions.php');

	date_default_timezone_set('Europe/Zagreb');
	$current_datetime = date('Y-m-d H:i:s');

	// Main HTML Data
	$html_data = array(
		'title' 		=> 'Pregled vozila - '.BRANDNAME,
		'description'	=> '',
		'author' 		=> 'Autoškola Formula',
		'page_title'	=> 'Pregled podataka o vozilu',

	);

// View 
if(@$request_arr[1] === 'view' AND !empty(@$request_arr[2])) {	

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
	
}
	
	if($vehicle_data['vehicle_type'] === '0') {
		$type = 'Automobil';
		} else {
		$type = 'Motor';
	}
	if($vehicle_data['manual_automatic'] === '0') {
		$typem = 'Mehanički';
		} else {
		$typem = 'Automatski';
	}
	if($vehicle_data['fuel_type'] === '0') {
		$typef = 'Benzin';
		} else if ($vehicle_data['fuel_type'] === '1') {
		$typef = 'Diesel';
		} else if ($vehicle_data['fuel_type'] === '2') {
		$typef = 'Diesel';
		} else if ($vehicle_data['fuel_type'] === '3') {
		$typef = 'Benzin + Plin';
		} else {
		$typef = 'Diesel + Plin';
		}
	
	if($vehicle_data['wheel_drive'] === '0'){
		$typew = 'Prednji pogon';
	}else if ($vehicle_data['wheel_drive'] === '1'){
		$typew = 'Zadnjipogon';
	}else {
		$typew = '4x4 pogon';
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

 
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Pregled slike banera
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form role="form" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="bannerForm">																												
									
									
									<div class="panel-body">
										<dl>  
											<dt>Model </dt>
											<dd><pre><?=@$vehicle_data['model'];?></pre></dd>
											<dt>Godina </dt>
											<dd><pre><?=@$vehicle_data['year'];?></pre></dd>

											<dt>Vrsta vozila</dt>
											<dd><pre><?=@$type;?></pre></dd>
											<dt>Tip motora </dt>
											<dd><pre><?=@$typef;?></pre></dd>
											
											<dt>Pogon</dt>											
											<dd><pre><?=@$typew;?></pre></dd>	
											<dt>Tip mjenjača</dt>
											<dd><pre><?=@$typem;?> </pre></dd>	
											<dt>Snaga motora</dt>												
											<dd><pre><?=@$vehicle_data['engine_power'];?></pre></dd>										
											<dt>Opis </dt>
											<dd><pre><?=@$vehicle_data['description'];?> </pre></dd>
											<dt>Slika vozila </dt>
<dd><pre><img src="/admin/<?=@$vehicle_data['permalink'];?>" class="img-rounded" alt="<?=@$vehicle_data['model'];?>" width="304" height="236"></pre></dd>
																																										
										</dl>
										<hr/>									
									
									</div>															
									
									
								</form>
							</div>
							<!-- /.col-lg-6 (nested) -->
				
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

	<!-- Dropdown Menu Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> 
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 

	
</body>
</html>