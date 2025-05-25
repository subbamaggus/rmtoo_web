<?php

class DataManager
{
    public $data_fields = array();

    function __construct() {
        $this->data_fields["requirements"] = array("Name" => "string", "Type" => "string", "Invented on" => "date", "Invented by" => "string", "Owner" => "string", "Description" => "string", "Rationale" => "string", "Status" => "string", "Solved by" => "string", "Priority" => "string", "Effort estimation" => "string", "Topic" => "string", "Test Cases" => "testcases");
        $this->data_fields["testcases"] = array("Name" => "string", "Owner" => "string", "Invented by" => "string", "Invented on" => "date", "Description" => "string", "Expected Result" => "string", "Note" => "string");
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
        
        if(is_array($post_array[$key]))
            $result = implode(" ", $post_array[$key]);
        else
            $result = $post_array[$key];
        
        return $value . ": " . $result . "\r\n";
    }
    
    function putFileContent(array $postdata) {
        $datatype = $postdata["datatype"];
        error_log(print_r($postdata, TRUE));        
        $data = "";
        foreach($this->data_fields[$datatype] as $key => $value) {

            $localdata = $this->format_post($postdata, $key);
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