<?php

require('manager_req.php');

$myManager = new RequirementManager();

$data = $myManager->getFileContent("./MyProject/requirements/req1.req");

$myReq = $myManager->parseContent($data);

print_r($myReq);

?>