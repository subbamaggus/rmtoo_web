<?php

class Requirement {
    public string $Name;
    public string $Type;
    public string $Invented_on;
    public string $Invented_by;
    public string $Owner;
    public string $Description;
    public string $Rationale;
    public string $Status;
    public string $Priority;
    public string $Effort_estimation;
    public string $Topic;
    public string $Test_Cases;
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
                    $req->Name = $element[1];
                    break;
                case "Type":
                    $req->Type = $element[1];
                    break;
                case "Invented on":
                    $req->Invented_on = $element[1];
                    break;
                case "Invented by":
                    $req->Invented_by = $element[1];
                    break;
                case "Owner":
                    $req->Owner = $element[1];
                    break;
                case "Description":
                    $req->Description = $element[1];
                    break;
                case "Rationale":
                    $req->Rationale = $element[1];
                    break;
                case "Status":
                    $req->Status = $element[1];
                    break;
                case "Priority":
                    $req->Priority = $element[1];
                    break;
                case "Effort estimation":
                    $req->Effort_estimation = $element[1];
                    break;
                case "Topic":
                    $req->Topic = $element[1];
                    break;
                case "Test Cases":
                    $req->Test_Cases = $element[1];
                    break;                 
            }
            $line = strtok( $separator );
        }
        
        return $req;
    }
}

?>