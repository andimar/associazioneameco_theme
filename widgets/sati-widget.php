<?php
/**
 * Adds SATI_Widget widget.
 */
class SATI_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'SATI_Widget', // Base ID
			esc_html__( 'Riviste SATI', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Link alle riviste SATI', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		/*echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo esc_html__( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];*/
    ?>

    <div class="sati widget">
      <h3>SATI</h3>
			<div class="widget-content">
	      <p class="claim">Rivista dell'associazione per la Meditazione di Consapevolezza (A.Me.Co.)</p>
	      <?php
	        $args = array ('post_type' => 'riviste', 'posts_per_page' => '1');
	        $last_sati_query = new WP_Query( $args );
	        if($last_sati_query->have_posts()): $last_sati_query->the_post(); ?>
	        <p class="anno"><?php echo get_the_terms( $post->ID, 'anno' )[0]->name; ?></p>
	        <div class="rivista">
	          <img src="<?php the_post_thumbnail_url('list'); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" />
	          <p><?php the_title(); ?></p>
	  			</div>
	      <?php endif; ?>
	      <?php wp_reset_postdata(); ?>
	      <?php wp_reset_query(); ?>

	      <a class="button-sidebar" href="/risorse/sati/">Vai all'archivio riviste</a></p>
			</div>
    </div>

    <?php

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class SATI_Widget

// register SATI_Widget widget
function register_SATI_Widget() {
    register_widget( 'SATI_Widget' );
}
add_action( 'widgets_init', 'register_SATI_Widget' );

?>
