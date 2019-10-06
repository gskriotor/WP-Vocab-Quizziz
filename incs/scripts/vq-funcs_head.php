<?php

function vq_funcs_head() {
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
}
