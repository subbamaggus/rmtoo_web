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

$myManager = new DataManager();

$projects_root = "./";
$nav = $myManager->getNavigation($projects_root);

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
            font-size:1em
        }

        input {
            font-size:2em
        }
        
        hr.big {
            border: 10px solid ForestGreen;
            border-radius: 5px;
        }
        hr.new5 {
            border: 4px solid ForestGreen;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php echo $nav; ?>

    <hr class="new5">
    <input type="button" value="store in vcs" />
    <input type="button" value="create documents" />
    <hr class="big">
<?php

if("" <> $active_project)
{
?>

    <h1><?php echo $active_project; ?></h1>
    
    <input id="max" type="button" value="expand all" onclick="expand_all();" />
    <input id="min" type="button" value="minimize_all" onclick="minimize_all();" />
<?php
    $whole_script = "";
    
    $folders = $myManager->getDataStruct();
    foreach ($folders as $folder => $folderarray) {
        
?>

    <h2><?php echo $folder; ?></h2>
<?php

        $dir = $projects_root . DIRECTORY_SEPARATOR . $active_project . DIRECTORY_SEPARATOR . $folder;
        $files1 = scandir($dir);
        foreach ($files1 as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                $file = $dir . DIRECTORY_SEPARATOR . $value;
                $info = pathinfo($value);
                $file_name =  basename($file,'.'.$info['extension']);
                
                if (!is_dir($file))
                {
                    $myReq = $myManager->getDataFromFile($file);
                    $pre = "req_";
                    
                    $script = <<<END
                    
                        const form_{$pre}{$file_name} = document.querySelector("#{$pre}{$file_name}");
                        
                        async function sendData_{$pre}{$file_name}() {
                            const formData_{$pre}{$file_name} = new FormData(form_{$pre}{$file_name});
                            
                            try {
                                const response_{$pre}{$file_name} = await fetch("save.php", {
                                    method: "POST",
                                    body: formData_{$pre}{$file_name},
                                });
                                console.log(await response_{$pre}{$file_name}.json());
                            } catch (e) {
                                console.error(e);
                            }
                        }

                        form_{$pre}{$file_name}.addEventListener("submit", (event) => {
                            event.preventDefault();
                            sendData_{$pre}{$file_name}();
                        });
                    END;
                    
                    $whole_script .= $script;

                    $element = <<<END
                        
                    <hr class="new5">
                    <details>
                        <summary>{$myReq["Name"]}</summary>
                        <form id="{$pre}{$file_name}">
                            <input type="hidden" name="id" value="{$file}">
                            <input type="hidden" name="datatype" value="{$folder}">
                            <input type="hidden" name="Name" value="{$myReq["Name"]}">
                            
                    END;
                    
                    foreach($folders[$folder] as $datakey => $datavalue) {
                        $datacontent = $myReq[$datakey];
                        
                        if("date" == $datavalue) {
                            $element .= <<<END
                            
                            <label>{$datakey}<input type="date" name="{$datakey}" value="{$datacontent}"></label>
                        
                            END;
                        } elseif("testcase" == $datavalue) {
                            $element .= <<<END
                            
                            <label>{$datakey}<select name="{$datakey}[]" multiple>
                                <option value="volvo">Volvo</option>
                                <option value="saab">Saab</option>
                            </select>
                            </label>
                        
                            END;
                        } else {
                            $element .= <<<END
                            
                            <label>{$datakey}<input name="{$datakey}" value="{$datacontent}"></label>
                        
                            END;
                        }
                    }

                    $element .= <<<END
                            
                            <p align="right"><input type="submit" value="save"></p>
                        </form>
                    </details>
        
                    END;
            
                    echo $element;
                }
            }
        }
?>
        <hr class="new5">
        <input type="button" value="new Element for <?php echo $folder; ?>" />
        <hr class="big">
        
<?php
    }
}
?>
    <script>
<?php echo $whole_script; ?>

    </script>

</body>
</html>