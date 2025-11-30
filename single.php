<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>

<?php if(is_singular( 'iniziativa')) $biographies = new Biographies(); ?>

 <div class="main row">
   <?php
     if ( function_exists('yoast_breadcrumb') ) {
       yoast_breadcrumb('<div class="large-12 medium-12 small-12 columns breadcrumbs"><p><small>Sei in</small> ','</p></div>');
     }
   ?>

   <div class="large-8 medium-8 small-12 columns content">
     <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       <?php
         $title_color = get_post_meta($post->ID, 'colore_titolo',true);
         if(!empty( $title_color) && $title_color != '#ffffff')
           $title_color = 'style="color:'.$title_color.'"';
         else
           $title_color = '';
       ?>
       <article id="article">
         <h1 <?=$title_color;?>><?php the_title(); ?></h1>

         <?php /*if(has_post_thumbnail()): ?>
           <img src="<?php the_post_thumbnail_url( 'home_slider' );  ?>" alt="" class="article-thumbnail">
         <?php endif;*/ ?>

         <div class="entry-meta"><?php posted_on(); ?></div>
         <?php  /*
         <div id="featured-image"></div>
         <style>
           #featured-image {
               width:90%; height: 400px;
               background-image: url('<?php the_post_thumbnail_url( 'full' );  ?>');
               background-position: center;
               background-size: cover;
           }
         </style>
         */?>
         <?php the_content(); ?>
         <?php if(is_singular( 'iniziativa')) : ?>
           <?php
           $conductors = get_the_terms($post->ID, 'conduttori');
           if(!empty($conductors)) : foreach ($conductors as $conductor) : ?>
             <?php
               $bio = $biographies->getBioraphyByConductorId($conductor->term_id);
               if ($bio != null) :?>
               <div class="row bio">
                 <div class="large-3 medium-4 small-12 columns">
                    <div class="bio-img"
                         style="background-image:url('<?php echo $bio->photo_url; ?>')">
                    </div>

                 </div>
                 <div class="large-9 medium-8 small-12 columns bio-text"><?php echo $bio->text ; ?></div>
               </div>
             <?php endif; ?>
           <?php endforeach; endif; ?>
         <?php endif; ?>

         <div class="info-testo">
           <?php /* WTF ? */?>
           <?php wp_link_pages(array('before' => __('Pages: ','html5reset'), 'next_or_number' => 'number')); ?>
         </div>
       </article>

       <?php post_navigation(); ?>
     <?php endwhile; endif; ?>
   </div>

   <div class="large-4 medium-4 small-12 columns sidebar">
       <?php get_sidebar(); ?>
   </div>
</div>



<?php get_footer(); ?>
