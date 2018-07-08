<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}

// Get customers data
$info_data_query = '
	SELECT
	info.id,
	info.description,
	info.date,
	info.creation_datetime,
	users.id AS id_admin, 
	users.username,
	users.permission
	FROM info, users
	WHERE info.id_admin = users.id
	ORDER BY creation_datetime DESC
	';

$info_data = $db->query($info_data_query);
$info_data = $info_data->fetch_all(MYSQLI_ASSOC);

// HTML Info Podaci
$html_data = array(
	'title' 		=> 'Pregled klijenata - '.BRANDNAME,
	'description'	=> ' ',
	'author' 		=> 'Nives Miletić',
	'page_title'	=> 'Pregled klijenata'
	
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
	
	
</head>

<body>

    <div id="wrapper">
	
	<?php include('tpl/include/navigation.html'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Pregled vijesti</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pregled vijesti održavanja predavanja
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="pregled_korisnika">
                                    <thead>
                                        <tr>
											<th class="text-center">Br <?php $r = 1; ?> </th> 
											
											<th class="text-center">Datum predavanja</th>                                           
											<th class="text-center">Vijest</th>                                           
											<th class="text-center">Uredi vijest</th>   
																					
											<th class="text-center">Dodao</th> 
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ($info_data as $key => $value) : ?>
                                        <tr class="<?=($i%2) ? 'even':'odd';?> gradeX">
										
											<td><?=($r++).'.';?></td>
											
											<td><?=$value['date'];?></td>
											<td><?=$value['description'];?></td>

                                            <td><a href="/admin/info-add/edit/<?=$value['id'];?>">Uredi</a></td>
											<td class="text-center"><a href="/admin/users"><i class="fa fa-user fa-fw"></i> <?=$value['username'];?></td>
											
											<?php if ($value['permission'] === '1') :?> 
                                            <td><a href="/admin/info-add/delete/<?=$value['id'];?>">Obriši</a></td>
											<?php endif;?> 

                                        </tr>
									<?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <div class="well">
							<a class="btn btn-default" name="Dodaj vijest" href="info-add">Dodaj vijest</a>
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