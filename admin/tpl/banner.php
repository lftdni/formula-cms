<?php

	if(!$is_logged_in) {
		header('Location: /login'); exit;
	}
	include('tpl/classes/functions.php');

	date_default_timezone_set('Europe/Zagreb');
	$current_datetime = date('Y-m-d H:i:s');

	// Main HTML Data
	$html_data = array(
		'title' 		=> 'Pregled slike - '.BRANDNAME,
		'description'	=> '',
		'author' 		=> 'Autoškola Formula',
		'page_title'	=> 'Pregled banera',
	);

// View 
	if(@$request_arr[1] === 'view' AND !empty(@$request_arr[2])) {
		
		if(is_numeric($request_arr[2])) {
			// Fetch costumer data from database by id
			$banner_id = $db->real_escape_string($request_arr[2]);
			 $banner_data_query = '
					 SELECT * FROM banner WHERE id = \''.$banner_id.'\'';		
			
			$banner_data = $db->query($banner_data_query);
			if(!$banner_data = $banner_data->fetch_assoc()) {
				header('Location: /banners'); exit;
			}
			
		} else {
			header('Location: /banners'); exit;
		}

	}

	if($banner_data['banner_type'] === '0') {
		$type = 'Glavni';
		} else if ($banner_data['banner_type'] === '1') {
		$type = 'Pozdravni';
		} else {
		$type = 'S poveznicom';
	}	

		if(@$banner_data['declaration'] === '0') {
			$decl= 'Ne';
		} else {
			$decl = 'Da';
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
    <link href="http://localhost/admin/tpl/css/bootstrap.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="http://localhost/admin/tpl/css/metisMenu.css" rel="stylesheet">
	<!-- DataTables CSS -->
    <link href="http://localhost/admin/tpl/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="http://localhost/admin/tpl/css/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="http://localhost/admin/tpl/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="http://localhost/admin/tpl/css/font-awesome.css" rel="stylesheet" type="text/css">
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
											<dt>Naslov</dt>											
											<dd><pre><?=@$banner_data['caption'];?></pre></dd>
											<dt>Poruka</dt>
											<dd><pre><?=@$banner_data['text'];?> </pre></dd>
											<dt>Opis</dt>
											<dd><pre><?=@$banner_data['description'];?></pre></dd>
									
											<dt>Dizajn prikaza</dt>									
											<dd><pre><?=@$type;?> </pre> </dd>	
											<dt>Objaviti na stranicama</dt>
											<dd><pre><?=@$decl;?> </pre></dd>
											<dt>Slika</dt>	

<dd><pre><img src="/admin/<?=@$banner_data['path'];?>" class="img-rounded" alt="<?=@$banner_data['caption'];?>" width="304" height="236"></pre></dd>
																				
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

    <script src="http://localhost/tpl/js/bootstrap.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="http://localhost/tpl/js/metisMenu.js"></script>
	<!-- Custom Theme JavaScript -->
    <script src="http://localhost/tpl/js/sb-admin-2.js"></script>	

	<!-- Dropdown Menu Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> 
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 

	
</body>
</html>