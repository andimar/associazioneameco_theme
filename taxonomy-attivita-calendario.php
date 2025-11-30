<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>

<?php
 $biographies = new Biographies();
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

      <?php /*
        $intensivi_giovedi = get_term_by('slug', 'intensivi-di-dharma-e-meditazione-vipassana-del-giovedi', 'attivita');
        $intensivi_giovedi_link = get_term_link($intensivi_giovedi->term_id, 'attivita');
        $description = substr($intensivi_giovedi->description, 0, strpos($intensivi_giovedi->description, "<!--more-->"));
      

      <a href="<?=$intensivi_giovedi_link ?>">
        <h4 class="intensivi">INTENSIVI DI DHARMA E MEDITAZIONE VIPASSANĀ DEL LUNEDÌ</h4>
      </a>
      <article class="event-card">
        
        <?= $description; ?>
       
      </article>
      */ ?>



      <?php
      $current_date = date('Ymd');

      $args = array(
        'post_type' => 'iniziativa',
        'posts_per_page' => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'attivita',
            'field' => 'slug',
            'terms' => array('ritiri-residenziali'),
            'operator' => 'NOT IN'
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
      $seminari_intensivi_query = new WP_Query( $args );
      if($seminari_intensivi_query->have_posts()) :
      ?>
        <?php while($seminari_intensivi_query->have_posts()) : $seminari_intensivi_query->the_post(); ?>
          <?php
           $tipologia = remove_lang_suffix(get_the_terms($post->ID, 'attivita')[0]->slug);

           //$tipologia_name = get_the_terms($post->ID, 'attivita')[0]->name;
           //if ($tipologia == "seminari-di-dharma-e-meditazione-vipassana") $tipologia = "seminari";
           //if ($tipologia == "intensivi-di-dharma-e-meditazione-vipassana") $tipologia = "intensivi";

           $data_inizio = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_inizio',true)));
           $data_fine = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_fine',true)));
           if ($data_inizio == $data_fine) {
             $data_tag_testo = $data_inizio;
           } else {
             $data_tag_testo = get_post_meta($post->ID, 'ricorre',true).' '.pll__('dal').' '.$data_inizio.' '.pll__('al').' '.$data_fine;             
           }
           /*
           $location_choice  = get_post_meta($post->ID, 'location',true);
           $location = get_field_object('location')['choices'][$location_choice];
           */

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
          <?php if(is_user_logged_in() && current_user_can('edit_post')) : ?>
            <div style="color:#555;font-size:12px; margin-left:30px">
              [data inizio: <?php echo $data_inizio; ?>]
              <a href="/wp-admin/post.php?post=<?php echo $post->ID; ?>&action=edit">
                [modifica l'iniziativa]
              </a>
            </div>
          <?php endif;?>
          <a href="<?php the_permalink(); ?>">
            <h4 class="<?php echo $tipologia; ?>">
              <?php the_title(); ?>
            </h4>
          </a>

          <span class="teacher-tag teacher-tag-<?php echo $tipologia; ?>">
            <small><?=pll_e('condotto da')?>:</small><br>
            <?php echo $teacher; ?>
          </span>
          <span class="date-tag-<?php echo $tipologia; ?>"><?php echo $data_tag_testo ?></span>
          <?php /*

            <span class="cat-tag-<?php echo $tipologia; ?>"><?php echo $tipologia_name; ?></span>
            <br />
            <span class="location-tag-<?php echo $tipologia; ?>"><?php echo $location; ?></span>
            <br /> */?>
          <article class="event-card">
            <?=wpse_stripcontent($post)?>

            <?php if(!empty($conductors)) : foreach ($conductors as $conductor) : ?>
              <?php
                $bio = $biographies->getBioraphyByConductorId($conductor->term_id);
                if ($bio != null) :?>
                  <div class="bio"><?php echo $bio->text ; ?></div>
              <?php endif; ?>
            <?php endforeach; endif; ?>


          </article>

        <?php endwhile;?>
      <?php endif; ?>
      <?php
        wp_reset_query();
        wp_reset_postdata();
      ?>

      <?php /* IL LOOP PER I RITIRI RESIDENZIALI */?>

                  <?php
                  $args ['tax_query']= array(
                    array(
                        'taxonomy' => 'attivita',
                        'field' => 'slug',
                        'terms' => array('ritiri-residenziali')
                    )
                  );

                  $ritiri_query = new WP_Query( $args );
                  if($ritiri_query->have_posts()) :
                  ?>
                    <?php while($ritiri_query->have_posts()) : $ritiri_query->the_post(); ?>
                      <?php
                       $tipologia = remove_lang_suffix(get_the_terms($post->ID, 'attivita')[0]->slug);
                       if ($tipologia == "ritiri-residenziali" && !get_post_meta($post->ID, 'by_ameco',true)) $tipologia = "ritiri-no-ameco";


                       $data_inizio = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_inizio',true)));
                       $data_fine = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_fine',true)));
                       if ($data_inizio == $data_fine) {
                         $data_tag_testo = $data_inizio;
                       } else {
                         $data_tag_testo = pll__('dal').' '.$data_inizio.' '.pll__('al').' '.$data_fine;
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
                      <?php if(is_user_logged_in() && current_user_can('edit_post')) : ?>
                        <div style="color:#555;font-size:12px; margin-left:30px">
                          [data inizio: <?php echo $data_inizio; ?>]
                          <a href="/wp-admin/post.php?post=<?php echo $post->ID; ?>&action=edit">
                            [modifica l'iniziativa]
                          </a>
                        </div>
                      <?php endif;?>
                      <a href="<?php the_permalink(); ?>">
                        <h4 class="<?php echo $tipologia; ?>">
                          <?php the_title(); ?>
                        </h4>
                      </a>
                      <span class="teacher-tag teacher-tag-<?php echo $tipologia; ?>">
                        <small><?=pll_e('condotto da')?>:</small><br>
                        <?php echo $teacher; ?>
                      </span>
                      <span class="location-tag-<?php echo $tipologia; ?>"><?php echo $location; ?></span>
                      <span class="date-tag-<?php echo $tipologia; ?>"><?php echo $data_tag_testo ?></span>
                      <article class="event-card">

                        <?=wpse_stripcontent($post)?>

                        
                        <?php if(!empty($conductors)) : foreach ($conductors as $conductor) : ?>
                          <?php
                            $bio = $biographies->getBioraphyByConductorId($conductor->term_id);
                            if ($bio != null) :?>
                              <div class="bio"><?php echo $bio->text ; ?></div>
                          <?php endif; ?>
                        <?php endforeach; endif; ?>
                      </article>

                      <br>
                    <?php endwhile;?>

                  <?php endif; ?>
                  <?php
                    wp_reset_query();
                    wp_reset_postdata();
                  ?>

    </div>


     <?php
        $args = array ('pagename' => 'informazioni-generali' );
        $info_query = new WP_Query( $args );
        if ( $info_query->have_posts() ) : $info_query->the_post(); ?>
        <div class="large-12 medium-12  small-12 columns">
          <?php if(is_user_logged_in() && current_user_can('edit_post')) : ?>
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
