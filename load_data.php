<?php

  require_once 'lib/plaza-php/lib/the_city.php';
  require_once 'lib/plaza_collection.php';
  
  if( empty( $_GET['subdomain_key'] ) ) {
    echo 'Subdomain not set';
    
    
  } else {
    $the_city = new TheCity( $_GET['subdomain_key'] );  
    $subdomain_key = $_GET['subdomain_key'];
    $plaza_choice = $_GET['plaza_display'];    
    $items_to_display = $_GET['items_to_display'];    
    $show_dates = $_GET['show_dates'];  
    $show_type = $_GET['show_type'];  
    $plaza_choice_key = '';
    $plaza_display = '';

    switch($_GET['plaza_display']) {
      case 'all':
        $plaza_display = new PlazaCollection($the_city, $items_to_display);
        break;
      case 'topics':
        $plaza_display = $the_city->topics($items_to_display); 
        break;
      case 'events':
        $plaza_display = $the_city->events($items_to_display); 
        break;
      case 'prayers':
        $plaza_display = $the_city->prayers($items_to_display); 
        break;
      case 'needs':
        $plaza_display = $the_city->needs($items_to_display); 
        break;
      case 'albums':
        $plaza_display = $the_city->albums($items_to_display); 
        break;
      default:
        $plaza_choice = 'topics';
        $plaza_display = $the_city->topics($items_to_display); 
    }
    
    $html = array();


    $plaza_titles = $plaza_display->titles();
    if( empty($plaza_titles) ) {
      $html[] = "No $plaza_choice found";      
    } else {
      foreach($plaza_titles as $indx => $title) {  
        $item = $plaza_display->select($indx);  

        if($plaza_choice == 'all') {
          $str = get_class($item);
          $item_type_path  = strtolower($str) . 's';
        } else {
          $item_type_path = $plaza_choice;
        }

        $plaza_link_base = 'http://'.$_GET['subdomain_key'].'.onthecity.org/plaza/'.$item_type_path.'/'; 
        $plaza_link = $plaza_link_base . $item->id();   
        $item_date = '';

        if(!empty($show_dates)) {
          $item_created_at = get_class($item) == 'Event' ? $item->starting_at() : $item->created_at();
          if( !empty($item_created_at) ) {
            $item_created_at = date_parse($item_created_at);
            $item_date = implode( array($item_created_at['month'], $item_created_at['day'], $item_created_at['year']), '-');
          }
        }       

        if(!empty($show_type)) {
          $item_type = get_class($item);
          if(empty($item_date)) {
            $item_date = $item_type;
          } else {
            $item_date .= ' :: ' . $item_type;
          }
        }  

        $item_display_date = empty($item_date) ? '' : '<div class="tc_wp_date">' . $item_date . '</div>';
        $html[] = "<li class='tc_wp_item'>$item_display_date<a class='tc_wp_link' href='$plaza_link' target='_blank'>$title</a></li>";
      }
    }

    echo implode($html, '');
  }

?>
