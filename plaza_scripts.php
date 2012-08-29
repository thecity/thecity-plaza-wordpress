<?php

function plaza_wordpress_scripts() {  
  wp_register_script('plaza_wordpress_js', plugins_url( '/the-city-plaza/scripts/plaza_wordpress.js'));   
  wp_enqueue_script('plaza_wordpress_js');  
}

add_action('wp_enqueue_scripts', 'plaza_wordpress_scripts');  



function plaza_wordpress_styles() {  
  wp_register_style('plaza_wordpress_style', plugins_url( '/the-city-plaza/scripts/plaza_wordpress.css'));   
  wp_enqueue_style('plaza_wordpress_style');  
}

add_action('wp_enqueue_scripts', 'plaza_wordpress_styles');  



function file_get_plaza_contents_with_curl($url) {
  $ch = curl_init();
   
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
  curl_setopt($ch, CURLOPT_URL, $url);
   
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}


function delete_plaza_cache_directory($dir) {
  // Assume cache has already been cleared.
  if(!file_exists($dir)) { return true; }

  if ($handle = opendir($dir)) {
    $array = array();

    while (false !== ($file = readdir($handle))) {
      if ($file != "." && $file != "..") {

        if(is_dir($dir.$file)) {
          if(!@rmdir($dir.$file)) { // Empty directory? Remove it
            delete_plaza_cache_directory($dir.$file.'/'); // Not empty? Delete the files inside it
          }
        } else {
          @unlink($dir.$file);
        }
      }
    }
    closedir($handle);
    @rmdir($dir);
  }
}

?>