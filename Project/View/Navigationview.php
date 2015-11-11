<?php

class Navigationview
{

    public function GetURL()
    {
        $CurrentURL = $_SERVER["REQUEST_URI"];
        
        return $CurrentURL;
    }
}