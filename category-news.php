<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-WordPress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>
<div class="main row">
  <div class="large-8 medium-8 small-12 columns content">

		<?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			<h1>Archivio delle <?php single_cat_title(); ?></h1>

			<?php post_navigation(); ?>

			<?php while (have_posts()) : the_post(); ?>

				<article <?php post_class() ?>>

						<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

						<?php posted_on(); ?>

						<div class="entry">
							<?php the_excerpt(); ?>
						</div>

				</article>

			<?php endwhile; ?>

			<?php post_navigation(); ?>

	<?php else : ?>

		<h2><?php _e('Nothing Found','html5reset'); ?></h2>

	<?php endif; ?>

  </div><?php /* end content */?>

  <div class="large-4 medium-4 small-12 columns sidebar">
    <?php get_sidebar(); ?>
  </div><?php /* end sidebar */?>
</div>

<?php get_footer(); ?>
