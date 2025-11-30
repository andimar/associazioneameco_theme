<?php
  $activity = get_query_var('attivita'); 
  /***
    * Instantiates a activityList object
    * that is the list of the conductors data
    */
  $activityList = new ActivityList();
  $initiatives = $activityList->getInitiatives($activity); 
?>

<div class="text-format">
  
  <div class="free-text"><?=category_description()?></div>

  <?php if(!empty($initiatives)) : ?>
    <?php foreach($initiatives as $initiative): ?>
     
      <?php if(is_user_logged_in() ) : ?>
        <div style="color:#555;font-size:12px; margin-left:30px">
          [data inizio: <?=isset($initiative->data_inizio) ? $initiative->data_inizio : 'N/A'?>]
          <a href="/wp-admin/post.php?post=<?=$initiative->ID?>&action=edit">[modifica l'iniziativa]</a>
        </div>
      <?php endif;?>

      <a href="<?=$initiative->link?>">
        <h4 class="<?=$initiative->type;?>"><?=$initiative->title;?></h4>
      </a>

      <span class="teacher-tag teacher-tag-<?=$initiative->type?>">
        <small><?=pll_e('condotto da')?>:</small><br>
        <?php foreach($initiative->conductors as $index => $conductor): ?>
          <span class="conductor <?=($index==0)?'':' comma';?>"><?=$conductor->name?></span>
        <?php endforeach;?>
      </span>

      <?php if($activity == 'ritiri-residenziali') : ?>
        <span class="location-tag-<?=$initiative->type?>"><?=$initiative->location?></span>
      <?php endif;?>

      <span class="date-tag-<?=$initiative->type?>"><?=$initiative->timing?></span>

      <article class="event-card">
       
        <?=$initiative->excerpt?>
        
        <?php foreach ($initiative->conductors as $conductor) : ?>
          <?php if ($conductor->bio != null) :?>
              <div class="bio"><?=$conductor->bio->text ?></div>
          <?php endif; ?>
        <?php endforeach;?>
      </article>

    <?php endforeach; ?>
  <?php endif;?> 
  
</div>

<?php
   $args = array ('pagename' => 'informazioni-generali');
   $info_query = new WP_Query($args);
?>
<?php if ($info_query->have_posts()) : $info_query->the_post(); ?>

   <div class="large-12 medium-12  small-12 columns">
     <?php if(is_user_logged_in() ) : ?>
       <div style="color:#555;font-size:12px;">
         <a href="/wp-admin/post.php?post=<?=$post->ID?>&action=edit">[modifica le informazioni generali]</a>
       </div>
     <?php endif;?>
     
     <h3 class="info-title"><?php the_title(); ?></h3>
     <?php the_content();?>
   </div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>
<?php wp_reset_query(); ?>
