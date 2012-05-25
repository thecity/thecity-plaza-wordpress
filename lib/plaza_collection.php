<?php


  /**
   * Set the default Time Zone if not already set for the user.
   * I don't think this will actually be used anywhere and is 
   * really only for PHP 5.3.
   */

  if (!ini_get('date.timezone')) {
    date_default_timezone_set('America/Los_Angeles');
  }


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
      while( ($topic = $topics->select($i)) != NULL ) { 
        $key = $this->_build_time_key( $topic->created_at() );
        $temp[$key] = $topic;
        $i++;
      } 

      $i = 0;
      while( ($event = $events->select($i)) != NULL ) { 
        $key = $this->_build_time_key( $event->starting_at() );
        $temp[$key] = $event;
        $i++;
      }      

      $i = 0;
      while( ($prayer = $prayers->select($i)) != NULL ) { 
        $key = $this->_build_time_key( $prayer->created_at() );
        $temp[$key] = $prayer;
        $i++;
      }    

      $i = 0;
      while( ($need = $needs->select($i)) != NULL ) { 
        $key = $this->_build_time_key( $need->created_at() );
        $temp[$key] = $need;
        $i++;
      }  

      $i = 0;
      while( ($album = $albums->select($i)) != NULL ) { 
        $key = $this->_build_time_key( $album->created_at() );
        $temp[$key] = $album;
        $i++;
      }

      krsort($temp); // Sort by keys from high to low

      $this->plaza_data = array_slice($temp, 0, $items_to_display);
    }
    


    /**
     *  All the Plaza item titles.
     *
     *  @return array of titles.
     */
    public function all_titles() {
      $items = array();
      foreach ($this->plaza_data as $item) { $items[] = $item->title(); }
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
      return strtotime( $created_at_str );
    }

  }
?>