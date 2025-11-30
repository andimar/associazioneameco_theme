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
  /*
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<div class="large-12 medium-12 small-12 columns breadcrumbs"><p><small>Sei in</small> ','</p></div>');
    }
    */
  ?>
  <?php
    $conduttore_slug = get_query_var('term');
    $conduttore_name = get_term_by('slug', $conduttore_slug, 'conduttori')->name;
?>
    <div class="large-12 medium-12 small-12 columns breadcrumbs">
      <p><small>Sei in</small>
      <span xmlns:v="http://rdf.data-vocabulary.org/#">
        <span typeof="v:Breadcrumb">
          <a href="/" rel="v:url" property="v:title">Home</a> »
          <span typeof="v:Breadcrumb">
            <a href="/risorse/cd" rel="v:url" property="v:title">CD</a> »
            <span class="breadcrumb_last"><?=$conduttore_name ?></span>
          </span>
        </span>
      </span>
      </p>
    </div>

  <?php
    $args = array ('post_type' => 'cd',
                   'posts_per_page' => -1,
                   'tax_query' => array(
                                      array(
                                         "taxonomy" => "conduttori",
                                         "field"    => "slug",
                                         "terms"    => $conduttore_slug,
                                         "operator" => "in",
                                         "include_children" => false
                                      )
                                  ),
                   'meta_key' => 'codice',
                   'orderby'  => 'meta_value_num',
                   'order'    => 'DESC'
                  );
    $cd_query = new WP_Query( $args ); ?>

    <div class="large-12 medium-12 small-12 columns cd-list">
      <?php if($cd_query->have_posts()) : ?>
        <h1 class="deco">Tutti i CD di <?=$conduttore_name ?></h1>
        <?php while ($cd_query->have_posts()) : $cd_query->the_post(); ?>
          <div class="cd-card">

            <div class="cd-card-header">
              <?php if(is_user_logged_in() && current_user_can('edit_post')): ?>
                  <span><a href="/wp-admin/post.php?post=<?= $post->ID?>&action=edit">[ modifica il CD ]</a></span>
              <?php endif; ?>
            </div>
            <h2 class="cd-card-title">
              <span class="cd-title"><?php the_title();?></span><br />
              <span class="cd-description"><?php echo get_post_meta($post->ID, 'descrizione',true) ?></span>
            </h2>


            <p class="cd-data"><?php echo get_post_meta($post->ID, 'periodo',true) ;?>
            <?php echo get_post_meta($post->ID, 'location',true) ;?>
             cod. <span class="code"><?php echo get_post_meta($post->ID, 'codice',true); ?></span>
              <span class="price">€ <?php echo str_replace(".",",",get_post_meta($post->ID, 'prezzo',true)); ?></span>
            </p>

            <div class="cd-content"><?php the_content(); ?></div>
            <?php //echo strip_tags(get_the_content()); ?>
          </div>
        <?php endwhile;?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <?php wp_reset_query(); ?>
    </div>

</div>




<?php get_footer(); ?>
