<div id="onthecity-plaza-content">
  <?php 
    $url = site_url() . '/wp-content/plugins/onthecity-wordpress/load_data.php?subdomain_key='.$subdomain_key.'&display_rate='.$display_rate; 
    echo file_get_contents($url);
  ?>
</div>