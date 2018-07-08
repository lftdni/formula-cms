
<?php
//include header
 include('php/defaults/header.php');

// Get drivers data
 $driver_data_query = '
	SELECT
	drivers.id,
	drivers.name,
	drivers.surname,
	drivers.permalink,
	drivers.creation_datetime,
	drivers.id_vehicle,
	drivers.mobile_phone,
	vehicles.id AS vehicle_id
	FROM drivers, vehicles
	WHERE drivers.id_vehicle = vehicles.id
	ORDER BY name ASC';

 $driver_data = $db->query($driver_data_query);
 $driver_data = $driver_data->fetch_all(MYSQLI_ASSOC);
 
// HTML Info Podaci
  $html_data = array(
  'title' 		=> 'Instruktor - '.BRANDNAME,
  'description'	=> '',
  'author' 		=> 'Autoškola Formula',
  'page_title'	=> 'Instruktor'  
 ); 

// request_arr from url
if(@$request_arr[1] === 'view' AND !empty(@$request_arr[2])) {
	
	if(is_numeric($request_arr[2])) {
		
		$driver_id = $db->real_escape_string($request_arr[2]);
		$driver_data_query = '
				 SELECT * FROM drivers WHERE id = \''.$driver_id.'\'';		
		
		$driver_data = $db->query($driver_data_query);
		if(!$driver_data = $driver_data->fetch_assoc()) {
			header('Location: /instruktor'); exit;
		}
		
	} 
	
}
	//get date in new format
	$s = $driver_data['creation_datetime'];
	$dt = new DateTime($s);
	$date = $dt->format('m/d/Y');

 ?>
 
    <!-- CONTENT AREA -->
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs text-center">
            <div class="container">
                <div class="page-header">
                    <h1>Detalji o instruktoru</h1>
                </div>
               
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE WITH SIDEBAR -->
        <section class="page-section sub-page">
		
            <div class="container">

                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 project-media">
                        <div class="img-carousel">
                            <div><img src="/admin/<?=$driver_data['permalink'];?>" alt="<?=$driver_data['name'];?> <?=$driver_data['surname'];?>"/></div>
                           <!--  <div><img src="assets/img/preview/portfolio/portfolio-x7.jpg" alt=""/></div> -->
                            <div><img src="/admin/<?=$driver_data['licence'];?>" alt="licenca"/></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-5 col-sm-7">
					
						<div class="project-details">
                            <h3 class="block-title"><span>Instruktor</span></h3>
							
																			  
                            <dl class="dl-horizontal">
                                <dt>Instruktor:</dt>
                                <dd><?=$driver_data['name'];?> <?=$driver_data['surname'];?> </dd>
                                <dt>Vozilo:</dt>
                                <dd>Golf XX</dd>
                                <dt>Mobitel:</dt>
                                <dd><?=$driver_data['mobile_phone'];?> </dd>
                                <dt>Član od:</dt>
                                <dd><?=$date;?></dd>								
                            </dl>
					
                        </div>						
                        <div class="project-overview">
                            <h3 class="block-title"><span>Detalji</span></h3>
							<p>  <?=$driver_data['remark'];?> </br> </p>
                            <p>Svi instruktori su naši iskusni vozači koji su pomno odabrali svoj posao i uživaju u njemu. Oni su potpora i sigurnost mladim vozačima, ali i nastoje da svaku vožnju učine ugodnom. </p>
                            <p>Opušteni vozač koji uživa u vožnji bolje obavlja posao i kao takav ima trenutni utjecaj na sigurnost na cesti i okolinu. </p>
                        </div>
                       
                    </div>

                </div>

                <hr class="page-divider"/>        
                    
            </div>
        </section>
        <!-- /PAGE WITH SIDEBAR -->
		
<?php include('php/defaults/contact.php'); ?>

    </div>  	   
	<!-- /CONTENT AREA -->    

<?php include('php/defaults/footer.php'); ?>