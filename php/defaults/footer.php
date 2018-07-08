    
	<!-- FOOTER -->
    <footer class="footer">
        <div class="footer-meta">
            <div class="container">
                <div class="row">

                    <div class="col-sm-12">
                        <p class="btn-row text-center">
                            <a href="https://www.facebook.com/pages/Autoskola-Formula/263597837012218" target="_blank" class="btn btn-theme ripple-effect btn-icon-left facebook wow fadeInDown" data-wow-offset="20" data-wow-delay="100ms"><i class="fa fa-facebook"></i>FACEBOOK</a>
                            <a href="#" target="_blank" class="btn btn-theme btn-icon-left ripple-effect twitter wow fadeInDown" data-wow-offset="20" data-wow-delay="200ms"><i class="fa fa-twitter"></i>TWITTER</a>
                        </p>
                        <div class="copyright"> <strong> 2016 &copy; Autoškola Formula </strong> </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->

    <div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>

</div>
<!-- /WRAPPER -->

<!-- JS Global -->
<script src="/assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- JS Global  <script src="/assets/plugins/bootstrap-select/js/bootstrap-select.min.js"></script> -->
<script src="/assets/plugins/superfish/js/superfish.min.js"></script>
<script src="/assets/plugins/prettyphoto/js/jquery.prettyPhoto.js"></script>
<script src="/assets/plugins/owl-carousel2/owl.carousel.min.js"></script>
<script src="/assets/plugins/jquery.sticky.min.js"></script>
<script src="/assets/plugins/jquery.easing.min.js"></script>
<script src="/assets/plugins/jquery.smoothscroll.min.js"></script>
<!--<script src="assets/plugins/smooth-scrollbar.min.js"></script>-->
<!-- <script src="assets/plugins/wow/wow.min.js"></script>
<script>
     WOW - animated content
    new WOW().init();
</script> -->
<!-- <script src="/assets/plugins/swiper/js/swiper.jquery.min.js"></script> -->
<script src="/assets/plugins/datetimepicker/js/moment-with-locales.min.js"></script> 
<script src="/assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- JS Page Level -->
<script src="/assets/js/theme-ajax-mail.js"></script>
<script src="/assets/js/theme.js"></script>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/assets/plugins/jquery.cookie.js"></script>
<!--<![endif]-->

<script type="text/javascript">
	$(document).ready(function(){
		$(".filter").click(function(){					 
		var dataFilter = $(this).data("filter"); 					 
		switch(dataFilter){					 
		case "*":
		$(".bikes").show();
		$(".cars").show();
		break; 
		case "bikes":					 
		$(".bikes").show();
		$(".cars").hide();
		break;
		case "cars":
		$(".bikes").hide();
		$(".cars").show();
		break;					 
		}
		});
		return false;
	});
</script>

</body>
</html>
