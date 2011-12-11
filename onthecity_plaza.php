<?php
/*
Plugin Name: OnTheCity Plaza Widget
Plugin URI: https://github.com/weshays/onthecity-wordpress
Description: This widget allows you to pull your OnTheCity.org plaza information into your WordPress website.
Author: Wes Hays
Version: 0.1
Author URI: http://www.WesHays.com
*/


class OnTheCity_Plaza_Widget extends WP_Widget {
  
  function __construct() {
    $widget_ops = array('classname' => 'widget_onthecity_plaza', 
                        'description' => 'Pulls information from your church\'s OnTheCity.org Plaza page.' );
    $this->WP_Widget('onthecity-plaza-widget', 'OnTheCity Plaza', $widget_ops);
  }
  

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'subdomain_key' => '', 'display_rate' => '' ) );
    $title = strip_tags($instance['title']);
    $subdomain_key = strip_tags($instance['subdomain_key']);
    $display_rate = strip_tags($instance['display_rate']);
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">
        Widget Title: 
        <input class="widefat" 
               id="<?php echo $this->get_field_id('title'); ?>" 
               name="<?php echo $this->get_field_name('title'); ?>" 
               type="text" 
               value="<?php echo attribute_escape($title); ?>" />
       </label>
       <i>The title to display at the top of the widget</i>
     </p>

   <p>
     <label for="<?php echo $this->get_field_id('title'); ?>">
       Subdomain: 
       <input class="widefat" 
              id="<?php echo $this->get_field_id('subdomain_key'); ?>" 
              name="<?php echo $this->get_field_name('subdomain_key'); ?>" 
              type="text" 
              value="<?php echo attribute_escape($subdomain_key); ?>" />
      </label>
      <i>Ex: http://[subdomain].MyChurch.org</i>
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('width'); ?>">
        Display Rate (in seconds): 
        <input class="widefat" 
               id="<?php echo $this->get_field_id('display_rate'); ?>" 
               name="<?php echo $this->get_field_name('display_rate'); ?>" 
               type="text" 
               value="<?php echo attribute_escape($display_rate); ?>" />
      </label>
      <i>Number of seconds to show the next item</i>
    </p>
    <?php
  }
  


  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subdomain_key'] = strip_tags($new_instance['subdomain_key']);
    $instance['display_rate'] = strip_tags($new_instance['display_rate']);
    return $instance;
  }


  function widget($args, $instance) {
    extract($args);

    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $subdomain_key = empty($instance['subdomain_key']) ? ' ' : $instance['subdomain_key'];
    $display_rate = empty($instance['display_rate']) ? ' ' : $instance['display_rate'];


    echo $before_widget;
    if (!empty( $title )) {
        echo $before_title . $title . $after_title;
    };

    include dirname(__FILE__).'/widget_info.php';

    echo $after_widget;
  }
  
}

add_action('widgets_init', create_function('', 'return register_widget("OnTheCity_Plaza_Widget");'));



?>