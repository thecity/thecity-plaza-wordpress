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
    /* Set up some default widget settings. */
		$defaults = array( 'subdomain_key' => '', 'plaza_display' => 'prayers', 'cache_duration' => '86400');
		$instance = wp_parse_args( (array) $instance, $defaults );    
    $title = strip_tags($instance['title']);
    $subdomain_key = strip_tags($instance['subdomain_key']);
    $plaza_display = strip_tags($instance['plaza_display']);
    $cache_duration = strip_tags($instance['cache_duration']);
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
     <label for="<?php echo $this->get_field_id('subdomain_key'); ?>">
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
      <?php 
        $topics_s = $events_s = $prayers_s = $needs_s = $album_s = '';
        switch($instance['plaza_display']) {
          case 'topics':
            $topics_s = 'selected="selected"'; 
            break;
          case 'events':
            $events_s = 'selected="selected"'; 
            break;
          case 'prayers':
            $prayers_s = 'selected="selected"';
            break;
          case 'needs':
            $needs_s = 'selected="selected"'; 
            break;
          case 'albums':
            $album_s = 'selected="selected"';
            break;
        }
      ?> 
    
      <label for="<?php echo $this->get_field_id('plaza_display'); ?>">
        Display:        			
        <select class="widefat" 
                id="<?php echo $this->get_field_id('plaza_display'); ?>" 
                name="<?php echo $this->get_field_name('plaza_display'); ?>">
        		<option value="topics" <?php echo $topics_s; ?> >Topics</option>
        		<option value="events" <?php echo $events_s; ?> >Events</option>
        		<option value="prayers" <?php echo $prayers_s; ?> >Prayers</option>
        		<option value="needs" <?php echo $needs_s; ?> >Needs</option>
        		<option value="albums" <?php echo $album_s; ?> >Albums</option>
        </select>
      </label>
    </p>
    
    
    <p>
      <?php 
        $one_hour = $one_day = $one_week = $one_month = '';
        switch($instance['cache_duration']) {
          case '3600': // One Hour
            $one_hour = 'selected="selected"'; 
            break;
          case '86400': // One Day
            $one_day = 'selected="selected"'; 
            break;
          case '604800': // One Week
            $one_week = 'selected="selected"';
            break;
          case '2592000': // One Month (30 days)
            $one_month = 'selected="selected"'; 
        }
      ?> 
    
      <label for="<?php echo $this->get_field_id('cache_duration'); ?>">
        Cache data for:        			
        <select class="widefat" 
                id="<?php echo $this->get_field_id('cache_duration'); ?>" 
                name="<?php echo $this->get_field_name('cache_duration'); ?>">
        		<option value="3600" <?php echo $one_hour; ?> >One Hour</option>
        		<option value="86400" <?php echo $one_day; ?> >One Day</option>
        		<option value="604800" <?php echo $one_week; ?> >One Week</option>
        		<option value="2592000" <?php echo $one_month; ?> >One Month (30 days)</option>
        </select>
      </label>
    </p>
    <?php
  }
  


  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subdomain_key'] = strip_tags($new_instance['subdomain_key']);
    $instance['plaza_display'] = strip_tags($new_instance['plaza_display']);
    $instance['cache_duration'] = strip_tags($new_instance['cache_duration']);
    return $instance;
  }
  


  function widget($args, $instance) {
    extract($args);

    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $subdomain_key = empty($instance['subdomain_key']) ? ' ' : $instance['subdomain_key'];
    $plaza_display = empty($instance['plaza_display']) ? ' ' : $instance['plaza_display'];
    $cache_duration = empty($instance['cache_duration']) ? ' ' : $instance['cache_duration'];


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