<?php

  require_once 'lib/plaza-php/lib/the_city.php';
  
  if( empty( $_GET['subdomain_key'] ) ) {
    echo 'Subdomain not set';
    
    
  } else {
    $on_the_city = new TheCity( $_GET['subdomain_key'] );  
    
    $plaza_display = '';
    switch($_GET['plaza_display']) {
      case 'topics':
        $plaza_display = $on_the_city->topics(); 
        break;
      case 'events':
        $plaza_display = $on_the_city->events(); 
        break;
      case 'prayers':
        $plaza_display = $on_the_city->prayers(); 
        break;
      case 'needs':
        $plaza_display = $on_the_city->needs(); 
        break;
      case 'albums':
        $plaza_display = $on_the_city->albums(); 
        break;
      default:
        $plaza_display = $on_the_city->topics(); 
    }
  
    $html = array();
    foreach( $plaza_display->all_titles() as $title) {
      $html[] = "<div class='tc_wp_item'>$title</div>";
    }
  
    echo implode($html, '');
  }

?>
