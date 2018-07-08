<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}

// Get USERS Data
$user_data_query = '
		SELECT
		id,
		first_name,
		last_name,
		username,
		email,
		creation_datetime
		FROM users
		ORDER BY last_name ASC';
		
$user_data = $db->query($user_data_query);
$user_data = $user_data->fetch_all(MYSQLI_ASSOC);

// HTML Info Podaci
$html_data = array(
	'title' 		=> 'Pregled korisnika - '.BRANDNAME,
	'description'	=> '',
	'author' 		=> 'Nives Miletić',
	'page_title'	=> 'Pregled korisnika'
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
	<!-- DataTables CSS -->
    <link href="<?=BASE_URL;?>tpl/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="<?=BASE_URL;?>tpl/css/dataTables.responsive.css" rel="stylesheet">
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
                    <h1 class="page-header">Pregled korisnika</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pregled korisnika sustava
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="pregled_korisnika">
                                    <thead>
                                        <tr>
											<th>Br. <?php $r = 1; ?> </th>
											<th>Ime</th>
                                            <th>Prezime</th>
                                            <th>Korisničko Ime</th>
                                            <th>E-Mail</th>                                          
                                            <th>Datum Registracije</th>
                                            <th>Uredi korisnika</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ($user_data as $key => $value) : ?>
									<!--<?php
										@$i++;
										if($value['permissions'] === '0') {
											$acc_type = 'Korisnik';
										} else {
											$acc_type = 'Administrator';
										}
									?>-->
                                        <tr class="<?=($i%2) ? 'even':'odd';?> gradeX">
											<td><?=($r++).'.' ;?></td>
											<td><?=$value['first_name'];?></td>
                                            <td><?=$value['last_name'];?></td>
                                            <td><?=$value['username'];?></td>
                                            <td><?=$value['email'];?></td>
                                            <!-- <td><?=$acc_type;?></td>-->
                                            <td><?=$value['creation_datetime'];?></td>
                                            <td><a href="/users-add/edit/<?=$value['id'];?>">Uredi</a></td>
                                          
                                        </tr>
									<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                           <div class="well">
							<a class="btn btn-default" name="Dodaj vijest" href="users-add">Dodaj korisnika</a>
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
	

</body>
</html>