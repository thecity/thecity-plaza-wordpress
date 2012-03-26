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

?>