<?php
session_start();
// print_r($_POST);
// question: index
// answer: user answer
if (!isset($_SESSION['question'])) {
    $_SESSION['question'] = array();
} else {
    $_SESSION['question'][$_POST['question']] = ($_POST['answer']);
}
// print_r($_SESSION['question']);

$inp = file_get_contents('file.json');
$array = json_decode($inp);
$s_array = json_decode($array[$_POST['question']]->content_text, true);

// print_r($s_array['answers'][$_POST['answer']]);

if ($s_array['answers'][$_POST['answer']]['is_correct']) {
    echo "1";
    // exit;
} else {
    echo "0";
    // exit;
}
// session_destroy();

?>