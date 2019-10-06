<?php
/*
Plugin Name: Vocab Quizziz
Plugin URI: https://github.com/gskriotor/WP-Quiz-Admin-Plug
Description: Administrate practice quiz results. Output info and results for each student that took the quiz
Version: 0.0.19
Author Gus Spencer
Author URI: https://gusspencer.com
Text Domain: education
*/

if(!defined('ABSPATH')) {
   exit;
}

//require_once(plugin_dir_path(__FILE__) . '/incs/scripts/vq-funcs_head.php');
require_once(plugin_dir_path(__FILE__) . '/incs/scripts/vq-post_results.php');
require_once(plugin_dir_path(__FILE__) . '/incs/scripts/vq-show_results.php');
//require_once(plugin_dir_path(__FILE__) . '/incs/admin/vq-admin_index.php');
require_once(plugin_dir_path(__FILE__) . '/incs/views/vq-view_form.php');

function result_finder() {

   finder_form();
   if(isset($_POST['post_results'])) {
     post_results();
   }
   if(isset($_POST['submit'])) {
      vq_show_results();
   }
}

?>
