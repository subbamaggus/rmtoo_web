<?php

require('manager_req.php');

$myManager = new RequirementManager();

$dir = "./MyProject/requirements";

$myReq = $myManager->getReqFromFile("./MyProject/requirements/req1.req");

$files1 = scandir($dir);


foreach ($files1 as $key => $value)
{
   if (!in_array($value,array(".","..")))
   {

      if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
      {
         $myReq = $myManager->getReqFromFile($dir . DIRECTORY_SEPARATOR . $value);
         print_r($myReq);
      }

   }

}

?>
<!doctype html>
<html lang="en-US">
<head>

  <title>rmtoo web ui</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>


  <details>
    <summary>Expandable motherfucker</summary>
    <p>Fucking boo, motherfucker 👻</p>
  </details>
</body>
</html>