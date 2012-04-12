<?php

/*
Plugin Name: Startup Quotes
Plugin URI: http://wpkreatif.com/startup-quotes/
Description: Inspiring entrepreneur startup quotes from influential people in the industry.
Version: 1.0.0
Author: Salahuddin Hairai
Author URI: http://od3n.net/
License: GPLv2 or later
*/

/*  Copyright 2012  Salahuddin Hairai (email : mr.od3n@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
error_reporting(0);

class StartupQuotesWidget extends WP_Widget {
    /** constructor */
    function StartupQuotesWidget() {
        parent::WP_Widget(false, $name = 'Startup Quotes Widget');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ($title)
                        echo $before_title . $title . $after_title; ?>
<?php       
			$xml = simplexml_load_file("http://api.1001mutiarakata.com/startupquotes/");
			if($xml) :
                $author = !empty($xml->author) ? " - {$xml->author}" : '';
				echo "<em>{$xml->quote}{$author}</em>";
			else:
				echo "<em>Don’t worry about failure; you only have to be right once - Drew Houston</em>";
			endif;
?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php 
    }

} // class StartupQuoteWidget

add_action('widgets_init', create_function('', 'return register_widget("StartupQuotesWidget");'));
