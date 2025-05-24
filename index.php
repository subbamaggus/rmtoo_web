<?php

require('manager_req.php');

$myManager = new RequirementManager();

$dir = "./MyProject/requirements";



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
    function minimize_all() { 
        document.body.querySelectorAll('details').forEach(
            (e) => {
                (e.hasAttribute('open')) ?
                e.removeAttribute('open') : e.setAttribute('open',false);
                console.log(e.hasAttribute('open'))
            }
        
        )
    }
    </script>
    <style>
        label,input {
            display:flex;
            flex-direction:column;
        }
        
        hr.new5 {
            border: 10px solid green;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <input id="max" type="button" value="expand all" onclick="expand_all();" />
    <input id="min" type="button" value="minimize_all" onclick="minimize_all();" />
<?php

$files1 = scandir($dir);
foreach ($files1 as $key => $value)
{
    if (!in_array($value,array(".","..")))
    {
        $file = $dir . DIRECTORY_SEPARATOR . $value;
        if (!is_dir($file))
        {
            $myReq = $myManager->getReqFromFile($file);

            $element = <<<END
                <hr class="new5">
            <details>
                <summary>{$myReq->Name}</summary>
                <form action="save.php">
                    <input type="hidden" name="id" value="{$file}">
                    <label>Topic<input name="Topic" value="{$myReq->Topic}"></label><br>
                    <label>Type<input name="Type" value="{$myReq->Type}"></label><br>

                    <label>Invented_on<input type="date" id="Invented_on" name="Invented_on" value="{$myReq->Invented_on}"></label><br>
                    <label>Invented_by<input name="Invented_by" value="{$myReq->Invented_by}"></label><br>

                    <label>Owner<input name="Owner" value="{$myReq->Owner}"></label><br>
                    
                    <br>

                    <label>Status<input name="Status" value="{$myReq->Status}"></label><br>
                    <label>Priority<input name="Priority" value="{$myReq->Priority}"></label><br>
                    <label>Effort_estimation<input name="Effort_estimation" value="{$myReq->Effort_estimation}"></label><br>

                    <label>Description<textarea name="Description" cols="50" rows="4">{$myReq->Description}</textarea></label><br>
                    <label>Rationale<textarea name="Rationale" cols="50" rows="4">{$myReq->Rationale}</textarea></label><br>

                    <label>Test_Cases<input name="Test_Cases" value="{$myReq->Test_Cases}"></label>
                    
                    <P align="right"><input type="submit" value="save"></p>
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