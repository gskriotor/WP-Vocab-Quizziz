<?php
function finder_form() {

    global $wpdb;
    $school_select = $wpdb->get_results( "SELECT DISTINCT meta_key, meta_value FROM {$wpdb->prefix}usermeta", ARRAY_A);
    $exam_select = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_master", ARRAY_A);

    echo '
      <form class="fStyle" action="'.$_SERVER['REQUEST_URI'].'" method="POST">
      <div class="fField">
         <label>School Selector</label><br>
         <select class="fSelect" name="school">';

            foreach($school_select as $school_selects) {

               if($school_selects['meta_key'] == 'select_school') {
                  echo '<option class="fOption" value="'.$school_selects['meta_value'].'">'.$school_selects['meta_value'].'</option><br>';
               }

            }

    echo '</select>
      </div>
      <div class="fField">
         <label>Exam Selector</label><br>
         <select class="fSelect" name="exam">';

            foreach($exam_select as $exam_selects) {
               echo '<option class="fOption" value="'.$exam_selects['name'].'">'.$exam_selects['name'].'</option><br>';
            }

    echo '</select>
      </div>
      <button class="fButton" type="submit" name="submit">view 
         results
      </button>
      <button class="fButton" type="submit" name="post_results">
         post results
      </button>
      </form>
    ';
}
