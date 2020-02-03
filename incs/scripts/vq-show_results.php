<?php

function vq_show_results() {

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

   echo '<center><h2>Full Student List</h2></center>';
    echo '<table class="TFtable">';
   //Run query for student list with info and stat
   foreach($topStudents as $studs) {
     $studID = $studs['user_id'];
     $studentInfo = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users WHERE ID = $studID", ARRAY_A);
     $studMetaFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'first_name'", ARRAY_A);
     $studMetaLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $studID AND meta_key = 'last_name'", ARRAY_A);<?php

function vq_show_results() {
    
    $pName = $_POST['exam'];
    $sName = $_POST['school'];

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

    $examTakes = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id", ARRAY_A);


    //Top 10 students sql query
    $topStudents = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id ORDER BY percent_points DESC LIMIT 10", ARRAY_A);
    $allStudents = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_taken_exams WHERE exam_id = $x_id ORDER BY percent_points DESC", ARRAY_A);


    $maxPoints = $maxScore[0]['MAX(max_points)'];

    $highScorePerc = ($topScore[0]['MAX(points)'] * 100) / $maxPoints;

    $highScorePercCl = number_format($highScorePerc, 2);

    $lowScorePerc = ($lowScore[0]['MIN(points)'] * 100) / $maxPoints;

    $lowScorePercCl = number_format($lowScorePerc, 2);
    echo 'ready to print';

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

    $topQuests = $wpdb->get_results( "SELECT DISTINCT question_id, SUM(is_correct) tots FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id GROUP BY question_id ORDER BY tots DESC LIMIT 10", ARRAY_A);

    $botQuests = $wpdb->get_results( "SELECT DISTINCT question_id, SUM(is_correct) tots FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id GROUP BY question_id ORDER BY tots ASC LIMIT 10", ARRAY_A);

    echo '<div>';
        echo '<br><center><h2>Top Questions</h2></center>';
        foreach($topQuests as $topQuest) {
            $tq_id = (int)$topQuest['question_id'];

            $questActual = $wpdb->get_results( "SELECT question FROM {$wpdb->prefix}watupro_question WHERE exam_id = $x_id AND ID = $tq_id", ARRAY_A);
             echo $questActual[0]['question'].'<br>';

            $corrAns = $topQuest['tots'];
            echo 'Correct answers: '.$corrAns.'<br><br>';
        }
    echo '</div>';
    echo '<div>';
        echo '<br><center><h2>Bottom Questions</h2></center>';
        foreach($botQuests as $botQuest) {
            $tq_id = (int)$botQuest['question_id'];

            $questActual = $wpdb->get_results( "SELECT question FROM {$wpdb->prefix}watupro_question WHERE exam_id = $x_id AND ID = $tq_id", ARRAY_A);
             echo $questActual[0]['question'].'<br>';

            $corrAns = $botQuest['tots'];
            echo 'Correct answers: '.$corrAns.'<br><br>';
        }
    echo '</div>';

echo '<div>';
echo '<br><center><h2>QUESTIONS</h2></center>';
  foreach($quest as $quests) {

    $q_id = (int)$quests['ID'];
    //This collects the total number of student answers given per a question
    $answ_perQuest = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_student_answers WHERE question_id = $q_id", ARRAY_A);

    //This collects the total number of correct student answers given per a question
    $corrAnsw_perQuest = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_student_answers WHERE question_id = $q_id AND is_correct = 1", ARRAY_A);
    $totalCorrAnsw_perQuest = count($corrAnsw_perQuest);
    $totalAnsw_perQuest = count($answ_perQuest);

//var_dump($corrAnsw_perQuest);
echo '<br>';
//var_dump($answ_perQuest);

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

//loop through answer data for output
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
          $sacount = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id AND answer = '$a_id' AND question_id = '$ansQ_id'", ARRAY_A);
          //This holds the total number of student answers per the whole question
          $sacountT = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}watupro_student_answers WHERE exam_id = $x_id AND question_id = '$ansQ_id'", ARRAY_A);

//debug break
//var_dump($sacount);

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

   echo '<center><h2>Full Student List</h2></center>';
    echo '<table class="TFtable">';
   //Run query for student list with info and stat
   foreach($allStudents as $studs) {
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

   $stName = $sName.'_teacher';
   $teacher = $wpdb->get_results( "SELECT DISTINCT meta_value FROM {$wpdb->prefix}usermeta WHERE meta_key = '$stName'", ARRAY_A);

   foreach($teacher as $teachers) {

      $teacher_name = $teachers['meta_value'];
      $teacherstud_id = $wpdb->get_results( "SELECT DISTINCT user_id FROM {$wpdb->prefix}usermeta WHERE meta_value = '$teacher_name'", ARRAY_A);
         $stud_count = 0;
      foreach($teacherstud_id as $teacherstuds_ids) {
         $t_id = $teacherstuds_ids['user_id'];


         $stud_exam = $wpdb->get_results( "SELECT exam_id FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = '$t_id'", ARRAY_A);
         $stud_score = $wpdb->get_results( "SELECT percent_correct FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = '$t_id'", ARRAY_A);
         $studFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $t_id AND meta_key = 'first_name'", ARRAY_A);
         $studLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $t_id AND meta_key = 'last_name'", ARRAY_A);
         $curr_stud_id = $wpdb->get_results( "SELECT user_login FROM {$wpdb->prefix}users WHERE ID = $t_id", ARRAY_A);
         $stud_teacher = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $t_id AND meta_key = 'teacher_of_student'", ARRAY_A);
         if($x_id == $stud_exam[0]['exam_id']) {
               $stud_count += 1;
         }

      }
      //echo $stud_count;
      $disTeacher = 'hide';
      if($stud_count > 0) {
        $disTeacher = '';
      }
      else {
        $disTeacher = 'hide';
      }

      echo '<div class="'.$disTeacher.'">';
      echo '<br><h3><strong>'.$teacher_name.'</strong></h3>';
      echo '<table class="TFtable">';
      echo '<tr><td><strong>Student Name</strong></td><td><strong>Percent Correct</strong></td><td><strong>Username</strong></td></tr>';

      foreach($teacherstud_id as $teacherstuds_ids) {
         $t_id = $teacherstuds_ids['user_id'];


         $stud_exam = $wpdb->get_results( "SELECT exam_id FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = '$t_id'", ARRAY_A);
         $stud_score = $wpdb->get_results( "SELECT percent_correct FROM {$wpdb->prefix}watupro_taken_exams WHERE user_id = '$t_id'", ARRAY_A);
         $studFn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $t_id AND meta_key = 'first_name'", ARRAY_A);
         $studLn = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $t_id AND meta_key = 'last_name'", ARRAY_A);
         $curr_stud_id = $wpdb->get_results( "SELECT user_login FROM {$wpdb->prefix}users WHERE ID = $t_id", ARRAY_A);
         $stud_teacher = $wpdb->get_results( "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = $t_id AND meta_key = 'teacher_of_student'", ARRAY_A);
         if($x_id == $stud_exam[0]['exam_id']) {
               $stud_count += 1;
               echo '<tr>';
               echo '<td>'.$studFn[0]['meta_value'].' ';
               echo $studLn[0]['meta_value'].'</td>';
               echo '<td>'.$stud_score[0]['percent_correct'].' %</td>';
               echo '<td>'.$curr_stud_id[0]['user_login'].'</td>';
               echo '</tr>';
         }
      }
      echo '</table>';
      echo '</div>';
  }
}
?>

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

?>
