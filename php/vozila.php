<?php 

include('php/defaults/header.php'); 

 $vehicle_data_query = '
	SELECT 
	id,
	vehicle_type,
	model,
	year,
	fuel_type,
	manual_automatic,
	permalink,
	description,
	engine_power,
	wheel_drive
	FROM vehicles 
	ORDER BY vehicle_type, model asc';

$vehicle_data = $db->query($vehicle_data_query);
$vehicle_data  = $vehicle_data->fetch_all(MYSQLI_ASSOC); 

?>

    <!-- CONTENT AREA -->
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs text-center">
            <div class="container">
                <div class="page-header">
                    <h1>VOZILA</h1>
                </div>               
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE WITH SIDEBAR -->
        <section class="page-section with-sidebar sub-page">
            <div class="container">
				<div class="clearfix text-center">
						<ul id="filtrable" class="filtrable clearfix">
							<li class=""><a href="#" class="filter" data-filter="*">Sva vozila</a></li>
							<li class=""><a href="#" class="filter" data-filter="cars">Automobili</a></li>
							<li class=""><a href="#" class="filter" data-filter="bikes">Motocikli</a></li>
							
						</ul>													
				</div>
                <div class="row">
                    <!-- CONTENT -->
                    <div class="col-md-9 content car-listing" id="content">

                        <!-- Car Listing -->	
					<?php foreach ($vehicle_data as $key => $value ): ?>

						<?php if ($value['vehicle_type'] === '0' ){
								$lyt = 'cars';
							} else {
								$lyt = 'bikes';
							} ?>
	
                        <div class="thumbnail no-border no-padding thumbnail-car-card clearfix <?=$lyt?>">
					
                            <div class="media">
                                <a class="media-link" data-gal="prettyPhoto" href="admin/<?=$value['permalink']; ?>"  >
                                    <img src="admin/<?=$value['permalink']; ?>" alt="<?=$value['model']; ?>" height="220" width="370" />
                                    <span class="icon-view"><strong><i class="fa fa-eye"></i> </strong></span>
                                </a>
                            </div>
						
                            <div class="caption">                              
                                <h4 class="caption-title"><?=$value['model']; ?></h4>
                               
                                <div class="caption-text"><?=$value['description']; ?></div>
								<br />
                                <table class="table">
                                    <tr>
                                        <td><?php if ($value['vehicle_type'] === '0' ){
											$class = 'fa fa-car';
										} else {
											$class = 'fa fa-cogs';
										}											
										?>
										<i class="<?=$class;?>"></i> <?=$value['year']; ?></td>
										
                                        <td><i class="fa fa-refresh fa-spin"></i> 	
										
											<?php if ($value['fuel_type'] === '0') {												
													$type_f = "Benzin " ;												
												}elseif($value['fuel_type'] === '1') {
													$type_f = "Diesel " ;	
												}else{
													$type_f = "Plin ";
												}																								
											?> <?=$type_f; ?> 
										</td>
												
                                        <td><i class="fa fa-cog fa-spin"></i> 
											<?php if ($value['manual_automatic'] === '0') {												
													$type_v = "mehanièki" ;												
												} else{
													$type_v = "automatski";
												} 
											?> 
												Mjenjaè brzina: <?=$type_v; ?>
										</td>
												
                                        <td><i class="fa fa-road"></i> 
											<?php if ($value['wheel_drive'] ==='0') {
												$wdrive = 'prednji';
												} elseif($value['wheel_drive'] ==='1'){
													$wdrive = 'zadnji';
												} else {
													$wdrive = '4x4';
												}											
											?>
											Pogon: <?=$wdrive; ?> 
										</td>
                                        <td><i class="fa fa-flash"></i> <?=$value['engine_power']; ?> kW</td>
										
                                    </tr>
                                </table>
                            </div>							
                        </div> 
                    
						
						<!-- clearfix -->
					<?php endforeach;?>	
			
                    </div>
                    <!-- /CONTENT -->
					
					 <aside class="col-md-3 sidebar" id="sidebar">                                    
                  
                        <div class="widget shadow widget-helping-center">
                            <h4 class="widget-title">Korisni linkovi</h4>
                            <div class="widget-content">                                                           
                                <p><a href="https://www.hak.hr/info/stanje-na-cestama/" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> Hrvatski Auto Klub (Stanje na cestama)</a></p>                               
                                <p><a href="http://www.auto-karta-hrvatske.com/" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  Auto-karta Hrvatske</a></p>                               
                                <p><a href="http://hac.hr/hr/cestarina" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> Hrvatske Auto Ceste (Cestarine)</a></p>                               
                                <p><a href="http://www.hak.hr/vozacki-ispiti/vozacka-dozvola" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> HAK.hr </a></p>       
                                <p><a href="http://www.mup.hr/46.aspx" target="_blank"><i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> MUP.hr </a></p>       
                         
                            </div>
                        </div>
                        <!-- /widget helping center -->
                    </aside>
					<!-- SIDEBAR -->
                    <aside class="col-md-3 sidebar" id="sidebar">                    
                   
                        <!-- widget helping center -->
                        <div class="widget shadow widget-helping-center">
                            <h4 class="widget-title">Kupujete li auto</h4>
                            <div class="widget-content">                                                           
                                <p><a href="http://www.citroen.hr/" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> Citroen </a></p>                               
                                <p><a href="http://www.fiat.hr/" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  Fiat </a></p>                               
                                <p><a href="http://www.opel.hr/" target="_blank"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> Opel </a></p>   
								
                            </div>
                        </div>
                        <!-- /widget helping center -->
                    </aside>
                    <!-- /SIDEBAR -->   
                </div>  <!-- /row --> 
				
				<hr class="page-divider"> </hr>
				
            </div>
        </section>
        <!-- /PAGE WITH SIDEBAR -->
		
<?php include('php/defaults/contact.php'); ?>

    </div>
    <!-- /CONTENT AREA -->
	
<?php include('php/defaults/footer.php'); ?>
