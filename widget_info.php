<ul class="tc_wp_content">
  <?php 
    $otc_params = array();
    $otc_params[] = "subdomain_key=$subdomain_key";
    $otc_params[] = "plaza_display=$plaza_display";
    $otc_params[] = "items_to_display=$items_to_display";
    $otc_params[] = "show_dates=$show_dates";
    
    $url = site_url() . '/wp-content/plugins/the-city-plaza/load_data.php?'.implode('&', $otc_params); 
    echo file_get_contents($url);
  ?>
</ul>