<?php 

	$banner_data_query = '
		SELECT 
		id,
		caption,
		text,
		description,
		path,
		declaration,
		banner_type
		FROM banner 
		';

	if (!($banner_data = $db->query($banner_data_query))) {
		die('MySQL error');
	}
	$banner_data  = $banner_data->fetch_all(MYSQLI_ASSOC); 

	$info_data_query = '
		SELECT 
		id,
		description,
		creation_datetime	
		FROM info 
		ORDER BY creation_datetime DESC';

	$info_data = $db->query($info_data_query);
	$info_data  = $info_data->fetch_all(MYSQLI_ASSOC); 

	$vehicle_data_query = '
		SELECT 
		vehicles.id,
		vehicles.model,
		vehicles.year,
		vehicles.fuel_type,
		vehicles.manual_automatic,
		drivers.id,
		drivers.name
		FROM vehicles, drivers
		WHERE drivers.id_vehicle = drivers.id
		ORDER BY model DESC';

	$vehicle_data = $db->query($vehicle_data_query);
	$vehicle_data  = $vehicle_data->fetch_all(MYSQLI_ASSOC); 

	$stats_data_query = '
	SELECT 
	(SELECT COUNT(id) FROM drivers) AS total_drivers,
	(SELECT count(vehicle_type) FROM vehicles WHERE vehicle_type = 0) AS total_cars
	';
	$stats_data = $db->query($stats_data_query);
	$stats_data = $stats_data->fetch_all(MYSQLI_ASSOC);

$html_data = array (
	'title' 		=> 'Početna stranica -' .BRANDNAME,
	'description'	=> '',
	'author'		=> '',
	'page_title'	=> BRANDNAME
	
);

?>

<?php $info_data_sliced = array_slice($info_data,0,1);  ?>

<?php include('php/defaults/header.php'); ?>
    <!-- CONTENT AREA -->
    <div class="content-area">
        <!-- PAGE -->
        <section class="page-section no-padding slider">
            <div class="container full-width">

                <div class="main-slider">								
		

                <div class="owl-carousel" id="main-slider" >
				
                        <!-- Slide 1 -->
						<?php foreach ($banner_data as $key => $value): ?> 						
						<?php if ($value['declaration'] === '1' AND $value['banner_type'] === '2'):?>	
											
                        <div class="item slide1 ver1" style="background-image: url(admin/<?=@$value['path']?>)">	

                            <div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">	
																															
											<div class="caption-content" >										
												<h2 class="caption-title"><strong> <?=$value['caption'];?> </strong></h2>
                                                <h3 class="caption-subtitle"> <?=$value['text'];?> </h3>
                                                <h2 class="caption-title"> <?=$value['description'];?>  </h2> 																				
                                            </div> 			
							
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>

						<?php endif;?>			
						<?php endforeach;?>
                        <!-- /Slide 1 --> 
					    <!-- Slide 2 -->	
						<?php foreach ($banner_data as $key => $value): ?> 	
						<?php  if ($value['declaration'] === '1' AND $value['banner_type'] === '1'):?>	

                        <div class="item slide3 ver3" style="background-image: url(admin/<?=@$value['path']?>)">							
                            <div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">
	
                                            <div class="caption-content" >
                                                <h2 class="caption-title"> <?=$value['caption'];?> </h2>
                                                <h3 class="caption-subtitle"> <?=$value['text'];?> </h3>
                                                <p class="caption-text"><?=$value['description'];?> </p>
													
                                            </div>
													
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
						
						<?php endif;?>			
						<?php endforeach;?>
                        <!-- /Slide 2 -->	

                        <!-- Slide 3 --> 
						<?php foreach ($banner_data as $key => $value): ?> 	
						<?php  if ($value['declaration'] === '1' AND $value['banner_type'] === '0'):?>	
			   
                        <div class="item slide2 ver2" style="background-image: url(admin/<?=@$value['path']?>)">
                            <div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">
                                            <div class="caption-content" >
                                           
                                                <h2 class="caption-subtitle"> <?=$value['caption'];?> </h2>
												<h2 class="caption-title"> <?=$value['text'];?> </h2>
                                                <p class="caption-text">
												<?=$value['description'];?>
                                                </p>
                                                <p class="caption-text">
                                                    <a class="btn btn-theme ripple-effect btn-theme-md" href="/o-nama">O nama</a>
                                                </p>
										
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
								
						<?php endif;?>			
						<?php endforeach;?>
                        <!-- /Slide 3 --> 
			
                    </div> <!-- owl-carousel--> 	
						
                </div>

            </div>
        </section>
        <!-- /PAGE -->
		<section class="page-section image">		
		<div class="container">
		<?php foreach ($info_data_sliced as $key => $value): ?> 
			<h2 class="section-title-news">                    
                <span> <?=$value['description'];?> </span>
            </h2>
		<?php endforeach; ?>
        </div>     		
		</section>		       

        <!-- PAGE -->
        <section class="page-section dark">
            <div class="container">

                <div class="row">
                    <div class="col-md-6 wow fadeInLeft" data-wow-offset="200" data-wow-delay="100ms">
                        <h2 class="section-title text-left">
                            <small> <strong> AUTOŠKOLA FORMULA </strong> </small>                           
                        </h2>
						
                        <p>Autoškola Formula djeluje već osam godina u gradu Rijeci i okolnim mjestima. Shodno zakonu o sigurnosti prometa na cestama od 20.08.2004.g. </p>
                        <p>Vožnja se obavlja na čitavom širem području Rijeke a prvi počeci i poligonske radnje na ispitnom poligonu na Srdočima gdje se i polaže vozački ispit. </p>
                        
						<ul class="list-icons">
                            <li><i class="fa fa-check-circle"></i>Organizira nastavu iz prometnih propisa i sigurnosnih pravila.</li>
                            <li><i class="fa fa-check-circle"></i>Organizira tečaj iz prve pomoći.</li>
                        
						</ul>
                        <p class="btn-row">
                            <a href="/kako-do-vozacke" class="btn btn-theme ripple-effect btn-theme-md">Kako do vozačke</a>
                            <a href="/cijene" class="btn btn-theme ripple-effect btn-theme-md btn-theme-transparent">Cijene usluga</a>
                        </p>
						
                    </div>
                    <div class="col-md-6 wow fadeInRight" data-wow-offset="200" data-wow-delay="300ms">
                        <div class="owl-carousel img-carousel">
                            <div class="item"><img class="img-responsive" src="<?=SITE_ROOT.'slider/ucionica1.jpg'?>" alt="autoškola formula"/></div>
                            <div class="item"><img class="img-responsive" src="<?=SITE_ROOT.'slider/ucionica2.jpg'?>" alt="autoškola formula"/></a></div>
                            <div class="item"><img class="img-responsive" src="<?=SITE_ROOT.'slider/Clio-4-zuti.jpg'?>" alt="autoškola formula"/></a></div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /PAGE -->    

        <!-- PAGE -->
        <section class="page-section">
            <div class="container">
				<h2 class="section-title wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms">
                    <small> Najnovija vozila </small>
                    <span> Odaberite svoj auto </span>
                </h2>
				
				<?php include ('php/defaults/tab-content.html');?>

            </div>    <!-- /container -->
        </section>
        <!-- /PAGE -->

        <!-- PAGE -->
        <section class="page-section image">
            <div class="container">

                <div class="row">
                    <div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-offset="200" data-wow-delay="100ms">
                        <div class="thumbnail thumbnail-counto no-border no-padding">
                            <div class="caption">
                                <div class="caption-icon"><i class="fa fa-heart"></i></div>
                                <div class="caption-number">PUNO</div>
                                <h4 class="caption-title">Zadovoljnih polaznika</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-offset="200" data-wow-delay="200ms">
                        <div class="thumbnail thumbnail-counto no-border no-padding">
                            <div class="caption">
                                <div class="caption-icon"><i class="fa fa-car"></i></div>
                                <div class="caption-number"><?=$stats_data[0]['total_cars']?></div>
                                <h4 class="caption-title">Vozila autoškole</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-offset="200" data-wow-delay="300ms">
                        <div class="thumbnail thumbnail-counto no-border no-padding">
                            <div class="caption">
                                <div class="caption-icon"><i class="fa fa-user"></i></div>
                                <div class="caption-number"><?=$stats_data[0]['total_drivers']?></div>
                                <h4 class="caption-title">INSTRUKTORA Autoškole</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-offset="200" data-wow-delay="400ms">
                        <div class="thumbnail thumbnail-counto no-border no-padding">
                            <div class="caption">
                                <div class="caption-icon"><i class="fa fa-map-marker"></i></div>
                                <div class="caption-number">Centar, Srdoči</div>
                                <h4 class="caption-title">Više lokacija</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /PAGE -->

<?php include('php/defaults/contact.php'); ?>

    </div>
	<!-- /CONTENT AREA -->	
	
<script type="text/javascript">
$(document).ready(function () {
    //Convert address tags to google map links - Copyright Michael Jasper 2011
    $('address').each(function () {
        var link = "<a href='http://maps.google.com/maps?q=" + encodeURIComponent( $(this).text() ) + "' target='_blank'>" + $(this).text() + "</a>";
        $(this).html(link);
    });
});
</script>	
	
<?php include('php/defaults/footer.php'); ?>