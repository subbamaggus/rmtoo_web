<?php

require('datamanager.php');

$active_project = "";
if(isset($_COOKIE["active_project"]))
{
    $active_project = $_COOKIE["active_project"];
}

if(isset($_GET["project"]))
{
    setcookie("active_project", $_GET["project"], time() + (86400 * 30), "/");
    $active_project = $_GET["project"];
}

$projects_root = "./";
$project_dirs = scandir($projects_root);
$projects = array();
$nav = "";
foreach ($project_dirs as $key => $value)
{
    if (!in_array($value,array(".","..",".git")))
    {
        $file = $projects_root . DIRECTORY_SEPARATOR . $value;
        if (is_dir($file))
        {
            $projects[] = $value;
            $nav .= <<<END
            <a href="?project={$value}">{$value}</a> - 
            END;            
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
    <script>
    function expand_all() { 
        document.body.querySelectorAll('details').forEach(
            (e) => { e.setAttribute('open',true); }
        )
    }
    function minimize_all() { 
        document.body.querySelectorAll('details').forEach(
            (e) => { e.removeAttribute('open'); }
        )
    }
    </script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        
        label,input {
            display:flex;
            flex-direction:column;
        }
        
        label {
            font-size:1vw
        }

        input {
            font-size:2vw
        }
        
        hr.new5 {
            border: 10px solid LightSkyBlue;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php echo $nav; ?>
    <hr class="new5">
    <input type="button" value="store in vcs" />
    <input type="button" value="create documents" />
    <hr class="new5">
<?php


if("" <> $active_project)
{
?>
    <h1>requirements</h1>
    <input id="max" type="button" value="expand all" onclick="expand_all();" />
    <input id="min" type="button" value="minimize_all" onclick="minimize_all();" />
<?php
    $myManager = new DataManager();
    $dir = $projects_root . DIRECTORY_SEPARATOR . $active_project . DIRECTORY_SEPARATOR . "requirements";
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
                        <summary>{$myReq["Name"]}</summary>
                        <form action="save.php" method="POST">
                            <input type="hidden" name="id" value="{$file}">
                            <input type="hidden" name="Name" value="{$myReq["Name"]}"></label>
                            <label>Topic<input name="Topic" value="{$myReq["Topic"]}"></label>
                            <label>Type<input name="Type" value="{$myReq["Type"]}"></label>
        
                            <label>Invented_on<input type="date" id="Invented_on" name="Invented_on" value="{$myReq["Invented on"]}"></label>
                            <label>Invented_by<input name="Invented_by" value="{$myReq["Invented by"]}"></label>
        
                            <label>Owner<input name="Owner" value="{$myReq["Owner"]}"></label>
        
                            <label>Status<input name="Status" value="{$myReq["Status"]}"></label>
                            <label>Solved by<input name="Solved_by" value="{$myReq["Solved by"]}"></label>
                            <label>Priority<input name="Priority" value="{$myReq["Priority"]}"></label>
                            <label>Effort_estimation<input name="Effort_estimation" value="{$myReq["Effort estimation"]}"></label>
        
                            <label>Description<input name="Description" value="{$myReq["Description"]}"></label>
                            <label>Rationale<input name="Rationale" value="{$myReq["Rationale"]}"></label>
        
                            <label>Test_Cases<input name="Test_Cases" value="{$myReq["Test Cases"]}"></label>
                            
                            <p align="right"><input type="submit" value="save"></p>
                        </form>
                    </details>

            END;
            
                echo $element;
            }
        }
    }
}
?>
</body>
</html>