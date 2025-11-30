<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>

<!-- /// start content ///-->
<div id="content" class="wrap">
  <?php
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<div id="breadcrumbs"><p><small>Sei in</small> ','</p></div>');
    }
  ?>
  <!-- /// start main ///-->
  <div class="cleared">
     
      <div id="col-mono" class="insegnanti">
        <?php
        $args = array ('post_type' => 'insegnanti', 'post__in' => [152, 144], 'orderby' => 'ID','order' => 'DESC');
        $main_teachers_query = new WP_Query( $args );

        if($main_teachers_query->have_posts()) : ?>
  				<div>
            <h2><?=pll__('Insegnanti Guida')?></h2>

              <?php while ($main_teachers_query->have_posts()) : $main_teachers_query->the_post(); ?>
              <div class="cleared list-guida">
                <h4><?php the_title();?></h4>
  								<img src="<?php the_post_thumbnail_url('list')?>" alt="<?php the_title(); ?>" class="foto">
                  <?php the_content(); ?>
              </div>
              <?php endwhile;?>
          </div>
        <?php endif; ?>

        <?php
        $args = array ('post_type' => 'insegnanti', 'post__not_in' => [144, 152]);
        $main_teachers_query = new WP_Query( $args );

        if($main_teachers_query->have_posts()) : ?>
  		    <div class="ospiti">
            <h2><?=pll__('Insegnanti Ospiti')?></h2>

            <?php while ($main_teachers_query->have_posts()) : $main_teachers_query->the_post(); ?>
              <div class="cleared list-ospiti">
                <h4><?php the_title();?></h4>
                  <img src="<?php the_post_thumbnail_url('list')?>" alt="Corrado Pensa" class="foto">
                  <?php the_content(); ?>
              </div>
            <?php endwhile;?>

          </div>
        <?php endif; ?>
      </div>
  </div>

		<!-- /// end mono ///-->
	</div>



<?php get_footer(); ?>
