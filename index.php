<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>

 <?php
 $args = array ('post_type' => 'page', 'pagename' => 'home-gallery', );
 $gallery_query = new WP_Query( $args );

 if ( $gallery_query->have_posts() ) : ?>
   <?php
     $gallery_query->the_post();
     $gallery = get_post_gallery( get_the_ID(), false );
   ?>
   <?php wp_reset_postdata(); ?>
   <?php wp_reset_query(); ?>

  <div class="row carousel">
    <?php /*
    UTILIZZARE SWIPER
    <div class="large-12 medium-12 columns">
      <div class="home-gallery">
        <?php foreach($gallery['src'] as $img_src) :?>
          <div><img src="<?=$img_src?>" /></div>
        <?php endforeach;?>
      </div>
    </div>
      */ ?>
     <div class="large-12 medium-12 columns">
       <div class="orbit" role="region" aria-label="Favorite Pictures" data-orbit>
         <ul class="orbit-container" >
           <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Precedente</span>&#9664;</button>
           <button class="orbit-next" aria-label="next"><span class="show-for-sr">Successiva</span>&#9654;</button>

           <?php foreach($gallery['src'] as $img_src) :?>
             <li class="orbit-slide"><div><img src="<?=$img_src?>" /></div></li>
           <?php endforeach;?>
         </ul>
       </div>
     </div>

   </div>

 <?php endif; ?>


 <div class="row">

   <?php /* ------ COLONNA 1 -------- */?>
   <div class="large-4 medium-4 small-12 columns" id="col1">
     <?php
       $args = array ('post_type' => 'page', 'pagename' => 'home', );
       $home_query = new WP_Query( $args );
       if ( $home_query->have_posts() ) {
         $home_query->the_post(); the_content();
       }
       // CAMBIARE ASSOLUTAMENTE CON IL MENU

       ?>
       <?php wp_reset_postdata(); ?>
       <?php wp_reset_query(); ?>


   </div>



   <?php /*



   -------- COLONNA 2 --------



   */?>

   <div class="large-4 medium-4 small-12 columns" id="col2">

     <?php
       $args = array ('post_type' => 'page', 'pagename' => 'perche-meditare', 'posts_per_page' => '1', );
       $home_query = new WP_Query( $args );
       if ( $home_query->have_posts() ) : $home_query->the_post(); ?>

         <h2 class="home_title"><?php the_title(); ?></h2>

         <span class="home_text"><?php echo apply_filters( 'the_content', get_the_content('<br /><p style="text-align:right;">'.pll__('Leggi tutto').'</p>')); ?></span>
         <div class="separator"></div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <?php wp_reset_query(); ?>


     <?php
     $activity_terms = get_terms( array(
       'taxonomy' => 'attivita',
       'hide_empty' => false,
     ) );

     if (!empty($activity_terms)) :?>
     <div id="iniziative">
       <h2><?php pll_e('Iniziative');?></h2>
       <ul class="list">
       <?php foreach ($activity_terms as $activity) : ?>
          
          <?php $activity_slug = remove_lang_suffix($activity->slug); ?>
          
          <li>
            <script>console.log('activity slug <?=$activity_slug?>')</script>
            <?php if($activity_slug == "calendario") : ?>            
              <h4><a class="button-category" href="<?=get_term_link($activity->term_id)?>"><?=pll_e('Calendario completo')?></a></h4>
            <?php else: ?>
              
              <?php

              $current_date = date( 'Ymd');
              $args = array ('post_type' => 'iniziativa',
                             'posts_per_page' => '1',
                             'tax_query' => array(
                                                'relation' => 'AND',
                                                array(
                                                   "taxonomy" => "posizioni",
                                                   "field"    => "slug",
                                                   "terms"    => "primo-piano-home",
                                                   "include_children" => false
                                                ),
                                                array(
                            			                 "taxonomy" => "attivita",
                                                   "terms"    => $activity->term_id,
                                                )
                                            ),
                             'meta_query' => array(
                               'relation' => 'OR',
                                array(
                                    'key'        => 'data_fine',
                                    'compare'    => '>=',
                                    'value'      => $current_date
                                ),
                                array(
                                    'key' => 'data_inizio',
                                    'compare'    => '>=',
                                    'value'      => $current_date
                                ),
                             ),
                             'meta_key' => 'data_inizio',
                             'orderby'  => 'meta_value',
                             'meta_type' => 'DATETIME',
                             'order'    => 'ASC'
                            );
              $activity_query = new WP_Query( $args );

              if(!$activity_query->have_posts()){

                $args['tax_query'] = array(

                  array(
                    "taxonomy" => "attivita",
                    "terms"    => $activity->term_id,
                    "include_children" => false
                  ),
                  array(
                     "taxonomy" => "posizioni",
                     "field"    => "slug",
                     "terms"    => "no-home-page",
                     "operator" => "NOT IN",
                     "include_children" => false
                  )
                );
                $activity_query = new WP_Query( $args );
              }

              while($activity_query->have_posts()): $activity_query->the_post(); ?>


                  <?php

                    $tipologia = remove_lang_suffix($activity->slug);

                    $tutti = "i ".$activity->name;
                    if ($tipologia == "seminari") {
                      $tipologia = "seminari";
                      $tutti = pll__('i seminari');
                    }
                    if ($tipologia == "intensivi") {
                      $tipologia = "intensivi";
                      $tutti = pll__('gli intensivi');
                    }
                    if ($tipologia == "ritiri-residenziali") {
                      $tutti = pll__('i ritiri');
                    }

                    $data_inizio = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_inizio',true)));
                    $data_fine = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_fine',true)));
                    if ($data_inizio == $data_fine) {
                      $data_tag_testo = $data_inizio;
                    } else {
                      $data_tag_testo = get_post_meta($post->ID, 'ricorre',true).' '.pll__('dal').' '.$data_inizio;
                      if($tipologia != "seminari") $data_tag_testo .= ' '.pll__('al').' '.$data_fine;
                    }
                    $location_choice  = get_post_meta($post->ID, 'location',true);
                    $location = get_field_object('location')['choices'][$location_choice];

                    $conductors = get_the_terms($post->ID, 'conduttori');
                    $teacher = "";
                    if(!empty($conductors)){
                      $is_first = true;
                      foreach ($conductors as $conductor) {
                        $teacher .= '<span class="conductor'.($is_first?'':' comma').'">'.$conductor->name.'</span>' ;
                        if($is_first) { $is_first = false; }
                      }
                    }
                  ?>

                  <a class="activity-card" href="<?php the_permalink(); ?>">
                   <h5 class="activity-title <?php echo $tipologia; ?>"><?php the_title(); ?></h5>

                   <div class="teacher-tag teacher-<?php echo $tipologia; ?>"> <small><?=pll_e('condotto da')?>:</small> <?php echo $teacher; ?></div>
                   <div class="date-tag date-<?php echo $tipologia; ?>"><?php echo $data_tag_testo; ?></div>
                   <?php if ($tipologia == "ritiri-residenziali") : ?>

                     <div class="location-tag location-<?php echo $tipologia; ?>"><?php echo $location; ?></div>
                   <?php endif; ?>
                  </a>
                  <a class="button-category btn-<?php echo $tipologia; ?>" href="<?php echo get_term_link($activity->term_id); ?>">
                    <?=pll__('Tutti').' '.$tutti; ?>
                  </a>


              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
              <?php wp_reset_query(); ?>

            <?php endif; ?>


          </li>
       <?php endforeach; ?>
       </ul>
     <?php endif; ?>
     <div class="separator"></div>
     </div>

      <?php dynamic_sidebar('sidebar-home'); ?>
   </div>



   <?php /*



    ------ COLONNA 3 --------



   */  ?>

   <div class="large-4 medium-4 small-12 columns" id="col3">



     <!-- ultimo approfondimento -->
     <!-- loop news -->
     <?php
     $args = array ('post_type' => 'post', 'posts_per_page' => '5', 'category_name' => 'news' );
     $activity_query = new WP_Query( $args );

     if ( $activity_query->have_posts() ) : ?>
        <div id="news">
        <h2><?php pll_e('Ultime News');?></h2>
        <ul class="list news">
          <?php while ( $activity_query->have_posts() ) : $activity_query->the_post(); ?>
          <?php
            $title_color = get_post_meta($post->ID, 'colore_titolo',true);
            if(!empty( $title_color) && $title_color != '#ffffff')
              $title_color = 'style="color:'.$title_color.'"';
            else
              $title_color = '';
          ?>
          <li>
            <h4>
              <?php if ( has_post_thumbnail() ) { the_post_thumbnail('home_news_thumb'); }  ?>
              <a href="<?php the_permalink(); ?>" <?=$title_color; ?>>
                <?php the_title(); ?>
              </a>
             </h4>
            <p><?php the_excerpt(); ?></p>
            <div class="separator"></div>
          </li>
          <?php endwhile; ?>
        </ul>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <?php wp_reset_query(); ?>
   </div>
</div>






<?php get_footer(); ?>
