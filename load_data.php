<?php

  require_once 'lib/plaza-php/lib/the_city.php';
  
  if( empty( $_GET['subdomain_key'] ) ) {
    echo 'Subdomain not set';
    
    
  } else {
    $the_city = new TheCity( $_GET['subdomain_key'] );  
    $subdomain_key = $_GET['subdomain_key'];
    $plaza_choice = $_GET['plaza_display'];    
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

    foreach($plaza_display->all_titles() as $indx => $title) {  
      $plaza_link = $plaza_link_base . $plaza_display->select($indx)->id();
      $html[] = "<div class='tc_wp_item'><a class='tc_wp_link' href='$plaza_link' target='_blank'>$title</a></div>";
    }
  
    echo implode($html, '');
  }

?>
