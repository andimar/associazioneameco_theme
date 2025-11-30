<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>

 <div class="main row">
   <?php
     if ( function_exists('yoast_breadcrumb') ) {
       yoast_breadcrumb('<div class="large-12 medium-12 small-12 columns breadcrumbs"><p><small>Sei in</small> ','</p></div>');
     }
   ?>

   <div class="large-8 medium-8 small-12 columns content">
     <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

       <h1><?php the_title(); ?></h1>

       <?php if(has_post_thumbnail()): ?>
         <img src="<?php the_post_thumbnail_url( 'home_slider' );  ?>" alt="" class="article-thumbnail">
       <?php endif; ?>

       <?php the_content(); ?>

     <?php endwhile; endif; ?>







   <?php if(is_page("sati") || is_page("sati-2")): ?>
     <?php
      $anni_terms = get_terms( array(
           'taxonomy' => 'anno',
           'hide_empty' => true,
      ) );

      if (!empty($anni_terms)) :?>
      <div class="elements-list">
      <?php foreach ($anni_terms as $anno) : ?>
          <div class="anno-di-pubblicazione"><?=$anno->name ?></div>
          <ul>
            <?php
            $args = array ('post_type' => 'riviste',
                           'tax_query' => array(
                                              array(
                                                 "taxonomy" => "anno",
                                                 "field"    => "id",
                                                 "terms"    => $anno->term_id,
                                                 "operator" => "in",
                                                 "include_children" => false
                                              )
                                          )
                          );
            $sati_query = new WP_Query( $args );
            while($sati_query->have_posts()): $sati_query->the_post(); ?>

                <li><img src="<?php the_post_thumbnail_url('list'); ?>" title="<?php the_title(); ?>" /><p><?php the_title(); ?></p></li>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php wp_reset_query(); ?>
          </ul>
        <?php endforeach; ?>
        </div>
      <?php endif;?>
   <?php endif;?>


   <?php if(is_page('dispense')): ?>
     <div class="elements-list">
     <ul>
       <?php
       $args = array ('post_type' => 'dispense');
       $dispense_query = new WP_Query( $args );
       while($dispense_query->have_posts()): $dispense_query->the_post(); ?>
        <li><img src="<?php the_post_thumbnail_url('list'); ?>" title="<?php the_title(); ?>" /><p><?php the_title(); ?></p></li>
       <?php endwhile; ?>
       <?php wp_reset_postdata(); ?>
       <?php wp_reset_query(); ?>
     </ul>
   </div>
   <?php endif;?>

   <?php if(is_page('cd')): ?>
     <div class="cd-list row">
       <?php
       /*
       $conduttori_fissi = array(
         'corrado-pensa'     => array( name =>'Corrado Pensa', url =>'/conduttori/corrado-pensa/'),
         'corrado-neva'      => array( name =>'Corrado Pensa e Neva Papachristou', url =>'/conduttori/corrado-pensa/?e=neva-papachristou'),
         'neva-papachristou' => array( name =>'Neva Papachristou', url =>'/conduttori/neva-papachristou/'),

         )
       );*/

       $conduttori = get_terms( array(
         'taxonomy' => 'conduttori',
         'hide_empty' => true,
         'post_type' => 'cd',
         'orderby' => 'term_order'
       ) );
       foreach ($conduttori as $conduttore) : ?>
          <div class="large-6 medium-6 small-12 columns ">
            <a class="single-cd" href="<?php echo get_term_link($conduttore->term_id);?>">
              <?php echo $conduttore->name; ?>
            </a>
          </div>
       <?php endforeach; ?>

     </div>

<?php
     /*
     Elenco precedente
     ----------------

     Corrado Pensa
     Neva Papachristou
     Corrado Pensa e Neva Papachristou
     Neva Papachristou e Diego Caravano
     Neva Papachristou e Christina Feldman
     Neva Papachristou e Patricia Feldman Genoud
     Neva Papachristou e Franco Michelini Tocci
     Ajahn Amaro
     Ajahn Chandapalo
     Ajahn Khantiko
     Ajahn Ottama
     Ajahn Sucitto
     Ajahn Sumedho
     Ajahn Vimalo
     Andrea Anastasio
     Martine e Stephen Batchelor
     Pier Cesare Bori
     Diego Caravano
     Gerant Evans
     Christina Feldman
     Patrizia Feldman Genoud
     Giuliano Giustarini
     Jon Kabat Zinn
     Bruno Lo Turco
     Beatrice Loreti e Roberto Masiani
     Michele Mc Donald e Steven Smith
     Vito Mancuso
     Franco Michelini Tocci
     Flaminia Morandi
     Frank Ostaseski
     Padre Andrea Schnöller

     */?>
   <?php endif;?>

   </div><?php /* end content */?>

   <div class="large-4 medium-4 small-12 columns sidebar">
     <?php get_sidebar(); ?>
   </div><?php /* end sidebar */?>

 </div>



<?php get_footer(); ?>
