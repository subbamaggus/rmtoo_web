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
    <script>
    function expand_all() { 
        document.body.querySelectorAll('details').forEach(
            (e) => {
                (e.hasAttribute('open')) ?
                e.removeAttribute('open') : e.setAttribute('open',true);
                console.log(e.hasAttribute('open'))
            }
        
        )
    }
  </script>
</head>
<body>
    <input id="clickMe" type="button" value="expand all" onclick="expand_all();" />
<?php

foreach ($files1 as $key => $value)
{
   if (!in_array($value,array(".","..")))
   {

      if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
      {
         $myReq = $myManager->getReqFromFile($dir . DIRECTORY_SEPARATOR . $value);
         //print_r($myReq);
         $Name = $myReq->Name;
         $Description = $myReq->Description;
         $Invented_on = $myReq->Invented_on;
         
         $element = <<<END
            <details>
                <summary>${Name}</summary>
                <form>
                    <p>${Description}</p>
                    <input type="date" id="date-input" name="date-input" value="${Invented_on}">
                </form>
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