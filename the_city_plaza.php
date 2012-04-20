<?php
/*
Plugin Name: The City Plaza Widget
Plugin URI: http://thecity.github.com
Description: This widget allows you to pull your OnTheCity.org plaza information into your WordPress website.
Author: Wes Hays
Version: 0.3
Author URI: http://www.OnTheCity.com
*/

include_once 'plaza_scripts.php';


class The_City_Plaza_Widget extends WP_Widget {
  
  function __construct() {
    $widget_ops = array('classname' => 'the_city_plaza_widget', 
                        'description' => 'Pulls information from your church\'s OnTheCity.org Plaza page.' );
    $this->WP_Widget('the-city-plaza-widget', 'The City Plaza', $widget_ops);
  }
  

  function form($instance) {
    /* Set up some default widget settings. */
		$defaults = array( 'subdomain_key' => '', 
                       'plaza_display' => 'prayers', 
                       'show_dates' => '0', 
                       'cache_duration' => '86400');

		$instance = wp_parse_args( (array) $instance, $defaults );    

    $title = strip_tags($instance['title']);
    $subdomain_key = strip_tags($instance['subdomain_key']);
    $plaza_display = strip_tags($instance['plaza_display']);
    $show_dates = strip_tags($instance['show_dates']);
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
      <i>Ex: https://[subdomain].OnTheCity.org</i>
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


      <?php
        $show_dates_checked = empty($show_dates) ? '' : 'checked="checked"';
      ?>
      <label for="<?php echo $this->get_field_id('show_dates'); ?>">
        <input type="checkbox" 
               id="<?php echo $this->get_field_id('show_dates'); ?>" 
               name="<?php echo $this->get_field_name('show_dates'); ?>"
               <?php echo $show_dates_checked ?> /> Show Dates        
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
    $instance['show_dates'] = strip_tags($new_instance['show_dates']);
    $instance['cache_duration'] = strip_tags($new_instance['cache_duration']);
    return $instance;
  }
  


  function widget($args, $instance) {
    extract($args);

    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $subdomain_key = empty($instance['subdomain_key']) ? ' ' : $instance['subdomain_key'];
    $plaza_display = empty($instance['plaza_display']) ? ' ' : $instance['plaza_display'];
    $show_dates = empty($instance['show_dates']) ? ' ' : $instance['show_dates'];
    $cache_duration = empty($instance['cache_duration']) ? ' ' : $instance['cache_duration'];

    echo $before_widget;
    if (!empty( $title )) {
        echo $before_title . $title . $after_title;
    };

    include dirname(__FILE__).'/widget_info.php';

    echo $after_widget;
  }
  
}

add_action('widgets_init', create_function('', 'return register_widget("The_City_Plaza_Widget");'));

?>