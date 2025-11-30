<?php
/**
 * Adds Dispense_Widget widget.
 */
class Dispense_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Dispense_Widget', // Base ID
			esc_html__( 'Dispense', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Link alle dispense', 'text_domain' ), ) // Args
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

    <div class="dispense widget">
      <h3>Dispense</h3>
			<div class="widget-content">
        <?php
	        $args = array ('post_type' => 'dispense', 'posts_per_page' => '2');
	        $dispense_query = new WP_Query( $args );
	        while($dispense_query->have_posts()): $dispense_query->the_post(); ?>

	        <div class="dispensa">
	          <img src="<?php the_post_thumbnail_url('list'); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" />
	          <p><?php the_title(); ?></p>
	  			</div>
	      <?php endwhile; ?>
	      <?php wp_reset_postdata(); ?>
	      <?php wp_reset_query(); ?>

	      <a class="button-sidebar" href="/risorse/dispense/">Vai all'archivio dispense</a></p>
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

} // class Dispense_Widget

// register Dispense_Widget widget
function register_Dispense_Widget() {
    register_widget( 'Dispense_Widget' );
}
add_action( 'widgets_init', 'register_Dispense_Widget' );

?>
