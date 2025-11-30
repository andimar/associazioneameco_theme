<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); 
 require_once 'classes/Initiatives.php';
 $initiatives = Initiatives::getInitiatives();
?>


<!-- /// start content ///-->
<div class="main row">
  <?php
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb('<div class="large-12 medium-12 small-12 columns breadcrumbs"><p><small>Sei in</small> ','</p></div>');
    }
  ?>

  <?php include('attivita-tabs-template.php'); ?>

  <div class="large-12 medium-12 small-12 columns tabs-calendario-completo">

    <div class="text-format">

      <?php foreach ($initiatives as $initiative) : ?>        
          <?php if(is_user_logged_in() ) : ?>
            <div style="color:#555;font-size:12px; margin-left:30px">
              [data inizio: <?php echo $initiative->data_inizio; ?>]
              <a href="/wp-admin/post.php?post=<?=$initiative->ID; ?>&action=edit">[modifica l'iniziativa]</a>
            </div>
          <?php endif;?>

          <a href="<?=$initiative->link?>">
            <h4 class="<?=$initiative->type?>"><?=$initiative->title?></h4>
          </a>

          <span class="teacher-tag teacher-tag-<?=$initiative->type?>">
            <small><?=pll_e('condotto da')?>:</small><br>
            <?php foreach($initiative->conductors as $index => $conductor): ?>
              <span class="conductor <?=($index==0)?'':' comma';?>">
                <?=$conductor['name']?></span>
            <?php endforeach;?><br
            <span class="date-tag-<?=$initiative->type?>"><?=$initiative->timing?></span>
          </span>
          
          <article class="event-card">
            <?=$initiative->content?>

            <?php foreach ($initiative->conductors as $conductor) : ?>
              <?php if ($conductor['bio'] != null) :?>
                <div class="bio"><?=$conductor['bio']->text?></div>
              <?php endif; ?>
            <?php endforeach; ?>
          </article>
          <br>
      <?php endforeach; ?>
    </div>
  </div>
      <?php
        $args = array ('pagename' => 'informazioni-generali' );
        $info_query = new WP_Query( $args ); 
      ?>
      <?php if ( $info_query->have_posts() ) : $info_query->the_post(); ?>
        <div class="large-12 medium-12  small-12 columns">
          <?php if(is_user_logged_in() ) : ?>
            <div style="color:#555;font-size:12px; margin-left:30px">
              <a href="/wp-admin/post.php?post=<?php echo $post->ID; ?>&action=edit">
                [modifica le informazioni generali]
              </a>
            </div>
          <?php endif;?>
          <h3 class="info-title"><?php the_title(); ?></h3>
          <?php the_content();?>
        </div>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <?php wp_reset_query(); ?>
    </div>
</div>


<?php get_footer(); ?>
