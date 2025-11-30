<?php
/**
 * Adds News_Widget widget.
 */
class News_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'News_Widget', // Base ID
			esc_html__( 'Ultime News', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Elenco delle news più recenti', 'text_domain' ), ) // Args
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

		<div class="news widget">
			<h3><?php _e('Ultime News');?></h3>
			<div class="widget-content">
				<?php
				$args = array ('post_type' => 'post', 'posts_per_page' => $instance['news_to_show'], 'category_name' => 'news' );
				$activity_query = new WP_Query( $args );

				if ( $activity_query->have_posts() ) : ?>

				   <ul class="list">
				     <?php while ( $activity_query->have_posts() ) : $activity_query->the_post(); ?>
						 <?php
							 $title_color = get_post_meta(get_the_ID(), 'colore_titolo',true);
							 if(!empty( $title_color) && $title_color != '#ffffff') {
								 $title_color = 'style="color:'.$title_color.'"';
							 } else {
								 $title_color = '';
							 }
						 ?>
				     <li>
				       <h4>
				         <?php if ( has_post_thumbnail() ) { the_post_thumbnail('home_news_thumb'); }  ?>
				         <a href="<?php the_permalink(); ?>" <?php echo $title_color; ?>><?php the_title(); ?></a>
				        </h4>
				       <p><?php the_excerpt(); ?></p>
				       <div class="separator"></div>
				     </li>
				     <?php endwhile; ?>
				 </ul>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
				<?php wp_reset_query(); ?>

				<a class="button-sidebar" href="/archivio/news/">Vai all'archivio delle news</a>
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

		$news_to_show = ! empty( $instance['news_to_show'] ) ? $instance['news_to_show'] : esc_html__( '3', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'news_to_show' ) ); ?>"><?php esc_attr_e( 'News da visualizzare:', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'news_to_show' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'news_to_show' ) ); ?>" type="text" value="<?php echo esc_attr( $news_to_show ); ?>">
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
		$instance['news_to_show'] = ( ! empty( $new_instance['news_to_show'] ) ) ? strip_tags( $new_instance['news_to_show'] ) : '';

		return $instance;
	}

} // class News_Widget

// register News_Widget widget
function register_News_Widget() {
    register_widget( 'News_Widget' );
}
add_action( 'widgets_init', 'register_News_Widget' );

?>
