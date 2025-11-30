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

  <?php include('attivita-tabs-template.php'); ?>

  <div class="large-12 medium-12 small-12 columns tabs-ritiri-residenziali">
    <?php include('taxonomy-attivita-common.php'); ?>

  </div>
</div>


<?php get_footer(); ?>
