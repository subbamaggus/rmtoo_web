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
    
    function putFileContent(string $filename, string $content) {
        file_put_contents($filename, $content, false);
    }
}

?>