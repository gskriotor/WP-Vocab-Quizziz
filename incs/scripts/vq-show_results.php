<?php

function vq-get_studs() {

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
    $topStudents = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id ORDER BY percent_points DESC", ARRAY_A);

    $maxPoints = $maxScore[0]['MAX(max_points)'];

    $highScorePerc = ($topScore[0]['MAX(points)'] * 100) / $maxPoints;

    $highScorePercCl = number_format($highScorePerc, 2);

    $lowScorePerc = ($lowScore[0]['MIN(points)'] * 100) / $maxPoints;

    $lowScorePercCl = number_format($lowScorePerc, 2);
    echo 'ready to print';

    echo '
    <style type="text/css">
    	.TFtable{
    		width:100%;
    		border-collapse:collapse;
    	}
    	.TFtable td{
    		padding:7px; border:#4e95f4 1px solid;
    	}
    	/* provide some minimal visual accomodation for IE8 and below */
    	.TFtable tr{
    		background: #b8d1f3;
    	}
    	/*  Define the background color for all the ODD background rows  */
    	.TFtable tr:nth-child(odd){
    		background: #b8d1f3;
    	}
    	/*  Define the background color for all the EVEN background rows  */
    	.TFtable tr:nth-child(even){
    		background: #dae5f4;
    	}

    </style>
    ';

   echo '<center><h2>Full Student List</h2></center>';
    echo '<table class="TFtable">';
   //Run query for student list with info and stat
   foreach($topStudents as $studs) {
     $studID = $studs['user_id'];
     $studentInfo = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users WHERE ID = $studID", ARRAY_A);
     $studMetaFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'first_name'", ARRAY_A);
     $studMetaLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'last_name'", ARRAY_A);
     $topStudScore = $wpdb->get_results( "SELECT percent_correct FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = $studID", ARRAY_A);
echo '<div>';

   echo '

         <tr>
   ';
     echo '<td><strong>Student Name: </strong>'.$studMetaFn[0]['meta_value'].' ';
     echo $studMetaLn[0]['meta_value'].'</td>';
     echo '<td><strong>Correct:</strong>'.$topStudScore[0]['percent_correct'].'%</td>';
     echo '<td><strong>Login Name: </strong>'.$studentInfo[0]['user_login'].'</td>';
   echo '</tr> ';

echo '</div>';
   }
echo '</table>';


echo '</div>';
echo '</div>';
}


function vq-get_exam() {

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
  $topStudents = $wpdb->get_results( "SELECT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id ORDER BY percent_points DESC LIMIT 10", ARRAY_A);

  $maxPoints = $maxScore[0]['MAX(max_points)'];

  $highScorePerc = ($topScore[0]['MAX(points)'] * 100) / $maxPoints;

  $highScorePercCl = number_format($highScorePerc, 2);

  $lowScorePerc = ($lowScore[0]['MIN(points)'] * 100) / $maxPoints;

  $lowScorePercCl = number_format($lowScorePerc, 2);

  echo '<center><h1><strong>'.$pName.'</strong></h1></center><br>';

echo '<div>';
  echo '<table class="TFtable">';
  echo '<tr>';
  echo '<td><strong>Exam Date:</strong> '.$results[0]['date'].'</td>';

  echo '<td><strong>Highest Score:</strong> '.$topScore[0]['MAX(points)'].' - ';
  echo $highScorePercCl.'%</td>';

  echo '<td><strong>Lowest Score:</strong> '.$minScore[0]['MIN(points)'].' - ';
  echo $lowScorePercCl.'%</td>';

  $answCountt = count($sanswt);
  $answCountc = count($sanswc);
  echo '<td><strong>Total Possible:</strong> '.$maxPoints.'</td>';
  //echo 'correct: '.$answCountc.'<br>';

  $classAver = ($answCountc * 100) /$answCountt;
  $classAverCl = number_format($classAver, 2);

  echo '<td><strong>Class Average:</strong> '.$classAverCl.'</td>';
echo '</div>';

  $totalTakes = count($examTakes);
  echo '<td><strong>Total Submissions:</strong> '.$totalTakes.'</td>';
        echo '</tr>';
  echo '</table><br>';

  echo '<h3>Top Students</h3>';
  echo '<table class="TFtable">';
  foreach($topStudents as $studs) {
    $studID = $studs['user_id'];
    $studentInfo = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users WHERE ID = $studID", ARRAY_A);
    $studMetaFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'first_name'", ARRAY_A);
    $studMetaLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'last_name'", ARRAY_A);
    $topStudScore = $wpdb->get_results( "SELECT percent_correct FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = $studID", ARRAY_A);
    echo '<div>';

      echo '<tr>';
    echo '<td><strong>Student Name:</strong> '.$studMetaFn[0]['meta_value'];
    echo $studMetaLn[0]['meta_value'].'</td>';
    echo '<td><strong>Correct:</strong> '.$topStudScore[0]['percent_correct'].'%</td>';

    echo '<td><strong>Login Name:</strong> '.$studentInfo[0]['user_login'].'</td>';
    echo '</tr>';

echo '</div>';
   }
echo '</table>';
echo '</div>';
echo '<div>';
echo '<br><center><h2>QUESTIONS</h2></center>';
  foreach($quest as $quests) {

    $q_id = (int)$quests['ID'];
    //This collects the total number of student answers given per a question
    $answ_perQuest = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE question_id = $q_id", ARRAY_A);

    //This collects the total number of correct student answers given per a question
    $corrAnsw_perQuest = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watupro_student_answers WHERE question_id = $q_id AND is_correct = 1", ARRAY_A);
    $totalCorrAnsw_perQuest = count($corrAnsw_perQuest);
    $totalAnsw_perQuest = count($answ_perQuest);
echo '<div>';

    $percentCorrPerQ = ($totalCorrAnsw_perQuest * 100) / $totalAnsw_perQuest;
    $percentWroPerQ = 100 - $percentCorrPerQ;

    $percWroPerQcl = number_format($percentWroPerQ, 2);
    $percCorrPerQcl = number_format($percentCorrPerQ, 2);

//echo '<div style="float: left; padding: 4px;">';

    echo '<br><strong><h4>QUESTION: '.$quests['sort_order'].'</h4></strong>';
    echo '<table class="TFtable">';
    echo '<tr>';
    echo '<td><h4>'.$quests['question'].'</h4></td>';
    echo '<td><h5><strong>Correct:</strong> '.$percCorrPerQcl.'%</h5></td>';
    echo '<td><h5><strong>Wrong:</strong> '.$percWroPerQcl.'%</h5></td>';
echo '</tr>';
echo '</table>';
    //echo '<strong><h3></h3></strong>';

    $studAnsw = count($answ_perQuest);
  echo '<table class="TFtable">';
    foreach($answ as $answs) {

      if($quests['ID'] == $answs['question_id']) {
//echo '<br><h1>question id: '.$quests['ID'].' end</h1>';
//echo ' <h1>answer question id: '.$answs['question_id'].' end</h1><br>';

        echo '<tr>';
          echo '<td><strong>answer: '.$answs['sort_order'].'</strong></td>';
          echo '<td>'.$answs['answer'].'</td>';

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

          echo '<td>chosen: '.$studSelAnsw.' time(s)</td>';

          echo '<td>'.$percSelCl.'%</td>';
          echo '</tr>';

      }

    }

echo '<td>total answers per question: '.$totalAnsw_perQuest.'</td>';
    $totalCorrAnsw_perQuest = count($corrAnsw_perQuest);
echo '<td>total correct answers per question: '.$totalCorrAnsw_perQuest.'</td>';
 echo '</table>';
  }
echo '</div>';
}

function vq-show_results() {
   vq-get_studs();
   vq-get_exam();
}

?>
