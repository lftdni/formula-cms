<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}
// Get banner data
 $banner_data_query = '
	SELECT
	banner.id,
	banner.caption,
	banner.text,
	banner.declaration,
	banner.path,
	users.id AS id_admin,
	users.username,
	users.permission
	FROM banner, users
	WHERE banner.id_admin = users.id
	ORDER BY text ASC';

 $banner_data = $db->query($banner_data_query);
 $banner_data = $banner_data->fetch_all(MYSQLI_ASSOC);
 
// HTML Info Podaci
 $html_data = array(
 'title' 		=> 'Pregled banera - '.BRANDNAME,
 'description'	=> '',
 'author' 		=> 'Autoškola Formula',
 'page_title'	=> 'Pregled banera'  
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
                    <h1 class="page-header">Pregled banera </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pregled banera web stranice
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="pregled_banera">
                                    <thead>
                                        <tr>
											<th>Br. <?php $r = 1; ?></th>
											
											<th class="text-center">Slika</th>
											<th class="text-center">Objavljen</th>
											<th class="text-center">Naslov</th>
                                                                                      

                                            <th class="text-center">Pregled</th>
                                            <th class="text-center">Uredi baner</th>
											
											<th>Dodao</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ($banner_data as $key => $value) : ?>
									
                                        <tr class="<?=($i%2) ? 'even':'odd';?> gradeX">
										
											<td><?=($r++).'.';?></td>																			
											<td class="text-center"> <img src="/admin/<?=$value['path'];?>" width="180" height="120"></td>
										
											<td class="text-left"> <mark>  
											<?php	
											if ($value['declaration'] === '0') {
												$decl = "Nije objavljen";
											} else {
												$decl = "Objavljen";
											}											
											?>	
											<?=@$decl;?> </mark></td> 
											
											<td><?=$value['caption'];?></td>
							
                    
                                            <td class="text-center"><a href="/admin/banner/view/<?=$value['id'];?>">Pregled</a></td>
											
                                            <td class="text-center"> <a href="/admin/banners-add/edit/<?=$value['id'];?>">Uredi</a> </td>
											<td class="text-center"><a href="/admin/users"><i class="fa fa-user fa-fw"></i> <?=$value['username'];?></td>
											<?php if ($value['permission'] === '1') :?> 
                                            <td class="text-center"> <a href="/admin/banners-add/delete/<?=$value['id'];?>">Obriši</a> </td>
											<?php endif;?> 											
                                       		

							
                                        </tr>
										
									<?php endforeach; ?>
								
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->		
							
                            <div class="well">						
							<a class="btn btn-default" name="Dodaj baner" href="banners-add">Dodaj novi baner</a>							
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