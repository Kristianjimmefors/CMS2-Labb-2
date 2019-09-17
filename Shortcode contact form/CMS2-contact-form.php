<?php 
/*
Plugin Name: CMS 2 labb 2 contact form
Author: Kristian Jimmefors
Version: 1.0
Description: ett kontaktformulär
*/

class Labb2_contact_form{
    function __construct(){
        add_shortcode('contact', array($this, 'contact_form'));
    }

    public function contact_form($atts, $content = null){
        wp_enqueue_style('cusom-css', plugins_url('/css/custom-form-styling.css', __FILE__));
    $a = shortcode_atts(array(
            'reciver' => get_bloginfo('admin_email'),
            'placeholder' => 'Write text here',
            'success-text' => 'The form was sent!',
            'captcha-question' => '2+2',
            'captcha-answer' => '4'
        ), $atts);

        $captcha = '';
        $display_form = '
        <p class="form_description">%s</p>
        <form action="%s" id="contact_form" target="_top" method="post" encrypt="text/plain">
        <label for"subject">Ämne</label>
        <input id="subject" name="subject" type="text" placeholder="%s">
        <label for"message">Medelande</label>
        <textarea id="message" name="message" placeholder="%s"></textarea>
        <span>Vad är %s</span>
        <input class="captcha %s" name="captcha" type="text">
        <input id="submit" name="submit" type="submit" value="skicka">
        </form>
        ';
        if(isset($_POST['submit'])){
            if($_POST['captcha'] == $a['captcha-answer']){
                $mail = wp_mail($a['reciver'], $_POST['subject'], $_POST['message']);
                if($mail){
                    return '<p id="sucsess_message">Tack för ditt medelande!</p>';
                }else{
                    return '<p id="fail_message">Något gick fel! försök igen</p>' . $display_form;
                }
            }else{
                $captcha = 'captcha_failed';
                return sprintf($display_form,$content, get_permalink(),$a['placeholder'], $a['placeholder'],$a['captcha-question'],$captcha);
            }
        }else{
                return sprintf($display_form, $content, get_permalink(), $a['placeholder'], $a['placeholder'], $a['captcha-question'], $captcha);
        }
    }
}
new Labb2_contact_form();