<?php

require('manager_req.php');

$myManager = new RequirementManager();

$dir = "./MyProject/requirements";

$files1 = scandir($dir);

?>
<!doctype html>
<html lang="en-US">
<head>

  <title>rmtoo web ui</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<?php

foreach ($files1 as $key => $value)
{
   if (!in_array($value,array(".","..")))
   {

      if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
      {
         $myReq = $myManager->getReqFromFile($dir . DIRECTORY_SEPARATOR . $value);
         //print_r($myReq);
         $name = $myReq->Name;
         $description = $myReq->Description;
         
         $element = <<<END
           <details>
             <summary>${name}</summary>
             <p>${description}</p>
           </details>
         \n
         END;
         
         echo $element;
      }
   }
}

?>
</body>
</html>