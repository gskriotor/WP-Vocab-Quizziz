function q_adminTab() {
     add_menu_page(
      'Quiz Result Q',
      'Quiz Result Q',
      'edit_posts',
      'quiz_result',
      'result_finder',
      'dashicons-analytics'

     );
}
add_action('admin_menu', 'q_adminTab');
