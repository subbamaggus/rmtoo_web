<?php

require('datamanager.php');

$myManager = new DataManager();

$myManager->putFileContent($_POST);

header('Location: index.php');

?>