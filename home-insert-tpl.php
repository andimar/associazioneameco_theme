<?php $block = 0; ?>
<?php if (have_posts()) : while(have_posts()): the_post(); ?>

    <h2 class="home_title"><?php the_title(); ?></h2>

    <?php  if( strpos( $post->post_content, '<!--more-->' ) || has_excerpt() ) : ?>

        <span class="home_text"><?php the_excerpt(); ?></span>
        <a href="<?php the_permalink() ?>"><p style="text-align:right;"><?=pll__('Leggi tutto')?></p></a>

    <?php else: ?>
        <span class="home_text"><?php the_content(); ?></span>
    <?php endif; ?>

    <div class="separator"></div>

<?php endwhile; ?>
<?php endif; ?>
