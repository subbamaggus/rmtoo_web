<?php

require('datamanager.php');

$myManager = new DataManager();

$result["value"] = $myManager->putFileContent($_POST);

echo json_encode($result);

?>