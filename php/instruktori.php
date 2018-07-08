<?php 

include('php/defaults/header.php'); 

// Get drivers data
 $driver_data_query = '
	SELECT
	drivers.id,
	drivers.name,
	drivers.surname,
	drivers.permalink,
	drivers.id_vehicle,
	vehicles.id AS vehicle_id,
	vehicles.vehicle_type,
	vehicles.model
	FROM drivers, vehicles
	WHERE drivers.id_vehicle = vehicles.id
	ORDER BY name ASC';

 $drivers_data = $db->query($driver_data_query);
 $drivers_data = $drivers_data->fetch_all(MYSQLI_ASSOC);
 
// HTML Info Podaci
  $html_data = array(
  'title' 		=> 'Instruktori - '.BRANDNAME,
  'description'	=> '',
  'author' 		=> 'Autoškola Formula',
  'page_title'	=> 'Instruktori'  
 ); 

 
?>

    <!-- CONTENT AREA -->
    <div class="content-area">
        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs text-center">
            <div class="container">
                <div class="page-header">
                    <h1>Instruktori</h1>
                </div>              
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE WITH SIDEBAR -->
        <section class="page-section sub-page">
            <div class="container">             

                <div class="row thumbnails portfolio isotope isotope-items">				
				<?php foreach ($drivers_data as $key => $value) : ?>
                    <div class="col-md-3 col-sm-6 isotope-item miscellaneous">					
                        <div class="thumbnail no-border no-padding">						
                            <div class="media">							
                                <img  height="175" width="262" src="admin/<?=$value['permalink'];?>" alt="<?=$value['name'];?>">
                                <div class="caption hovered">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                            <p class="caption-buttons">
											<a href="admin/<?=$value['permalink'];?>" class="btn caption-zoom" data-gal="prettyPhoto"><i class="fa fa-search"></i></a>                                              
                                            </p>
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="caption">				
                                <h3 class="caption-title"><a href="/instruktor/view/<?=$value['id'];?>">  <?=$value['name'];?> <?=$value['surname'];?> </a> </h3>
									<?php if ($value['vehicle_type'] === '0') {												
											echo "Automobil: ";												
											} else {
											echo " Motocikl: ";	
											}																								
									?>												
                                <p class="caption-category"><a href="/instruktor/view/<?=$value['id'];?>"><?=$value['model'];?></a> </p>
                            </div>						
                        </div>						
                    </div>
				<?php  endforeach; ?>	
                </div> 	<!-- /isotope-items -->					
				<hr class="page-divider"> </hr>
            </div>
        </section>
		
<?php include('php/defaults/contact.php'); ?>
		
    </div>
    <!-- /CONTENT AREA -->  
	
<?php include('php/defaults/footer.php'); ?>