<?php

class Initiatives
{
    public static function getInitiatives() : array
    {
        $initiatives = [];

        $current_date = date('Ymd');

        $args = [
          'post_type' => 'iniziativa',
          'posts_per_page' => -1,
        //   'tax_query' => [[
        //     'taxonomy' => 'attivita',
        //     'field' => 'slug',
        //     'terms' => $activities_to_exclude,
        //     'operator' => 'NOT IN'
        //   ]],
          'meta_query' => [
            'relation' => 'OR', 
            ['key' => 'data_fine',   'compare' => '>=', 'value' => $current_date],
            ['key' => 'data_inizio', 'compare' => '>=', 'value' => $current_date],
          ]          
        ];

        $initiatives = array_map(fn ($post) => new Initiative($post), get_posts($args));


        // Sort initiatives by data_inizio ascending
        usort($initiatives, function($a, $b) {
            $dateA = $a->starting_date_timestamp;
            $dateB = $b->starting_date_timestamp;
            if ($dateA == $dateB) return 0;
            return ($dateA < $dateB) ? -1 : 1;
        });

        return $initiatives;
    }
}

class Initiative {

    public int $ID;    
    public string $type;
    public string $data_inizio;
    public string $data_fine;    
    public string $timing;
    public string $location;
    public array $conductors;
    public string $excerpt;
    public string $title;
    public string $link;
    public string $content;
    public int $starting_date_timestamp;
    public int $ending_date_timestamp;

    private $post;
    

    public function __construct($post)
    {

        $this->post = $post;

        $this->ID = $post->ID;
        $this->type = $this->getType();
        $this->location = $this->getLocation();
        $this->conductors = $this->getConductors();
        $this->excerpt = $this->getExcerpt();
        $this->title = $this->getTitle();
        $this->link = $this->getLink();
        $this->content = $this->getContent();
        $this->starting_date_timestamp = $this->getStartingDateTimestamp();
        $this->ending_date_timestamp = $this->getEndingDateTimestamp();
        $this->data_inizio = date("d-m-Y", $this->starting_date_timestamp);
        $this->data_fine   = date("d-m-Y", $this->ending_date_timestamp);
        $this->timing = $this->getTiming();
        
    }


    
    protected function getTitle() : string {
        return $this->post->post_title;
    }


    protected function getLink() : string {
        return get_permalink($this->post->ID);
    }


    protected function getExcerpt() : string {
        return $this->post->post_excerpt;
    }


    protected function getConductors() : array {

        $conductors = get_the_terms($this->post->ID, 'conduttori');
        
        $biographies = new Biographies();

        return array_map(fn ($conductor) => [
            'name' => $conductor->name,
            'bio' => $biographies->getBioraphyByConductorId($conductor->term_id)
        ], $conductors);
    }

    
    protected function getLocation() : string {
        
        $location_choice  = get_post_meta($this->post->ID, 'location',true);

        if (empty($location_choice)) return '';
        
        $location = get_field_object('location', $this->post->ID);

        if (empty($location)) return '';
        
        return $location['choices'][$location_choice];
    }


    protected function getType() : string {
        return remove_lang_suffix(get_the_terms($this->post->ID, 'attivita')[0]->slug);
    }


    protected function setTimes() : string {

        if ($this->data_inizio == $this->data_fine) {
            return $this->data_inizio;
        } else {
            return get_post_meta($this->post->ID, 'ricorre',true).' '.pll__('dal').' '.$this->data_inizio.' '.pll__('al').' '.$this->data_fine;
        }
    }


    protected function getStartingDateTimestamp() : int {
        return strtotime(get_post_meta($this->post->ID, 'data_inizio',true));
    }


    protected function getEndingDateTimestamp() : int {
        return strtotime(get_post_meta($this->post->ID, 'data_fine',true));
    }


    protected function getTiming() : string {

        if ($this->data_inizio == $this->data_fine) {
            return $this->data_inizio;
        } else {
            return get_post_meta($this->post->ID, 'ricorre',true).' '.pll__('dal').' '.$this->data_inizio.' '.pll__('al').' '.$this->data_fine;
        }
    }


    protected function getContent() : string {
        return wpse_stripcontent($this->post);        
    }
}