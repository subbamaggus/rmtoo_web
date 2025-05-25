<?php

class DataManager
{
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
    
    function getReqFromFile(string $filename) {
        $content = $this->getFileContent($filename);
        return $this->parseContent($content);
    }
    
    function format_post(array $post_array, string $value) {
        return str_replace("_", " ", $value) . ": " . $post_array[$value] . "\r\n";
    }
    
    function putFileContent(array $postdata) {

        $data = $this->format_post($postdata, "Name");
        $data .= $this->format_post($postdata, "Type");
        $data .= $this->format_post($postdata, "Invented_on");
        $data .= $this->format_post($postdata, "Invented_by");
        $data .= $this->format_post($postdata, "Owner");
        $data .= $this->format_post($postdata, "Description");
        $data .= $this->format_post($postdata, "Rationale");
        $data .= $this->format_post($postdata, "Status");
        $data .= $this->format_post($postdata, "Solved_by");
        $data .= $this->format_post($postdata, "Priority");
        $data .= $this->format_post($postdata, "Effort_estimation");
        $data .= $this->format_post($postdata, "Topic");
        $data .= $this->format_post($postdata, "Test_Cases");
        
        file_put_contents($postdata["id"], $data, false);
    }
}

?>