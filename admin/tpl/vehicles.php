<?php
 
if(!$is_logged_in) {
	header('Location: /login'); exit;
}

// Get vehicles data
 $vehicles_data_query = '
	SELECT
	vehicles.id,
	vehicles.model,
	vehicles.vehicle_type,
	vehicles.fuel_type,
	vehicles.permalink,
	vehicles.description,
	users.id AS id_admin,
	users.username,
	users.permission
	FROM vehicles,users
	WHERE vehicles.id_admin = users.id
	ORDER BY model ASC	
	';

 $vehicles_data = $db->query($vehicles_data_query);
 $vehicles_data = $vehicles_data->fetch_all(MYSQLI_ASSOC);

// HTML Info Podaci
 $html_data = array(
 'title' 		=> 'Pregled automobila  - '.BRANDNAME,
 'description'	=> 'Pregled automobila',
 'author' 		=> 'Autoškola Formula',
 'page_title'	=> 'Pregled automobila'
 ); 

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
                    <h1 class="page-header">Pregled automobila</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pregled automobila
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="vehicles-list">
                                    <thead>
                                        <tr>															                                                                                                                       											
											<th class="text-center">Br. <?php $r = 1;?> </th>																														                                                                                                                       											
											<th class="text-center">Slika vozila</th>
											<th class="text-center">Model vozila i opis</th>
											
                                            <th class="text-center">Pregled vozila</th>
											<th class="text-center">Uredi vozilo</th>
										
											<th class="text-center">Dodao </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ($vehicles_data as $key => $value) : ?>
										<?php if ($value['vehicle_type'] === '0') :?>										
											<tr class="<?=($i%2) ? 'even':'odd';?> gradeX">
												<td><?=($r++).'.';?></td>															                                                                          																																	                                                                             																				
																		                                                                             																																									                                                                             																				
												<td>  <center> <img src="<?=$value['permalink'];?>" width="180" height="120"></center>  </td>
												<td> <dl> <dt> <b><?=$value['model'];?> </b> </dt>										
												<?php	
												if ($value['fuel_type'] === '0') {
													$type_f = "Benzin";
												}
												elseif ($value['fuel_type'] === '1') {
													$type_f = "Diesel";
												}
												else  {
													$type_f = "Plin";
												}												
												?> <dd> - <?=@$type_f;?> </dd> <dd> - <?php echo mb_strimwidth($value['description'], 0, 57, "...");?> </dd> </dl> </td>													
												
												<td class="text-center"><a href="/admin/vehicle/view/<?=$value['id'];?>">Pregled</a></td>
												<td class="text-center"><a href="/admin/vehicles-add/edit/<?=$value['id'];?>">Uredi</a></td>
												<td class="text-center"><a href="/admin/users"><i class="fa fa-user fa-fw"></i> <?=$value['username'];?></td>
												<?php if ($value['permission'] === '1') :?>  
												<td class="text-center"><a href="/admin/vehicles-add/delete/<?=$value['id'];?>">Obriši</a></td>
												<?php endif;?>  
										

												
											</tr>									
										<?php endif; ?>
									<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <div class="well">
							<a class="btn btn-default" name="Dodaj novo vozilo" href="vehicles-add">Dodaj novo vozilo</a>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->


	
	<!-- jQuery -->
	<script src="<?=BASE_URL;?>tpl/js/jquery-ui.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=BASE_URL;?>tpl/js/bootstrap.js"></script>

	<!-- Dropdown Menu Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> 

	<!-- Bootstrap dropdown-menu -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=BASE_URL;?>tpl/js/metisMenu.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="<?=BASE_URL;?>tpl/js/sb-admin-2.js"></script>	
	
	<!-- Dropdown Menu Latest compiled and minified JavaScript -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> 
	 

	
</body>
</html>