<?php 
/*
Plugin Name: CMS 2 labb 2 shortcode
Author: Kristian Jimmefors
Version: 1.0
Description: en shortcode för en knapp med länk eller inte
*/

class Labb2_Button{
    function __construct(){
        add_shortcode('button', array($this, 'shortcode_button'));
        
    }

    public function shortcode_button($atts){
        wp_enqueue_style('cusom-css', plugins_url('/css/custom-styling.css', __FILE__));
        $a = shortcode_atts( array(
            'text' => 'knapp',
            'background' => 'gray', 
            'url' => '',
            'width' => '',
            'style' => '',
        ), $atts);

        if( !$a['width'] == '' ){
            $width = 'width:' . $a['width'] .';';
        }
        if( !$a['style'] == ''){
            $style = $a['style'];
        }
        if( !$a['url'] == '' ){
            $display_button = '
            <a id="custom-a" href="' . $a['url'] . '">
            <button id="custom-button" 
            style="background-color: ' . $a['background'] . ';' . $width . $style .'">' . $a['text'] . '</button>
            </a>
            ';
            return $display_button;
        } else{
            $display_button = '
            <button id="custom-button" 
            style="background-color: ' . $a['background'] . ';' . $width . $style . '">' . $a['text'] . '</button>
            ';
            return $display_button;
        }
    }
}
new Labb2_Button();