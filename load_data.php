<?php

  require_once 'lib/plaza-php/lib/the_city.php';
  
  if( empty( $_GET['subdomain_key'] ) ) {
    echo 'Subdomain not set';
    
    
  } else {

    $the_city = new TheCity( $_GET['subdomain_key'] );  
    $subdomain_key = $_GET['subdomain_key'];
    $plaza_choice = $_GET['plaza_display'];    
    $show_dates = $_GET['show_dates'];  
    $plaza_choice_key = '';
    $plaza_display = '';

    switch($_GET['plaza_display']) {
      case 'topics':
        $plaza_display = $the_city->topics(); 
        break;
      case 'events':
        $plaza_display = $the_city->events(); 
        break;
      case 'prayers':
        $plaza_display = $the_city->prayers(); 
        break;
      case 'needs':
        $plaza_display = $the_city->needs(); 
        break;
      case 'albums':
        $plaza_display = $the_city->albums(); 
        break;
      default:
        $plaza_choice = 'topics';
        $plaza_display = $the_city->topics(); 
    }
    
    $plaza_link_base = 'http://'.$_GET['subdomain_key'].'.onthecity.org/plaza/'.$plaza_choice.'/';
    $html = array();

    $plaza_titles = $plaza_display->all_titles();
    if( empty($plaza_titles) ) {
      $html[] = "No $plaza_choice found";      
    } else {
      foreach($plaza_titles as $indx => $title) {  
        $item = $plaza_display->select($indx);     
        $plaza_link = $plaza_link_base . $item->id();   
        $item_date = '';

        if(!empty($show_dates)) {
          $item_created_at = $item->created_at();
          if( !empty($item_created_at) ) {
            $item_created_at = date_parse($item_created_at);
            $item_date = implode( array($item_created_at['month'], $item_created_at['day'], $item_created_at['year']), '-');
          }
        }        

        $item_display_date = empty($item_date) ? '' : '<div class="tc_wp_date">' . $item_date . '</div>';
        $html[] = "<div class='tc_wp_item'><a class='tc_wp_link' href='$plaza_link' target='_blank'>$title</a>$item_display_date</div>";
      }
    }

    echo implode($html, '');
  }

?>
