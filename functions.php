<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */

	// Options Framework (https://github.com/devinsays/options-framework-plugin)
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/_/inc/' );
		require_once dirname( __FILE__ ) . '/_/inc/options-framework.php';
	}

	// AGGIUNGE LE CUSTOMIZZAZIONI DEL TEMA
	require_once dirname( __FILE__ ) . '/customization.php';


	// Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function andimar_setup() {
		load_theme_textdomain( 'ameco_responsive', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status' ) );
		register_nav_menu( 'primary', __( 'Navigation Menu', 'ameco_responsive' ) );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'list', 150, 180, true );
		add_image_size( 'home_slider', 930, 280, true );
		add_image_size( 'home_news_thumb', 70, 70, true );
	}
	add_action( 'after_setup_theme', 'andimar_setup' );

	function my_custom_sizes( $sizes ) {
	    return array_merge( $sizes, array(
	        'home_slider' => __( 'Slider Home Page' ),
	    ) );
	}
	add_filter( 'image_size_names_choose', 'my_custom_sizes' );

	function my_add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}

	add_action( 'init', 'my_add_excerpts_to_pages' );








	// Scripts & Styles (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function html5reset_scripts_styles() {
		global $wp_styles;

		// Load Comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		// Load Stylesheets
//		wp_enqueue_style( 'html5reset-reset', get_template_directory_uri() . '/reset.css' );
//		wp_enqueue_style( 'html5reset-style', get_stylesheet_uri() );

		// Load IE Stylesheet.
//		wp_enqueue_style( 'html5reset-ie', get_template_directory_uri() . '/css/ie.css', array( 'html5reset-style' ), '20130213' );
//		$wp_styles->add_data( 'html5reset-ie', 'conditional', 'lt IE 9' );

		// Modernizr
		// This is an un-minified, complete version of Modernizr. Before you move to production, you should generate a custom build that only has the detects you need.
		// wp_enqueue_script( 'html5reset-modernizr', get_template_directory_uri() . '/_/js/modernizr-2.6.2.dev.js' );

	}
	add_action( 'wp_enqueue_scripts', 'html5reset_scripts_styles' );

	// WP Title (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function html5reset_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

//		 Add the site name.
		$title .= get_bloginfo( 'name' );

//		 Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

//		 Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'html5reset' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'html5reset_wp_title', 10, 2 );

  // fondamentale rimuovere le emoji, in futuro sarà possibile farlo con una
	// direttiva DEFINE direttamente nel file di configurazione
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');


	/**
	 *  Funzione che permette l'eliminazione automatica degli utenti
	 */
	function auto_delete_users() {
		global $wpdb;
		$userlevel = 0; // 0 = subscriber
		$deleteafter = 0; // delete User after X days
		$query = $wpdb->prepare("SELECT $wpdb->users.ID FROM $wpdb->users LEFT JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE $wpdb->usermeta.meta_key = %s AND $wpdb->usermeta.meta_value = %d AND DATEDIFF(CURDATE(), $wpdb->users.user_registered) > %d", $wpdb->prefix.'user_level',$userlevel,$deleteafter);

		if($oldUsers = $wpdb->get_results($query, ARRAY_N)){
			foreach ($oldUsers as $user_id) {
				wp_delete_user($user_id[0]);
			}
		}
	}
	add_action('daily_clean_database', 'auto_delete_users');
	wp_schedule_event(time(), 'hourly', 'daily_clean_database');



	/*
	 * Aggiunge le colonne nella lista dei CD
	 */
	 function add_acf_cd_columns ( $columns ) {
	   return array_merge ( $columns, array (
	     'descrizione' => __ ( 'Descrizione' ),
	     'codice'   => __ ( 'Codice' ),
			 'prezzo'   => __ ( 'Prezzo' )
	   ) );
	 }
	 add_filter ( 'manage_cd_posts_columns', 'add_acf_cd_columns' );

	 	function cd_custom_column ( $column, $post_id ) {
	    switch ( $column ) {
	      case 'descrizione':
	        echo get_post_meta ( $post_id, 'descrizione', true );
	        break;
	      case 'codice':
	        echo get_post_meta ( $post_id, 'codice', true );
	        break;
				case 'prezzo':
		      echo get_post_meta ( $post_id, 'prezzo', true );
		      break;
	    }
	  }
	  add_action ( 'manage_cd_posts_custom_column', 'cd_custom_column', 10, 2 );

		add_filter( 'manage_edit-cd_sortable_columns', 'my_sortable_cd_column' );
		function my_sortable_cd_column( $columns ) {
			$custom = array(
				'codice' =>'codice',
				'taxonomy-conduttori' => 'taxonomy-conduttori'
			);
			return wp_parse_args($custom, $columns);
		}

		add_action( 'pre_get_posts', 'my_cd_orderby' );
		function my_cd_orderby( $query ) {
	    if( ! is_admin() )
	        return;

	    $orderby = $query->get( 'orderby');

	    if( 'codice' == $orderby ) {
	        $query->set('meta_key','codice');
	        $query->set('orderby','meta_value_num');
	    }
			if( 'taxonomy-conduttori' == $orderby ) {
	        //$query->set('meta_key','taxonomy-conduttori');
	        //$query->set('orderby','conduttori');
	    }
		}
/*
		add_filter("manage_edit-cd_sortable_columns", 'cd_sort_by_author');
		function cd_sort_by_author($columns) {
		   $custom = array(

		   );
		   return wp_parse_args($custom, $columns);
		}*/



		/*
		 * Aggiunge le colonne nella lista delle iniziative
		 */
		 function add_acf_iniziativa_columns ( $columns ) {
		   return array_merge ( $columns, array (
		     'data_inizio' => __ ( 'Data inizio' ),
		     'data_fine'   => __ ( 'Data fine' ),
		   ) );
		 }
		 add_filter ( 'manage_iniziativa_posts_columns', 'add_acf_iniziativa_columns' );

		 	function iniziativa_custom_column ( $column, $post_id ) {
		    switch ( $column ) {
		      case 'data_inizio':
		        $data_inizio = get_post_meta ( $post_id, 'data_inizio', true );
						echo  date( _x( 'd/m/Y', 'Event date format', 'textdomain' ), strtotime( $data_inizio ) );
		        break;
		      case 'data_fine':
						$data_fine = get_post_meta ( $post_id, 'data_fine', true );
				    echo  date( _x( 'd/m/Y', 'Event date format', 'textdomain' ), strtotime( $data_fine ) );

		        break;

		    }
		  }
		  add_action ( 'manage_iniziativa_posts_custom_column', 'iniziativa_custom_column', 10, 2 );

			add_filter( 'manage_edit-iniziativa_sortable_columns', 'my_sortable_iniziativa_column' );
			function my_sortable_iniziativa_column( $columns ) {
		    $columns['data_inizio'] = 'data_inizio';
				$columns['data_fine'] = 'data_fine';
		    return $columns;
			}

			add_action( 'pre_get_posts', 'my_iniziativa_orderby' );
			function my_iniziativa_orderby( $query ) {
		    if( ! is_admin() )
		        return;

		    $orderby = $query->get( 'orderby');

		    if( 'data_inizio' == $orderby ) {
		        $query->set('meta_key','data_inizio');
						//$query->set('meta_type','DATE');
		        $query->set('orderby','meta_value');
		    }
				if( 'data_fine' == $orderby ) {
					 $query->set('meta_key','data_fine');
					 //$query->set('meta_type','DATE');
					 $query->set('orderby','meta_value');
			 }
			}





  /***
	WIDGETS
	*/
  require_once dirname( __FILE__ ) . '/widgets/sati-widget.php';
	require_once dirname( __FILE__ ) . '/widgets/dispense-widget.php';
	require_once dirname( __FILE__ ) . '/widgets/biblioteca-widget.php';
	require_once dirname( __FILE__ ) . '/widgets/cd-widget.php';
	require_once dirname( __FILE__ ) . '/widgets/news-widget.php';




	/**
	 * Extend get terms with post type parameter.
	 *
	 * @global $wpdb
	 * @param string $clauses
	 * @param string $taxonomy
	 * @param array $args
	 * @return string
	 */
	function df_terms_clauses( $clauses, $taxonomy, $args ) {
		if ( isset( $args['post_type'] ) && ! empty( $args['post_type'] ) && $args['fields'] !== 'count' ) {
			global $wpdb;

			$post_types = array();

			if ( is_array( $args['post_type'] ) ) {
				foreach ( $args['post_type'] as $cpt ) {
					$post_types[] = "'" . $cpt . "'";
				}
			} else {
				$post_types[] = "'" . $args['post_type'] . "'";
			}

			if ( ! empty( $post_types ) ) {
				$clauses['fields'] = 'DISTINCT ' . str_replace( 'tt.*', 'tt.term_taxonomy_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields'] ) . ', COUNT(p.post_type) AS count';
				$clauses['join'] .= ' LEFT JOIN ' . $wpdb->term_relationships . ' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN ' . $wpdb->posts . ' AS p ON p.ID = r.object_id';
				$clauses['where'] .= ' AND (p.post_type IN (' . implode( ',', $post_types ) . ') OR p.post_type IS NULL)';
				$clauses['orderby'] = 'GROUP BY t.term_id ' . $clauses['orderby'];
			}
		}
		return $clauses;
	}

	add_filter( 'terms_clauses', 'df_terms_clauses', 10, 3 );

/**
 * Serve a reperire l'elenco delle biografie associate a ciascun conduttore
 */
	 require_once dirname( __FILE__ ) . '/classes/Biographies.php';
	 require_once dirname( __FILE__ ) . '/classes/ActivityList.php';
/**
 * Serve a selezionare quali custom post types devono essere sincronizzati
 * in pratica deve escludere il campo "ricorre" nelle Iniziative
 */
add_filter( 'pll_copy_post_metas', 'copy_post_metas' );
 
function copy_post_metas( $metas ) {
    return array_diff( $metas, ['ricorre']);
}










	//OLD STUFF BELOW


	// Load jQuery
	// non dovrebbe servire
	/*
	if ( !function_exists( 'core_mods' ) ) {
		function core_mods() {
			if ( !is_admin() ) {
				wp_deregister_script( 'jquery' );
				wp_register_script( 'jquery', ( "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ), false);
				wp_enqueue_script( 'jquery' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'core_mods' );
	}
	*/

	// Clean up the <head>, if you so desire.
	//	function removeHeadLinks() {
	//    	remove_action('wp_head', 'rsd_link');
	//    	remove_action('wp_head', 'wlwmanifest_link');
	//    }
	//    add_action('init', 'removeHeadLinks');

	// Custom Menu
	register_nav_menu( 'primary', __( 'Navigation Menu', 'html5reset' ) );
	register_nav_menu( 'secondary', __( 'Activity Tab Menu', 'html5reset' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'html5reset' ) );


	// Widgets
	if ( function_exists('register_sidebar' )) {
		function html5reset_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'Sidebar Widgets', 'html5reset' ),
				'id'            => 'sidebar-primary',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			register_sidebar( array(
				'id'            => 'sidebar-home',
				'name'          => __( 'Home Widgets', 'html5reset' ),
				'description'   => __( 'Spazio in home page', 'html5reset'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );


		}
		add_action( 'widgets_init', 'html5reset_widgets_init' );


	}

	// Navigation - update coming from twentythirteen
	function post_navigation() {
		echo '<div class="navigation">';
		echo '	<div class="next-posts">'.get_next_posts_link('&laquo; Older Entries').'</div>';
		echo '	<div class="prev-posts">'.get_previous_posts_link('Newer Entries &raquo;').'</div>';
		echo '</div>';
	}

	// Posted On
	function posted_on() {
		/*
		printf( __( '<span class="sep">Pubblicato il </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> by <span class="byline author vcard">%5$s</span>', '' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_author() )
		);*/

		printf( __( '<span class="sep">Pubblicato il </span> <time class="entry-date" datetime="%1$s" pubdate>%2$s</time>', '' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}

	function cleanString($string){
		$string = str_replace("è", "e", $string);
		$string = str_replace("à", "a", $string);
		$string = str_replace("à", "o", $string);
		$string = str_replace("ì", "i", $string);
		$string = str_replace("ù", "u", $string);
		$string = str_replace(" ", "-", $string);
		return $string;
	}

	function clean_custom_menu( $theme_location, $args ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        //$menu_list  = '<nav>' ."\n";
        $menu_list = '<ul '.$args.'>' ."\n";

        $count = 0;
        $submenu = false;

        foreach( $menu_items as $menu_item ) {

            $link = $menu_item->url;
            $title = $menu_item->title;

            if ( !$menu_item->menu_item_parent ) {
                $parent_id = $menu_item->ID;

                $menu_list .= '<li>' ."\n";
                $menu_list .= '<a href="'.$link.'">'.$title.'</a>' ."\n";
            }

            if ( $parent_id == $menu_item->menu_item_parent ) {

                if ( !$submenu ) {
                    $submenu = true;
                    $menu_list .= '<ul>' ."\n";
                }

                $menu_list .= '<li>' ."\n";
                $menu_list .= '<a href="'.$link.'">'.$title.'</a>' ."\n";
                $menu_list .= '</li>' ."\n";



                if ( isset( $menu_items[ $count + 1 ] ) && $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
                    $menu_list .= '</ul>' ."\n";
                    $submenu = false;
                }

            }

            if ( isset( $menu_items[ $count + 1 ] ) && $menu_items[ $count + 1 ]->menu_item_parent != $parent_id ) {
                $menu_list .= '</li>' ."\n";
                $submenu = false;
            }

            $count++;
        }

        $menu_list .= '</ul>' ."\n";
        //$menu_list .= '</nav>' ."\n";

    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    echo $menu_list;
}

function wpse_stripcontent($post) {
	
	$wpse_excerpt = $post->post_content;
	$wpse_excerpt = strip_shortcodes( $wpse_excerpt );
	$wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
	$wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
	$wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

	//Set the excerpt word count and only break after sentence is complete.
	$excerpt_word_count = 75;
	$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
	$tokens = array();
	$excerptOutput = '';
	$count = 0;

	// Divide the string into tokens; HTML tags, or words, followed by any whitespace
	preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

	foreach ($tokens[0] as $token) {

			if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) {
			// Limit reached, continue until , ; ? . or ! occur at the end
					$excerptOutput .= trim($token);
					break;
			}

			// Add words to complete sentence
			$count++;

			// Append what's left of the token
			$excerptOutput .= $token;
	}

	$wpse_excerpt = trim(force_balance_tags($excerptOutput));

	return $wpse_excerpt;
}


function wpse_allowedtags() {
    // Add custom tags to this string
	return '<strong><b><script>,<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>';
}

//removes lang suffixes
function remove_lang_suffix($string){
	$lang_suffixes = ['-it','-en'];
	return str_replace($lang_suffixes, '', $string);
}


if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) :

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {

			$raw_excerpt = $wpse_excerpt;
			if ( '' == $wpse_excerpt ) return wpse_stripcontent($post);
			
			return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif;



/*PROVIAMO A TOGLIERE JQMIGRATE
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );
*/



?>
