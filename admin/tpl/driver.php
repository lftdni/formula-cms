<?php

	if(!$is_logged_in) {
		header('Location: /login'); exit;
	}
	include('tpl/classes/functions.php');

	date_default_timezone_set('Europe/Zagreb');
	$current_datetime = date('Y-m-d H:i:s');
	


	// Main HTML Data
	$html_data = array(
		'title' 		=> 'Pregled instruktora slike - '.BRANDNAME,
		'description'	=> '',
		'author' 		=> 'Autoškola Formula',
		'page_title'	=> 'Pregled instruktora',
		'button'		=> array('name' => 'add_banner', 'value' => 'true', 'text' => 'Dodaj sliku')
	);

	if(@$request_arr[1] === 'view' AND !empty(@$request_arr[2])) {	

		if(is_numeric($request_arr[2])) {	
		
			// Fetch data from database by id
			$driver_id = $db->real_escape_string($request_arr[2]);
			$driver_data_query = '
			SELECT *
			FROM drivers 
			WHERE (drivers.id = \''.$driver_id.'\') 
			';	
			
			$driver_data = $db->query($driver_data_query);
			if(!$driver_data = $driver_data->fetch_assoc()) {
				header('Location: /drivers'); exit;
			}				
		} 
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
											<dt>Ime</dt>
											<dd><pre><?=@$driver_data['name'];?></pre></dd>
											<dt>Prezime</dt>
											<dd><pre><?=@$driver_data['surname'];?></pre></dd>																						
											<dt>Datum rođenja</dt>
											<dd><pre><?=@$driver_data['birthdate'];?></pre></dd>	
											<dt>Mobitel</dt>
											<dd><pre><?=@$driver_data['mobile_phone'];?></pre></dd>	
											<dt>Email</dt>
											<dd><pre><?=@$driver_data['email'];?> </pre></dd>
											<dt>Opaska </dt>
											<dd><pre><?=@$driver_data['remark'];?> </pre></dd>										
											<dt>Slika s vozilom</dt>
<dd><pre><img src="/admin/<?=@$driver_data['permalink'];?>" class="img-rounded" alt="<?=@$driver_data['name'];?>" width="304" height="236"></pre></dd>
											<dt>Slika s licencom</dt>
											<dd><pre><img src="/admin/<?=@$driver_data['licence'];?>" class="img-rounded" alt="<?=@$banner_data['name'];?>" width="304" height="236"></pre></dd>
																					
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