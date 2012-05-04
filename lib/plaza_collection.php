<?php

  /** 
   * This class is a wrapper for the topics page.
   *
   * @package TheCity
   */
  class PlazaCollection extends Plaza {

    // Holds the data.
    private $plaza_data = array();

    /**
     *  Constructor.
     *
     * @param TheCity $the_city An initialized TheCity object.
     */
    public function __construct($the_city, $items_to_display) {

      $topics = $the_city->topics($items_to_display); 
      $events = $the_city->events($items_to_display); 
      $prayers = $the_city->prayers($items_to_display); 
      $needs = $the_city->needs($items_to_display); 
      $albums = $the_city->albums($items_to_display);       

      $temp = array();

      $i = 0;
      $found = true;
      while( $found ) { 
        $topic = $topics->select($i);
         echo $topic->title;
        if($i<2 && $topic != NULL) {
          // $key = $this->_build_time_key( $topic->created_at() );
          // $temp[$key] = $topic;
          $i+=1;
          $temp[] = $topic;
        } else {
          $found = false;
        }
      }

      // $i = 0;
      // while( $event = $events->select($i) ) { 
      //   // $key = $this->_build_time_key( $event->starting_at() );
      //   // $temp[$key] = $event;
      //   // $i++;
      //   $temp[] = $event;
      // }      

      // $i = 0;
      // while( $prayer = $prayers->select($i) ) { 
      //   // $key = $this->_build_time_key( $prayer->created_at() );
      //   // $temp[$key] = $prayer;
      //   // $i++;
      //   $temp[] = $prayer;
      // }    

      // $i = 0;
      // while( $need = $needs->select($i) ) { 
      //   // $key = $this->_build_time_key( $need->created_at() );
      //   // $temp[$key] = $need;
      //   // $i++;
      //   $temp[] = $need;
      // }  

      // $i = 0;
      // while( $album = $albums->select($i) ) { 
      //   // $key = $this->_build_time_key( $album->created_at() );
      //   // $temp[$key] = $album;
      //   // $i++;
      //   $temp[] = $album;
      // }

      //ksort($temp); // Sort by keys from high to low
      //$temp = array_values($temp); // reindex starting at 0

      $this->plaza_data = $temp; //array_slice($temp, 0, $items_to_display);
    }
    


    /**
     *  All the Plaza item titles.
     *
     *  @return array of titles.
     */
    public function all_titles() {
      $items = array();
      foreach ($this->plaza_data as $item) { $items[] = $item['title']; }
      return $items;
    }
    
    
    /**
     * Get the specified Plaza item.
     *
     * @param index The index of the item to get all the information for.
     *
     * @return Mixed It could be a Topic, Event, Prayer, Need or Album.
     */
    public function select($index) {
      if( !isset($this->plaza_data[$index]) ) { return null; }
      return $this->plaza_data[$index];
    }
    
    

    private function _build_time_key($created_at_str) {
      $c = date_parse( $created_at_str );
      $c['year'].$c['month'].$c['day'].$c['hour'].$c['minute'].$c['second'];
    }

  }
?>