<div id="onthecity-plaza-content">
  <?php 
    $otc_params = array();
    $otc_params[] = "subdomain_key=$subdomain_key";
    $otc_params[] = "plaza_display=$plaza_display";
    
    $url = site_url() . '/wp-content/plugins/onthecity-wordpress/load_data.php?'.implode('&', $otc_params); 
    echo file_get_contents($url);
  ?>
</div>