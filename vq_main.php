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



function result_finder() {

   finder_form();
   if(isset($_POST['post_results'])) {
     post_results();
   }
   if(isset($_POST['submit'])) {
      get_exam();
      get_studs();
   }
}


?>
