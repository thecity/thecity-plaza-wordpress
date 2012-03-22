<div class="tc_wp_content">
  <?php 
    $otc_params = array();
    $otc_params[] = "subdomain_key=$subdomain_key";
    $otc_params[] = "plaza_display=$plaza_display";
    
    $url = site_url() . '/wp-content/plugins/plaza-wordpress/load_data.php?'.implode('&', $otc_params); 
    echo file_get_contents($url);
  ?>
</div>