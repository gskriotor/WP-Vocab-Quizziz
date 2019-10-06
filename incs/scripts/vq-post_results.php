//funcion for posting quiz results

function post_results() {

$pName = $_POST['exam'];

   global $wpdb;

   $exam_sel = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}watupro_master WHERE name = '$pName'", ARRAY_A);

   $x_id = (int)$exam_sel[0]['ID'];

   $results = $wpdb->get_results( "SELECT date FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);
   $topScore = $wpdb->get_results( "SELECT MAX(points) FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);
   $lowScore = $wpdb->get_results( "SELECT MIN(points) FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);
   $minScore = $wpdb->get_results( "SELECT MIN(points) FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);
   $maxScore = $wpdb->get_results( "SELECT MAX(max_points) FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);
   $quest = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_question WHERE exam_id = $x_id", ARRAY_A);
   $sanswc = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id AND is_correct = 1", ARRAY_A);
   $sanswt = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id", ARRAY_A);
   $answ = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_answer", ARRAY_A);

   $examTakes = $wpdb->get_results( "SELECT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);


//Top 10 students sql query
   $topStudents = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id ORDER BY percent_points DESC LIMIT 10", ARRAY_A);
   $allStudents = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id ORDER BY percent_points DESC", ARRAY_A);


   $maxPoints = $maxScore[0]['MAX(max_points)'];

   $highScorePerc = ($topScore[0]['MAX(points)'] * 100) / $maxPoints;

   $highScorePercCl = number_format($highScorePerc, 2);

   $lowScorePerc = ($lowScore[0]['MIN(points)'] * 100) / $maxPoints;

   $lowScorePercCl = number_format($lowScorePerc, 2);
//echo 'ready to print';

//none of these commented out worked
//$res_p = do_shortcode('[printfriendly]');
//$res_p = apply_filters( 'the_content',' [printfriendly] ');
//$res_p = '<button class="wp-block-button__link"><a href="https://www.printfriendly.com/p/g/N8EMJH">Print / PDF</a></button>';
$res_p = '[printfriendly]';

$result_content1 = '<center><h1><strong>'.$pName.'</strong></h1></center><br>
'.$res_p.'
<table class="TFtable">
<tr>
<td><strong>Exam Date:</strong> '.$results[0]['date'].'</td>
<td><strong>Highest Score:</strong> '.$topScore[0]['MAX(points)'].' -
'. $highScorePercCl.'%</td>

<td><strong>Lowest Score:</strong> '.$minScore[0]['MIN(points)'].' - '
.$lowScorePercCl.'%</td>';

$answCountt = count($sanswt);
$answCountc = count($sanswc);
$result_content2 = '<td><strong>Total Possible:</strong> '.$maxPoints.'</td>';
//echo 'correct: '.$answCountc.'<br>';

$classAver = ($answCountc * 100) /$answCountt;
$classAverCl = number_format($classAver, 2);

$result_content2 .= '<td><strong>Class Average:</strong> '.$classAverCl.'</td>';

$totalTakes = count($examTakes);
$result_content2 .= '<td><strong>Total Submissions:</strong> '.$totalTakes.'</td>
      </tr>
</table><br>

<h3>Top Students</h3>
<table class="TFtable">';
foreach($topStudents as $studs) {
  $studID = $studs['user_id'];
  $studentInfo = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users WHERE ID = $studID", ARRAY_A);
  $studMetaFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'first_name'", ARRAY_A);
  $studMetaLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'last_name'", ARRAY_A);
  $topStudScore = $wpdb->get_results( "SELECT percent_correct FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = $studID", ARRAY_A);
  $result_content2 .= '
     <div>

    <tr>
  <td><strong>Student Name:</strong> '.$studMetaFn[0]['meta_value'].
  $studMetaLn[0]['meta_value'].'</td>
  <td><strong>Correct:</strong> '.$topStudScore[0]['percent_correct'].'%</td>

<td><strong>Login Name:</strong> '.$studentInfo[0]['user_login'].'</td>
  </tr>

</div>';
 }
$result_content2 .= '</table>
</div>
<div>
<br><center><h2>QUESTIONS</h2></center>';
foreach($quest as $quests) {

  $q_id = (int)$quests['ID'];
  //This collects the total number of student answers given per a question
  $answ_perQuest = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE question_id = $q_id", ARRAY_A);

  //This collects the total number of correct student answers given per a question
  $corrAnsw_perQuest = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE question_id = $q_id AND is_correct = 1", ARRAY_A);
  $totalCorrAnsw_perQuest = count($corrAnsw_perQuest);
  $totalAnsw_perQuest = count($answ_perQuest);
$result_content2 .= '<div>';

  $percentCorrPerQ = ($totalCorrAnsw_perQuest * 100) / $totalAnsw_perQuest;
  $percentWroPerQ = 100 - $percentCorrPerQ;

  $percWroPerQcl = number_format($percentWroPerQ, 2);
  $percCorrPerQcl = number_format($percentCorrPerQ, 2);

//echo '<div style="float: left; padding: 4px;">';

  $result_content2 .= '<br><strong><h4>QUESTION: '.$quests['sort_order'].'</h4></strong>
  <table class="TFtable">
  <tr>
  <td><h4>'.$quests['question'].'</h4></td>
  <td><h5><strong>Correct:</strong> '.$percCorrPerQcl.'%</h5></td>
  <td><h5><strong>Wrong:</strong> '.$percWroPerQcl.'%</h5></td>
</tr>
</table>';
  //echo '<strong><h3></h3></strong>';

  $studAnsw = count($answ_perQuest);
 $result_content2 .= '<table class="TFtable">';
  foreach($answ as $answs) {

    if($quests['ID'] == $answs['question_id']) {
//echo '<br><h1>question id: '.$quests['ID'].' end</h1>';
//echo ' <h1>answer question id: '.$answs['question_id'].' end</h1><br>';

      $result_content2 .= '<tr>
        <td><strong>answer: '.$answs['sort_order'].'</strong></td>
        <td>'.$answs['answer'].'</td>';

        $a_id = $answs['answer'];
        $ans_id = $answs['ID'];
        $ansQ_id = $answs['question_id'];

        //This holds the total number of student selections for each respective answers
        $sacount = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id AND answer = '$a_id'", ARRAY_A);
        //This holds the total number of student answers per the whole question
        $sacountT = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id AND question_id = '$ansQ_id'", ARRAY_A);

        $studSelAnsw = count($sacount);

        $percSel = ($studSelAnsw * 100) / $studAnsw;
        $percSelCl = number_format($percSel, 2);

        //echo 'total answers for this question: '.$studAnsw.'<br>';

        $result_content2 .= '<td>chosen: '.$studSelAnsw.' time(s)</td>

        <td>'.$percSelCl.'%</td>
        </tr>';

    }

  }

$result_content2 .= '<td>total answers per question: '.$totalAnsw_perQuest.'</td>';
  $totalCorrAnsw_perQuest = count($corrAnsw_perQuest);
$result_content2 .= '<td>total correct answers per question: '.$totalCorrAnsw_perQuest.'</td>
</table>';
}
$result_content2 .= '</div><br>
   <center><h2><strong>Full Student List</strong></h2></center>
';

   //Run query for full student list with info and stat

   $result_content2 .= '<table class="TFtable">
      <tr>
         <td><strong>Student Name</strong></td><td><strong>Percent Correct</strong></td><td><strong>Login Name</strong></td>
      </tr>
   ';
   foreach($allStudents as $studs) {
     $studID = $studs['user_id'];
     $studentInfo = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users WHERE ID = $studID", ARRAY_A);
     $studMetaFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'first_name'", ARRAY_A);
     $studMetaLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'last_name'", ARRAY_A);
     $topStudScore = $wpdb->get_results( "SELECT percent_correct FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = $studID", ARRAY_A);
$result_content2 .= '
   <div>
         <tr>
            <td>'.$studMetaFn[0]['meta_value'].' '.$studMetaLn[0]['meta_value'].'</td>
            <td>'.$topStudScore[0]['percent_correct'].'%</td>
            <td>'.$studentInfo[0]['user_login'].'</td>
         </tr>
   </div>';
   }
   $result_content2 .= '</table>';
global $post;
$post_title = $pName.'(RESULTS)';

$user_id = get_current_user_id();

      $check_post = get_page_by_title($post_title, 'OBJECT', 'post');
      if(empty($check_post)) {

           $new_post = [
              'post_title' => $_POST['exam'].'(RESULTS)',
              'post_content' => '
                 '.$result_content1.$result_content2.'</table>',
              'post_status' => 'publish',
              'post_date' => date('Y-m-d H:i:s123'),
              'post_author' => $user_id,
              'post_type' => 'post',
              'post_category' => [0]
          ];
          $post_id = wp_insert_post($new_post);
          echo 'New result post created';
      }
      else {

        $update_post = [
          'ID' => $check_post->ID,
          'post_title' => $pName.'(RESULTS)',
          //'post_content' => 'new test content',
          'post_content' => '
             '.$result_content1.'<table class="TFtable">
             '.$result_content2.'</table>',
          'post_status' => 'publish',
          'post_author' => $user_id,
          'post_category' => [0]
        ];
         wp_update_post($update_post);
      }

echo 'This post has been updated';
}
