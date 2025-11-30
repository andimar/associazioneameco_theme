<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>

<!-- /// start content ///-->
<div class="main row">
  <?php
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<div class="large-12 medium-12 small-12 columns breadcrumbs"><p><small>Sei in</small> ','</p></div>');
    }
  ?>

  <div class="large-12 medium-12 small-12 columns insegnanti">
    <?php
    $args = array ('post_type' => 'insegnanti', 'post__in' => [152, 144], 'orderby' => 'ID','order' => 'DESC');
    $main_teachers_query = new WP_Query( $args );

    if($main_teachers_query->have_posts()) : ?>
      <div class="row">
        <div class="large-12 medium-12 small-12 columns ">
        <h2><?=pll__('Insegnanti Guida')?></h2>
        </div>

        <?php while ($main_teachers_query->have_posts()) : $main_teachers_query->the_post(); ?>
        <div class="large-12 medium-12 small-12 columns">
          <h4><?php the_title();?></h4>
        </div>

        <div class="large-3 medium-12 small-12 columns ">
          <img src="<?php the_post_thumbnail_url('list')?>" alt="<?php the_title(); ?>" class="foto">
        </div>

        <div class="large-9 medium-12 small-12 columns ">
            <?php the_content(); ?>

            <?php if(is_user_logged_in() && current_user_can('edit_post')) : ?>
              <div style="color:#555;font-size:12px;">
                <a href="/wp-admin/post.php?post=<?php echo $post->ID; ?>&action=edit">[modifica insegnante]</a>
              </div>
            <?php endif;?>
        </div>
        <?php endwhile;?>
      </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <?php wp_reset_query(); ?>

    <?php
    $args = array ('post_type' => 'insegnanti', 'posts_per_page' => -1,
                   'post__not_in' => [144, 152],
                   'meta_key' => 'cognome',
                   'orderby'  => 'meta_value',
                   'order'    => 'ASC');
    $main_teachers_query = new WP_Query( $args );

    if($main_teachers_query->have_posts()) : ?>
    <div class="row">

        <div class="large-12 medium-12 small-12 columns ospiti">
        <h2><?=pll__('Insegnanti Ospiti')?></h2>
        </div>
        <?php while ($main_teachers_query->have_posts()) : $main_teachers_query->the_post(); ?>
        <div class="large-12 medium-12 small-12 columns ">
          <h4><?php the_title();?></h4>
        </div>

        <div class="large-3 medium-12 small-12 columns ">
          <img src="<?php the_post_thumbnail_url('list')?>" alt="<?php the_title(); ?>" class="foto">
        </div>

        <div class="large-9 medium-12 small-12 columns ">
            <?php the_content(); ?>

            <?php if(is_user_logged_in() && current_user_can('edit_post')) : ?>
              <div style="color:#555;font-size:12px;">
                <a href="/wp-admin/post.php?post=<?php echo $post->ID; ?>&action=edit">[modifica insegnante]</a>
              </div>
            <?php endif;?>
        </div>

        <?php endwhile;?>

      </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <?php wp_reset_query(); ?>
  </div>

</div>
  <!-- /// start main ///-->
  <div class="cleared">
      <div id="col-mono" class="insegnanti">

      </div>
  </div>

		<!-- /// end mono ///-->
	</div>



<?php get_footer(); ?>
