<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}
// Get drivers data
 $drivers_data_query = '
	SELECT
	drivers.id,
	drivers.name,
	drivers.surname,
	drivers.mobile_phone,
	drivers.permalink,
	vehicles.id AS id_vehicle,
	vehicles.model,
	drivers.remark,
	users.id AS id_admin,
	users.username,
	users.permission
	FROM drivers, users, vehicles
	WHERE drivers.id_admin = users.id AND drivers.id_vehicle = vehicles.id
	ORDER BY surname ASC';

 $drivers_data = $db->query($drivers_data_query);
 $drivers_data = $drivers_data->fetch_all(MYSQLI_ASSOC);

// HTML Info Podaci
 $html_data = array(
 'title' 		=> 'Pregled instruktora - '.BRANDNAME,
 'description'	=> '',
 'author' 		=> 'Autoškola formula',
 'page_title'	=> 'Pregled instruktora'
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
    <link href="<?=BASE_URL?>tpl/css/bootstrap.css" rel="stylesheet">
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
                    <h1 class="page-header">Pregled instruktora</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pregled instruktora autoškole
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="drivers">
                                    <thead>
                                        <tr>
											<th>Br. <?php $r=1;?></th>
											<th>Slika instruktora</th>	
											<th>Ime i prezime, mob </th>
                                            <th>Osobni podaci </th>
											
                                            <th>Pregled instruktora</th>
											
                                            <th>Uredi instruktora</th>
											
                                            <th>Dodao</th>
										
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ($drivers_data as $key => $value) : ?>
                                        <tr class="<?=($i%2) ? 'even':'odd';?> gradeX">
											<td><?=($r++).'.';?></td>											
											<td><center> <img src="/admin/<?=$value['permalink'];?>" width="180" height="120"> </center></td>
											<td><?=$value['name'];?> <?=$value['surname'];?> </br> <em><?=$value['mobile_phone'];?> </em> </td>
                                            <td class="text-left"> Vozač je vozila <?=$value['model'];?>. </br> <i> <q><?php echo mb_strimwidth($value['remark'], 0, 54, "..."); ?></q> </i> </td>																						
                                            
											<td  class="text-center">	<a href="/admin/driver/view/<?=$value['id'];?>">Pregled</a></td>
											<td  class="text-center">	<a href="/admin/drivers-add/edit/<?=$value['id'];?>">Uredi</a></td>
																						
											<td class="text-center">	<a href="/admin/users"><i class="fa fa-user fa-fw"></i> <?=$value['username'];?></td>
											
											<?php if ($value['permission'] === '1') :?>  
                                            <td  class="text-center">	<a href="/admin/drivers-add/delete/<?=$value['id'];?>">Obriši</a></td>
											<?php endif;?>  
											
                                        </tr>										
									<?php endforeach; ?>
                                    </tbody>
									
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <div class="well">
							<a class="btn btn-default" name="Dodaj instruktora" href="drivers-add">Dodaj instruktora </a>	
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
	
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
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