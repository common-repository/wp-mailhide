<?php
/*
Plugin Name: WP-Mailhide
Plugin URI: http://www.jorgepena/wp-mailhide/
Description: Mailhide reCAPTCHA filter for WordPress.
Version: 0.3
Author: Blaenk Denum
Author URI: http://www.jorgepena.be/
*/

// Uncomment ONLY if you don't have the reCAPTCHA plug-in installed
require_once(dirname(__FILE__) . '/recaptchalib.php');

function mh_insert_email($content = '') {
   // match email
   $content = preg_replace_callback( "/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i", "mh_replace", $content);
   return $content;
}

function mh_replace($matches) {
   $html = recaptcha_mailhide_html('public key', 'private key', $matches[0]);
   // Comment if you don't want it styled
   $html = '<span class="emailrecaptcha">' . $html . "</span>";
   return $html;
}

add_filter('the_content', 'mh_insert_email'); // For posts/pages
add_filter('get_comment_text', 'mh_insert_email'); // For comments
add_filter('the_content_rss', 'mh_insert_email'); // For RSS
add_filter('comment_text_rss', 'mh_insert_email'); // For RSS Comments
?>