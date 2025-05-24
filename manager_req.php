<?php

class Requirement {
    public string $Name = "";
    public string $Type = "";
    public string $Invented_on = "";
    public string $Invented_by = "";
    public string $Owner = "";
    public string $Description = "";
    public string $Rationale = "";
    public string $Status = "";
    public string $Priority = "";
    public string $Effort_estimation = "";
    public string $Topic = "";
    public string $Test_Cases = "";
}

class RequirementManager
{
    function getFileContent(string $filename) {
        $content = file_get_contents($filename, true);
        
        return $content;
    }
    
    function parseContent(string $content) {
        $req = new Requirement();
        
        $separator = "\r\n";
        $line = strtok($content, $separator);
        
        while ($line !== false) {
            $element = explode(':', $line, 2);
            switch ($element[0]) {
                case "Name":
                    $req->Name = trim($element[1]);
                    break;
                case "Type":
                    $req->Type = trim($element[1]);
                    break;
                case "Invented on":
                    $req->Invented_on = trim($element[1]);
                    break;
                case "Invented by":
                    $req->Invented_by = trim($element[1]);
                    break;
                case "Owner":
                    $req->Owner = trim($element[1]);
                    break;
                case "Description":
                    $req->Description = trim($element[1]);
                    break;
                case "Rationale":
                    $req->Rationale = trim($element[1]);
                    break;
                case "Status":
                    $req->Status = trim($element[1]);
                    break;
                case "Priority":
                    $req->Priority = trim($element[1]);
                    break;
                case "Effort estimation":
                    $req->Effort_estimation = trim($element[1]);
                    break;
                case "Topic":
                    $req->Topic = trim($element[1]);
                    break;
                case "Test Cases":
                    $req->Test_Cases = trim($element[1]);
                    break;                 
            }
            $line = strtok( $separator );
        }
        
        return $req;
    }
    
    function getReqFromFile(string $filename) {
        $content = $this->getFileContent($filename);
        return $this->parseContent($content);
    }
}

?>