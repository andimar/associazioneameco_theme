<?php

class ActivityList
{

    // indicates the current date for all the lists;
    private $date;
    private $biographies;

    // method declaration
    public function __construct() {
        $this->date = date( 'Ymd');
        $this->biographies = new Biographies;
    }

    /**
     * returns the list of activities that have to be printed in home page
     */
    function getHomeInitiativeList($activity){

        $initiatives = [];
       
        $args = array (
            'post_type' => 'iniziativa',
            'posts_per_page' => '1',
            'tax_query' => array(
                'relation' => 'AND', 
                    array(
                        "taxonomy" => "posizioni",
                        "field"    => "slug",
                        "terms"    => "primo-piano-home",
                        "include_children" => false
                    ),
                    array(
                        "taxonomy" => "attivita",
                        "terms"    => $activity->term_id,
                    )
            ),
            'meta_query' => array(
                'relation' => 'OR',
                array( 'key' => 'data_fine',   'compare' => '>=', 'value' => $this->date ),
                array( 'key' => 'data_inizio', 'compare' => '>=', 'value' => $this->date ),
            ),
            'meta_key' => 'data_inizio',
            'orderby'  => 'meta_value',
            'meta_type' => 'DATETIME',
            'order'    => 'ASC'
        );
        $activity_query = new WP_Query( $args );

        // if not found featured initiatives
        if(!$activity_query->have_posts()){
            $args['tax_query'] = array(
                array(
                    "taxonomy" => "attivita",
                    "terms"    => $activity->term_id,
                    "include_children" => false
                ),
                array(
                    "taxonomy" => "posizioni",
                    "field"    => "slug",
                    "terms"    => "no-home-page",
                    "operator" => "NOT IN",
                    "include_children" => false
                )
            );
            $activity_query = new WP_Query( $args );
        }

        while($activity_query->have_posts()) { 
            
            $activity_query->the_post();
            
            $type = remove_lang_suffix($activity->slug);
           
            switch($type) {
                case "seminari": $all = pll_e('i seminari'); break;
                case "intensivi":  $all = pll_e('gli intensivi'); break;
                case "ritiri-residenziali": $all = pll_e('i ritiri'); break;
                default: $all = pll_e("i").' '.$activity->name;
            }

            $data_inizio = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_inizio',true)));
            $data_fine = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_fine',true)));
           
            if ($data_inizio == $data_fine) {
                $data_tag_testo = $data_inizio;
            } else {
                $data_tag_testo = get_post_meta($post->ID, 'ricorre',true).' '.pll__('dal').' '.$data_inizio;
                if($tipologia != "seminari") $data_tag_testo .= ' '.pll__('al').' '.$data_fine;
            }

            $location_choice  = get_post_meta($post->ID, 'location',true);
            $location = get_field_object('location')['choices'][$location_choice];

            $conductors = get_the_terms($post->ID, 'conduttori');
            $teachers = [];
            if(!empty($conductors)){
                foreach ($conductors as $conductor)
                    $teachers[] = (object) [
                        'name' => $conductor->name, 
                        'bio' => $this->biographies->getBioraphyByConductorId($conductor->term_id)
                    ];
            }

            $initiative = [
                'ID' => $post->ID,
                'title' => get_the_title(),
                'link' =>  get_the_permalink(),
                'timing' => $data_tag_testo, 
                'conductors' => $teachers,
                'location'  => $location,
                'type' => $type,
                'excerpt' => $excerpt,
            ];
            
            $initiatives[] = (object) $initiative;
        }

        wp_reset_query();
        wp_reset_postdata();
        return $initiatives;
    } 

    /**
     * takes all the initiatives of a given activity that are 
     * not yet finished or not started in the current date
     * 
     * @param activity {string} is the slug of the term of the taxonomy attivita
     */
    function getInitiatives($activity){
        $initiatives = [];

        $args = array(
            'post_type' => 'iniziativa',
            'posts_per_page' => -1,
            'tax_query' => array(array(
                    'taxonomy' => 'attivita', 'field' => 'slug',
                    'terms' => array($activity)
            )),
            'meta_query' => array(
                'relation' => 'OR',
                array( 'key' => 'data_fine',   'compare' => '>=', 'value' => $this->date ),
                array( 'key' => 'data_inizio', 'compare' => '>=', 'value' => $this->date ),
            ),
            'meta_key' => 'data_inizio',
            'orderby'  => 'meta_value',
            'meta_type' => 'DATETIME',
            'order'    => 'ASC'
        );
       
        
        $activity_query = new WP_Query( $args );
        $activity_posts = $activity_query->posts;

        foreach($activity_posts as $post){

            $type = remove_lang_suffix(get_the_terms($post->ID, 'attivita')[0]->slug);
            
            switch($type){
                case "seminari-di-dharma-e-meditazione-vipassana": $type = "seminari"; break;
                case "intensivi-di-dharma-e-meditazione-vipassana": $type = "intensivi"; break;
                case "ritiri-residenziali": 
                    if (!get_post_meta($post->ID, 'by_ameco',true))
                        $type = "ritiri-no-ameco";
                    break;
            }
            
            $data_inizio = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_inizio',true)));
            $data_fine = date("d-m-Y", strtotime(get_post_meta($post->ID, 'data_fine',true)));
            
            if ($data_inizio == $data_fine) {
                $data_tag_testo = $data_inizio;
            } else {
                $data_tag_testo = get_post_meta($post->ID, 'ricorre',true).' '.pll__('dal').' '.$data_inizio.' '.pll__('al').' '.$data_fine;
            }

            $location_choice  = get_post_meta($post->ID, 'location',true);
            $location = get_field_object('location',$post->ID)['choices'][$location_choice];
            
            
            $conductors = get_the_terms($post->ID, 'conduttori');
            $teachers = [];
            if(!empty($conductors)){
                foreach ($conductors as $conductor)
                    $teachers[] = (object) [
                        'name' => $conductor->name, 
                        'bio' => $this->biographies->getBioraphyByConductorId($conductor->term_id)
                    ];
            }

            $excerpt = ($post->post_excerpt)?$post->post_excerpt:wpse_stripcontent($post);


            $initiative = [
                'ID' => $post->ID,
                'title' => $post->post_title,
                'link' =>  get_permalink($post->ID),
                'timing' => $data_tag_testo, 
                'conductors' => $teachers,
                'location'  => $location,
                'type' => $type,
                'excerpt' => $excerpt,
            ];

           //echo '<pre>'.print_r($post).'</pre>';
           //echo '<pre>'.print_r($initiative).'</pre>';
            $initiatives[] = (object) $initiative;
        }

        wp_reset_query();
        wp_reset_postdata();

        return $initiatives;
    }
}

?>