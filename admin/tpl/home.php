<?php

if(!$is_logged_in) {
	header('Location: /login'); exit;
}
 $stats_data_query = '
	SELECT 
		(SELECT COUNT(id) FROM drivers) AS total_drivers,
		(SELECT COUNT(id) FROM info) AS total_info,
		(SELECT count(vehicle_type) FROM vehicles WHERE vehicle_type = 0) AS total_cars,
		(SELECT count(vehicle_type) FROM vehicles WHERE vehicle_type = 1) AS total_motorcycles,
		(SELECT creation_datetime FROM info ORDER BY creation_datetime DESC LIMIT 1) AS last_info,
		(SELECT creation_datetime FROM banner ORDER BY creation_datetime DESC LIMIT 1) AS last_banner,		
		(SELECT creation_datetime FROM drivers ORDER BY creation_datetime DESC LIMIT 1) AS last_driver,
		(SELECT creation_datetime FROM vehicles ORDER BY creation_datetime DESC LIMIT 1) AS last_vehicle
	 ';

	$stats_data = $db->query($stats_data_query);
	$stats_data = $stats_data->fetch_all(MYSQLI_ASSOC);

/** days_left till school classes **/ 
	$driver_query = 'SELECT * FROM drivers ORDER BY birthdate DESC LIMIT 4';
	$driver_data = $db->query($driver_query);
	$driver_data = $driver_data->fetch_all(MYSQLI_ASSOC);

	foreach ($driver_data as $k => $v){
		$driver_data[$k]['days_left'] = remaining_days($v['birthdate']); 
	}
 
	$info_query = 'SELECT * FROM info ORDER BY date DESC LIMIT 1';
	$info_data = $db->query($info_query);
	$info_data = $info_data->fetch_all(MYSQLI_ASSOC);

	foreach ($info_data as $k => $v){
		$info_data[$k]['days_left'] = remaining_days($v['date']); 
	}

 // Sort array by remaning days
 function orderDaysLeft($a, $b) {
		return $a['days_left'] - $b['days_left'];
	}
	usort($driver_data, 'orderDaysLeft');
	usort($info_data, 'orderDaysLeft');
 
 function remaining_days($datum) {	
	// get date of birthday this calendar year
	$parts 			= explode('-', $datum, 2);
	$class_date	 	= new DateTime(date('Y') . '-' . $parts[1] .' 00:00:00');
	$today 			= new DateTime('midnight today');

	if($class_date < $today) {
		// next birthday is in one year
		$class_date->modify('+1 Year'); 
	}

	// get number of days days remaining
	$diff = $class_date->diff($today);

	if($diff->days > 0) {
		return (int)$diff->days;
	} else {
		return 0;
	}
	
}
 					
// HTML Info Podaci
$html_data = array(
	'title' 		=> 'Administracija - Autoškola Formula',
	'description'	=> '',
	'author' 		=> 'Autoškola Formula',
	'page_title'	=> 'Administracija'	
);


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
    <link href="<?=BASE_URL;?>tpl/css/bootstrap.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?=BASE_URL;?>tpl/css/metisMenu.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="<?=BASE_URL;?>tpl/css/timeline.css" rel="stylesheet">
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

	<?php include('/include/navigation.html'); ?>
	
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$html_data['page_title'];?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=@$stats_data[0]['total_cars'];?></div>
                                    <div> Ukupno automobilnih vozila </div>
                                </div>
                            </div>
                        </div>
                        <a href="vehicles">
                            <div class="panel-footer">
                                <span class="pull-left">Pregled vozila </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bicycle fa-5x"></i>						
									
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=@$stats_data[0]['total_motorcycles'];?></div>
                                    <div> Ukupno motornih vozila </div>
                                </div>
                            </div>
                        </div>
                        <a href="motorcycles">
                            <div class="panel-footer">
                                <span class="pull-left">Pregled motornih vozila</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$stats_data[0]['total_drivers'];?></div>
                                    <div>Ukupno instruktora</div>
                                </div>
                            </div>
                        </div>
                        <a href="drivers">
                            <div class="panel-footer">
                                <span class="pull-left">Pregled instruktora </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-info fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$stats_data[0]['total_info'];?></div>                                   
                                    <div>Ukupno vijesti</div>
                                </div>
                            </div>
                        </div>
                        <a href="info">
                            <div class="panel-footer">
                                <span class="pull-left">Pregled vijesti o predavanjima</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-8">
				<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-dashboard fa-fw"></i> Aplikacija za administraciju "Autoškola Formula"  </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">                              
                               
                                <li>
                                    <div class="timeline-badge danger"><i class="fa fa-car"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><b>Vozila</b></h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p>Pomoću aplikacije moguće je dodati novo i pregledati sva vozila u bazi podataka aplikacije <b>Autoškola Formula</b>. U navigaciji s lijeve strane moguće je odabrati <q>Pregled vozila</q> i takva akcija vodi na listu prikaza svih automobila. Moguće je odabrati <q>Unos automobila</q> i <q>Unos motocikala</q>, a takve akcije vode na formu za unos i pohranu novih podataka.</p>
                                        </div>
                                    </div>
                                </li>
								<li class="timeline-inverted">
                                    <div class="timeline-badge success"><i class="fa fa-users"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><b>Instruktori</b></h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p>U navigaciji s lijeve strane moguće je odabrati <q>Pregled instruktora</q> i takva akcija vodi na listu prikaza svih instruktora pohranjenih u bazu podataka. U listi je moguće odabrati akcije <q>Uredi</q> i <q>Obriši</q>, a one se odnose na svakog pojedinog. Moguće je odabrati <q>Unos instruktora</q>, a takva akcija vodi na formu za unos i pohranu novih podataka.<hr> </p>
											<p><b>Napomena:</b>  Pri pohrani podataka o instruktoru potrebno je odabrati njegovo odgovarajuće vozilo pa je tako nužo imati vozilo prethodno evidentirano u bazi. </p>
										</div>
                                    </div>
                                </li>
								
                                <li>
                                    <div class="timeline-badge info"><i class="fa fa-picture-o"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><b> Naslovni banner na web-u </b></h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p> U navigaciji s lijeve strane moguće je odabrati <q>Pregled instruktora</q> i takva akcija vodi na listu prikaza svih pohranjenih slika koje čine banner. U listi je moguće odabrati akcije <q>Uredi</q> i <q>Obriši</q>, a one se odnose na svaku pojedinu. Moguće je odabrati <q>Unos slike</q>, a takva akcija vodi na formu za unos i pohranu novih podataka. </p>
                                            <hr>
                                     		<p><b>Napomena:</b> Postoji 3 vrste stiliziranog dizajna za prikaz slike bannera. Prvi stil je <q>Glavni</q> koji je namijenjen za dobrodošlicu. <q>Pozdravni</q> stil prikaza slike namijenjen je za ispis kratkih željenih informacija. Stil <q>S poveznicom</q> sadrži link s poveznicom koja vodi na web-stranicu <i>"O nama"</i>. <br/>Slika za banner koja je zadnja pohranjena, prikazuje se kao prva na početnoj stranici.</p>

                                        </div>
                                    </div>
                                </li>
                                <li>
                               
                                </li>
								 <li class="timeline-inverted">
                                    <div class="timeline-badge warning"><i class="fa fa-info"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><b>Vijesti o predavanjima</b></h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p> U navigaciji s lijeve strane moguće je odabrati <q>Pregled vijesti</q> i takva akcija vodi na listu prikaza svih pohranjenih vijesti o predavanjima. U listi je moguće odabrati akcije <q>Uredi</q> i <q>Obriši</q>, a one se odnose na svaku pojedinu. Moguće je odabrati <q>Unos vijesti vijest</q> ili <q>Dodaj vijest</q>, a takve akcije vode na formu za unos i pohranu novih podataka.  </p>
											<p><b>Napomena:</b> Zbog različitih vremenskih termina početka predavanja koji se odvijaju na isti dan, <b> potrebno je ručno unijeti poruku i datum i određene termine u polje za unos vijesti</b> (za prikaz na web-u), a nakon toga odabrati točan datum predavanja zbog programskog obračuna preostalih dana do predavanja (za prikaz u aplikaciji).</p>

                                        </div>
                                    </div>
                                </li>
                             <li>
                                    <div class="timeline-badge danger"><i class="fa fa-car"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><b>Korisnici</b></h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p>Pomoću aplikacije moguće je dodati novog korisnika aplikacije i pregledati sve korisnike aplikacije. U navigaciji s lijeve strane moguće je odabrati <q>Pregled korisnika</q> i takva akcija vodi na listu svih korisnika. Moguće je odabrati <q>Unos korisnika</q>, a takva akcija vodi na formu za unos i pohranu novih podataka.</p>
                                        	<p><b>Napomena:</b> Postoji dvije vrste računa korisnika: <b> <q>Administratorski</q> i <q>Korisnički</q>. </b> Korisnik s admninistratorskim računom ima mogućnost brisanja pohranjenih informacija, uz unos, modifikaciju i pregled, a s korisničkim tipom računa samo mogućnost pregleda i unosa novih podataka.</p>

										</div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Obavijesti
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                         
                                <a  class="list-group-item">
                                    <i class="fa fa-info fa-fw"></i> Zadnja pohranjena vijest
                                    <span class="pull-right small"><?=$stats_data[0]['last_info'];?>
                                    </span>
                                </a>
                                <a class="list-group-item">
                                    <i class="fa fa-picture-o fa-fw"></i> Zadnje pohranjen banner
                                    <span class="pull-right small"><?=$stats_data[0]['last_banner'];?>
                                    </span>
                                </a>
                                <a  class="list-group-item"> 
                                    <i class="fa fa-users fa-fw"></i> Zadnje pohranjen instruktor
                                    <span class="pull-right small"><?=$stats_data[0]['last_driver'];?>
                                    </span>
                                </a>
                                <a  class="list-group-item">
                                    <i class="fa fa-car fa-fw"></i> Zadnje pohranjeno vozilo
                                    <span class="pull-right small"><?=$stats_data[0]['last_vehicle'];?>
                                    </span>
                                </a>
								<?php foreach ($info_data as $info): ?>
                                <a class="list-group-item">
                                    <i class="fa fa-warning fa-fw"></i> Još je <b> <?=$info['days_left'];?> </b> dana do predavanja				
                                    <span class="pull-right small">   <?=$info['date'];?> </span>
									
                                  <?php endforeach ?> 
                                    </span>
                                </a>
								

                            </div>
                            <!-- /.list-group -->
                            <!-- <a href="#" class="btn btn-default btn-block">View All Alerts</a> -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
						
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-bell fa-fw"></i> Nadolazeće
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Br.</th>
                                            <th class="text-left">Ime</th>
                                            <th class="text-left">Prezime</th>
                                            <th class="text-left">Godina</th>
                                            <th class="text-left">Rođendan</th>
											<th class="text-center">Email </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php $cb=1;?>
									<?php foreach($driver_data as $data) : ?>
                                        <tr>
                                            <td class="text-left"><?=$cb++.'.';?></td>
                                            <td class="text-left"><?=$data['name'];?></td>
                                            <td class="text-left"><?=$data['surname'];?></td>
                                            <td class="text-center">(<?=date_diff(date_create($data['birthdate']), date_create('today'))->y;?>)</td>
                                            <td> Još <strong><?=$data['days_left'];?></strong> dana do rođendana.</td>
												<?php if($data['days_left'] > 0) : ?>
												<td class="text-center"><fieldset disabled=""><button type="submit" class="btn btn-default btn-sm"> <a href="mailto:info@whatshouldisay.ca">Šalji</a> </button></fieldset></td>
												<?php else: ?>
												
												<!--<td class="text-center"><fieldset><button type="submit" class="btn btn-warning btn-sm"> <a href="mailto:info@whatshouldisay.ca">Šalji</a></button></fieldset></td> -->
												<td class="text-center"><fieldset> <a href="mailto:<?=$data['email'];?>" class="btn btn-info" role="button">Šalji</a></td>
												<?php endif; ?>
												
                                        </tr>
									<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
				
				<div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-exclamation-circle fa-fw"></i> Upozorenja
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="container-fluid">
                         
                                <a  class="list-group-item">
                                    <i class="fa fa-users fa-fw"></i> O instruktorima: <br/>
                                    <span><p> Instruktor neće biti prikazan ako je njegovo vozilo obrisano iz baze podataka.</p>
									 
                                    </span>
                                </a>
                       
								<a  class="list-group-item">
                                    <i class="fa fa-picture-o fa-fw"></i> O slikama za banner: <br/>
                                    <span><p> Slika mora biti objavljena da bi kao sadržaj bila prikazana na web-stranici.</p>
                                    </span>
                                </a>
                       
								<a  class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> O korisnicima aplikacije: <br/>
                                    <span><p> Tip računa korisnika zavisi od dodjeljenih prava prilikom kreiranja računa. <br/>
									 Jednom pohranjeni korisnik administratorske aplikacije, ne može više biti obrisan.</p>
                                    </span>
                                </a>
								
								<a  class="list-group-item">
                                    <i class="fa fa-envelope-o fa-fw"></i> Podsjetnik o E-mail pošti: <br/>
                                    <span><p> Pregledavajte Vašu poštu zbog mogućih novih upita poslanih kroz kontakt formu na web-stranicama. </p>
									
                                    </span>
                                </a>

                            </div>
                            <!-- /.list-group -->
                            <!-- <a href="#" class="btn btn-default btn-block">View All Alerts</a> -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
				
				<div class="col-lg-4">
                    <div class="panel panel-default">
					   <div class="panel-heading">
                            <i class="fa fa-facebook fa-fw"></i> Facebook stranica
                        </div>
						  <div class="panel-body">
                            <div class="list-group">
							<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FAuto%25C5%25A1kola-Formula-1554848644822740%2F%3Fskip_nax_wizard%3Dtrue&tabs=timeline&width=480&height=700&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="480" height="800" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
							</div>
						</div>
					</div>
				</div>
				

				
				
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
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 
	
</body>
</html>