<?php
class Biography
{
    // property declaration
    public $conductor_id = 0;
    public $name ='';
    public $text ='';
    public $photo_url = '';

    // method declaration
     public function __construct($conductor_id = 0, $name = '', $text='', $photo_url='') {
        $this->conductor_id = $conductor_id;
        $this->name = $name;
        $this->text = $text;
        $this->photo_url = $photo_url;
    }
}

class Biographies
{
    private $biographies = array();

    public function __construct() {
    	$args = array( 'post_type' => 'insegnanti', 'posts_per_page' => '-1'  );
    	$insegnanti_query = new WP_Query( $args );
     	while($insegnanti_query->have_posts()) {
    			$insegnanti_query->the_post();

    			$conduttori = get_the_terms($post->ID, 'conduttori');
                
                
    			foreach ((array) $conduttori as $conduttore) {
    				$this->biographies[] = new Biography($conduttore->term_id,
                                                 get_the_title(),
                                                 get_the_content(),
                                                 get_the_post_thumbnail_url($post->ID, 'list'));
    			}
    	}
    	wp_reset_query();
    	wp_reset_postdata();
    }

    public function getBioraphyByConductorId($conductor_id) {
        foreach ($this->biographies as $bio) {
          if($bio->conductor_id == $conductor_id) return $bio;
        }
        return null;
    }
}


?>
