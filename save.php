<?php

require('datamanager.php');

$myManager = new DataManager();

function format_post(array $post_array, string $value) {
    return str_replace("_", " ", $value) . ": " . $post_array[$value] . "\r\n";
}

$data = format_post($_POST, "Name");
$data .= format_post($_POST, "Type");
$data .= format_post($_POST, "Invented_on");
$data .= format_post($_POST, "Invented_by");
$data .= format_post($_POST, "Owner");
$data .= format_post($_POST, "Description");
$data .= format_post($_POST, "Rationale");
$data .= format_post($_POST, "Status");
$data .= format_post($_POST, "Solved_by");
$data .= format_post($_POST, "Priority");
$data .= format_post($_POST, "Effort_estimation");
$data .= format_post($_POST, "Topic");
$data .= format_post($_POST, "Test_Cases");

$myManager->putFileContent($_POST["id"], $data);

//print_r($data);

header('Location: index.php');

?>