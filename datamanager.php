<?php

class DataManager
{
    public $data_fields = array();

    function __construct() {
        $this->data_fields["requirements"] = array("Name", "Type", "Invented on", "Invented by", "Owner", "Description", "Rationale", "Status", "Solved by", "Priority", "Effort estimation", "Topic", "Test Cases");
        $this->data_fields["testcases"] = array("Name", "Owner", "Invented by", "Invented on", "Description", "Expected Result", "Note");
    }
    
    function getDataStruct() {
        return $this->data_fields;
    }
    
    function getFileContent(string $filename) {
        $content = file_get_contents($filename, true);
        
        return $content;
    }
    
    function parseContent(string $content) {
        $req = array();
        
        $separator = "\r\n";
        $line = strtok($content, $separator);
        
        while ($line !== false) {
            $element = explode(':', $line, 2);

            $req[$element[0]] = trim($element[1]);

            $line = strtok( $separator );
        }

        return $req;
    }
    
    function getDataFromFile(string $filename) {
        $content = $this->getFileContent($filename);
        return $this->parseContent($content);
    }
    
    function format_post(array $post_array, string $value) {
        $key = str_replace(" ", "_", $value);
        return $value . ": " . $post_array[$key] . "\r\n";
    }
    
    function putFileContent(array $postdata) {
        $datatype = $postdata["datatype"];
        
        $data = "";
        foreach($this->data_fields[$datatype] as $key => $value) {
            $localdata = $this->format_post($postdata, $value);
            $data .= $localdata;
        }
        
        file_put_contents($postdata["id"], $data, false);
        
        return true;
    }
    
    function getNavigation(string $root) {
        $project_dirs = scandir($root);
        $projects = array();
        $nav = "";
        foreach ($project_dirs as $key => $value)
        {
            if (!in_array($value, array(".","..",".git")))
            {
                $file = $root . DIRECTORY_SEPARATOR . $value;
                if (is_dir($file))
                {
                    $projects[] = $value;
                    $nav .= <<<END
                    <a href="?project={$value}">{$value}</a> - 
                    END;            
                }
            }
        }
        return $nav;
    }
}

?>