<ul class="tc_wp_content">
  <?php 
    $show_dates = $show_dates == 'on' ? $show_dates : 0;
    $show_type = $show_type == 'on' ? $show_type : 0;

    $otc_params = array();
    $otc_params[] = "subdomain_key=$subdomain_key";
    if(!empty($group_nickname)) { $otc_params[] = "group_nickname=$group_nickname"; }
    $otc_params[] = "plaza_display=$plaza_display";
    $otc_params[] = "items_to_display=$items_to_display";  
    $otc_params[] = "show_dates=$show_dates";  
    $otc_params[] = "show_type=$show_type";

    $url = site_url() . '/wp-content/plugins/the-city-plaza/load_data.php?'.implode('&', $otc_params); 


    if( function_exists('curl_version') ) {
      echo file_get_plaza_contents_with_curl($url);
    } else if( ini_get('allow_url_fopen') == 1 ) { // On
      echo file_get_contents($url);      
    } else {
      echo 'Cannot pull data from plaza.  Either enable allow_url_fopen in the php.ini file, or install curl for php.';
    }
  ?>
</ul>