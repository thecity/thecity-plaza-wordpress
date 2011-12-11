<?php

  require_once 'lib/lib/on_the_city.php';
  
  if( empty( $_GET['subdomain_key'] ) ) {
    echo 'Subdomain not set';
    
    
  } else {
    $on_the_city = new OnTheCity( $_GET['subdomain_key'] );  
    $topics = $on_the_city->topics(); 
  
    $html = array();
    foreach( $topics->all_titles() as $title) {
      $html[] = "<div>$title</div>";
    }
  
    echo implode($html, '');
  }

?>