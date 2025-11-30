<?php
	$locations = get_nav_menu_locations();
	$footer_menu = wp_get_nav_menu_items($locations['footer']); 
?>
		<footer>
			<div class="row" id="footer">
				<div class="large-12 medium-12 small-12 columns">
					<nav id="footer__menu">
						<ul>
							<?php foreach($footer_menu as $item) : ?>
								<li><a href="<?=$item->url ?>" title="<?=$item->title ?>"><?=$item->title ?></a></li>
							<?php endforeach;?>
						</ul>
					</nav>
				</div>
				
				<div class="large-6 medium-6 small-12 columns">
					<p class="related">Centro associato a <br><a href="http://www.buddhismo.it/" title="Unione Buddhista Italiana" class="ubi">Unione Buddhista Italiana</a></p>
				</div>

				<div class="large-6 medium-6 small-12 columns">
					<p class="info">&copy; <?=date("Y")?> <?=bloginfo('name') ?><br>
					<?=bloginfo('description') ?><br>
					<a href="http://www.associazioneameco.it/contatti/">Vicolo d'Orfeo, 1 - 00193 Roma (RM)<br>
					(a 200 metri da San Pietro)</a><br>
					tel (+39) 06 68 65 148<br>
					CF 97057150589</p>					
				</div>				
			</div>
		</footer>


	<?php  wp_footer(); ?>


<!-- jQuery is called via the WordPress-friendly way via functions.php -->

<!-- this is where we put our custom functions -->
<script src="<?php bloginfo('template_directory'); ?>/js/scripts.js"></script>

<script>
      var elem = new Foundation.DropdownMenu($('.main-menu'));
      $(document).foundation();
</script>

<script type="text/javascript">
	$(document).ready(function() {
			$.cookiesDirective({
				privacyPolicyUri: '/privacy/cookies/',
				cookieScripts: 'Google Analytics ',
				linkColor: '#ffffff'
			});
	});
</script>

<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-71412067-1']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();	
</script>

</body>
</html>