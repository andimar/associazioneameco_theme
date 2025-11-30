<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
?><!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head id="<?php echo of_get_option('meta_headid'); ?>">

	<meta charset="<?php bloginfo('charset'); ?>">

	<!-- Always force latest IE rendering engine (even in intranet) -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->

	<?php define('THEME_URL',  get_template_directory_uri() ); ?>

  <?php if (is_search()) echo '<meta name="robots" content="noindex, nofollow" />';	?>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<meta name="title" content="<?php wp_title( '|', true, 'right' ); ?>">

	<!--Google will often use this as its description of your page/site. Make it good.-->
	<meta name="description" content="<?php bloginfo('description'); ?>" />

	<?php
		if (true == of_get_option('meta_author'))
			echo '<meta name="author" content="' . of_get_option("meta_author") . '" />';

		if (true == of_get_option('meta_google'))
			echo '<meta name="google-site-verification" content="' . of_get_option("meta_google") . '" />';
	?>

	<meta name="Copyright" content="Copyright &copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?>. Tutti i diritti riservati.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

	<?php
		/*
			j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag
			 - device-width : Occupy full width of the screen in its current orientation
			 - initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
			 - maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
			 - minimal-ui = iOS devices have minimal browser ui by default

		if (true == of_get_option('meta_viewport'))
			echo '<meta name="viewport" content="' . of_get_option("meta_viewport") . ' minimal-ui" />';
		*/
		/*
			These are for traditional favicons and Android home screens.
			 - sizes: 1024x1024
			 - transparency is OK
			 - see wikipedia for info on browser support: http://mky.be/favicon/
			 - See Google Developer docs for Android options. https://developers.google.com/chrome/mobile/docs/installtohomescreen
		*/
		if (true == of_get_option('head_favicon')) {
			echo '<meta name="mobile-web-app-capable" content="yes">';
			echo '<link rel="shortcut icon" sizes="1024x1024" href="' . of_get_option("head_favicon") . '" />';
		}

		/*
			The is the icon for iOS Web Clip.
			 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4 retina display (IMHO, just go ahead and use the biggest one)
			 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
			 - Transparency is not recommended (iOS will put a black BG behind the icon) -->';
		*/
		if (true == of_get_option('head_apple_touch_icon'))
			echo '<link rel="apple-touch-icon" href="' . of_get_option("head_apple_touch_icon") . '">';

		
	?>

	
	<?php 
		
		$flag = function_exists('pll_the_languages') ? (object) array_shift(array_filter( pll_the_languages([ 'raw' => 1 ]), function ($lang){ return !$lang['current_lang']; })) : null; 

		$flag->image = empty( $flag ) ? '' : THEME_URL . '/images/social_buttons/' . ( $flag->name == 'English' ? 'united-kingdom.svg': 'italy.svg' );
		$flag->title = empty( $flag ) ? '' : ( $flag->name == "English" ? 'English Version' : 'Versione Italiana' );

		$social_buttons = [
			(object) [ 'id' => 'yu-button', 'text' => 'Scopri il Canale YouTube', 'src' => THEME_URL . '/images/social_buttons/youtube.svg',   'link' => 'https://www.youtube.com/channel/UC-3RwdljLmN4L19ZCgGYVnA'],
			(object) [ 'id' => 'fb-button', 'text' => 'Seguici su Facebook','src' => THEME_URL . '/images/social_buttons/facebook.svg',  'link' => 'https://www.facebook.com/A.Me.Co.roma' ],
			(object) [ 'id' => 'ig-button', 'text' => 'Guarda il profilo Istagram','src' => THEME_URL . '/images/social_buttons/instagram.svg', 'link' => 'https://www.instagram.com/ameco_roma/' ]
		];

	?>
							
						
	<link rel="stylesheet" href="<?=THEME_URL?>/libs/foundation/css/foundation.min.css" />
	<!-- concatenate and minify for production -->
	<?php if(is_home()) : ?>
		<link rel="stylesheet" href="<?=THEME_URL?>/css/home.css" />
	<?php elseif (is_tax( 'attivita')): ?>
		<link rel="stylesheet" href="<?=THEME_URL?>/css/activities.css" />
	<?php elseif (is_post_type_archive('insegnanti')) : ?>
		<link rel="stylesheet" href="<?=THEME_URL?>/css/teachers.css" />
	<?php elseif (is_tax( 'conduttori' )) : ?>
		<link rel="stylesheet" href="<?=THEME_URL?>/css/cd.css" />
	<?php else: ?>
		<link rel="stylesheet" href="<?=THEME_URL?>/css/single.css" />
	<?php endif; ?>

	<!-- Application-specific meta tags -->
	<?php
		// Windows 8
		if (true == of_get_option('meta_app_win_name')) {
			echo '<meta name="application-name" content="' . of_get_option("meta_app_win_name") . '" /> ';
			echo '<meta name="msapplication-TileColor" content="' . of_get_option("meta_app_win_color") . '" /> ';
			echo '<meta name="msapplication-TileImage" content="' . of_get_option("meta_app_win_image") . '" />';
		}

		// Twitter
		if (true == of_get_option('meta_app_twt_card')) {
			echo '<meta name="twitter:card" content="' . of_get_option("meta_app_twt_card") . '" />';
			echo '<meta name="twitter:site" content="' . of_get_option("meta_app_twt_site") . '" />';
			echo '<meta name="twitter:title" content="' . of_get_option("meta_app_twt_title") . '">';
			echo '<meta name="twitter:description" content="' . of_get_option("meta_app_twt_description") . '" />';
			echo '<meta name="twitter:url" content="' . of_get_option("meta_app_twt_url") . '" />';
		}

		// Facebook
		if (true == of_get_option('meta_app_fb_title')) {
			echo '<meta property="og:title" content="' . of_get_option("meta_app_fb_title") . '" />';
			echo '<meta property="og:description" content="' . of_get_option("meta_app_fb_description") . '" />';
			echo '<meta property="og:url" content="' . of_get_option("meta_app_fb_url") . '" />';
			echo '<meta property="og:image" content="' . of_get_option("meta_app_fb_image") . '" />';
		}
	?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>


	<header>
	  <div class="row header">
	    <div class="large-2 columns">
				<h1 id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	    </div>
	    <div id="btns_desktop" class="large-8 columns claim hidden-for-small-only ">
			<p class="lettering"><a href="<?=esc_url( home_url( '/' ) ); ?>"></a></p>

			<?php if ( !wp_is_mobile() ) : ?>
				<div class="large-5 columns desktop_header_buttons">
					<?php foreach( $social_buttons as $socbtn) : ?>				
						<a id="<?=$socbtn->id?>" class="social_button column" href="<?=$socbtn->link?>" target="_blank" title="<?=$socbtn->text?>">
							<img src="<?=$socbtn->src?>">
						</a>				
					<?php endforeach; ?>

					<?php if( !empty( $flag ) ) : ?>						
						<a class="social_button column" href="<?=$flag->url?>" title="<?=$flag->title?>" target="_blank" lang="<?=$flag->locale?>" hreflang="<?=$flag->locale?>">
							<img src="<?=$flag->image?>" title="<?=$flag->title?>" alt="<?=$flag->title ?>">
						</a>	
					<?php endif;?>
					<a class="social_button column end"></a>
				</div>
				
				<?php /* vecchio bottone youtube
					<div class="g-ytsubscribe" data-channelid="UC-3RwdljLmN4L19ZCgGYVnA" data-layout="default" data-count="shown"></div>
					<script src="https://apis.google.com/js/platform.js"></script>	
				*/?>		
				
				<style>
					.desktop_header_buttons{float: right; margin-top:3px;}
					.social_button{ width:50px; height:50px; display:block;  }
					#btns_desktop .column { padding: 0  0.5rem }
				
				</style>
			<?php endif; ?>
			

			
	        <p class="slogan"><?php bloginfo( 'description' ); ?></p>
	        <p class="address">Vicolo d'Orfeo, 1 - 00193 Roma (RM) - a 200 metri da San Pietro - tel (+39) 06 6865148</p>
	    </div>
	    <div class="large-2 columns">
			<div class="banner">
				<a href="/come-sostenerci/otto-per-mille/" >
				<img src="<?php echo get_template_directory_uri(); ?>/images/banner.png" alt="banner otto per mille">
				</a>
			</div>
	    </div>
	  </div>
	</header>

	<div class="row fixed-bar">
    	<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium" style="display:none;">
      		<div class="bar">
        		<div class="row">
          			<div class="small-1 columns"><button class="menu-icon" type="button" data-toggle="main-menu"></button></div>
          			<div class="small-11 columns">
						<span class="small-lettering"><?php bloginfo( 'name' ); ?></span><br>
						<small class="small-claim"><?php bloginfo( 'description' ); ?></small>
					</div>
        		</div>
      		</div>
  		</div>

		<?php clean_custom_menu( 'primary', 'id="main-menu" class="menu vertical medium-horizontal expanded dropdown" data-responsive-menu="accordion medium-dropdown" role="menubar"' ); ?>
	</div>
	<?php if ( wp_is_mobile() ) : ?>

		<div class="row mobile_header_buttons">
			<div class="small-8 small-centered columns">
				<div class="row">
					<?php foreach( $social_buttons as $socbtn) : ?>		
						<a id="<?=$socbtn->id?>" class="small-3 columns" href="<?=$socbtn->link?>" target="_blank" title="<?=$socbtn->text?>">
							<img src="<?=$socbtn->src?>">
						</a>				
					<?php endforeach; ?>
					<?php if( !empty( $flag ) ) : ?>						
						<a class="small-3 columns" href="<?=$flag->url?>" title="<?=$flag->title?>" target="_blank" lang="<?=$flag->locale?>" hreflang="<?=$flag->locale?>">
							<img src="<?=$flag->image?>" title="<?=$flag->name?> (<?=$flag->locale?>)" alt="<?=$flag->title ?>">
						</a>	
					<?php endif;?>

				</div>			
			</div>
		</div>
		<style>
				.mobile_header_buttons{ margin-top:80px; }
				.carousel{ margin-top: 10px !important;}				
				
			
			</style>

	<?php endif; ?>
