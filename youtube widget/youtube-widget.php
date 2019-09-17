<?php 
/*
Plugin Name: CMS 2 labb 2 widget
Author: Kristian Jimmefors
Version: 1.0
Description: youtube widget
*/

 //widget to display the form
class CMS2_labb2 extends WP_Widget{
    public function __construct(){
        $widget_ops = array(
            'classname' => 'Youtube Widget',
            'description' => 'Widget to display a youtube video',
        );
        parent::__construct('CMS2_labb2', 'Youtube Widget', $widget_ops);
    }

    public function widget($args, $instance){
        echo $args['before_widget'];
        echo $this->displayVid($args, $instance);
        echo $args['after_widget'];
    }

    public function form($instance){
        if (empty($instance)) {
            $instance = array(
                'vidID' => '',
            );
        }
        if($instance['vidAutoplay'] == '1'){
            $autoplay_checked = 'checked=';
        }
        if($instance['vidControls'] == '1'){
            $control_checked = 'checked=';
        }
        extract($instance);
        ?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('vidID')); ?>"><?php esc_attr_e('youtube video id:', 'text_domain'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vidID')); ?>" name="<?php echo esc_attr($this->get_field_name('vidID')); ?>" type="text" value="<?php echo esc_attr($vidID); ?>">
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('vidAutoplay')); ?>"><?php esc_attr_e('Autoplay on video:', 'text_domain'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vidAutoplay')); ?>" name="<?php echo esc_attr($this->get_field_name('vidAutoplay')); ?>" type="checkbox" value="1" <?php echo $autoplay_checked ?>>
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('vidControls')); ?>"><?php esc_attr_e('Cotrols on video:', 'text_domain'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vidControls')); ?>" name="<?php echo esc_attr($this->get_field_name('vidControls')); ?>" type="checkbox" value="1" <?php echo $control_checked ?>>
		</p>
		<?php 
    }
    public function update($new_instance, $old_instance){
        $instance['vidID'] = (!empty($new_instance['vidID']) ? $new_instance['vidID'] : '');
        $instance['vidAutoplay'] = (!empty($new_instance['vidAutoplay']) ? $new_instance['vidAutoplay'] : '0');
        $instance['vidControls'] = (!empty($new_instance['vidControls']) ? $new_instance['vidControls'] : '0');
        $regx_match = preg_match("/(watch\?(.*&)?v=|v\/)([^\?&>]+)/", $instance['vidID'], $matches);
        if ($regx_match == 1) {
            $instance['vidID'] = $matches[3];
        }else{
        $new_instance['vidID'];
        }
        return $instance;
    }
    public function displayVid($args, $instance){
        echo '<iframe id="ytplayer" type="text/html" width="640" height="360"
        src="https://www.youtube.com/embed/' . $instance['vidID'] . '?controls=' . $instance['vidControls'] . '&autoplay=' . $instance['vidAutoplay'] . '" frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }


}
add_action('widgets_init', function () {
    register_widget('CMS2_labb2');
});