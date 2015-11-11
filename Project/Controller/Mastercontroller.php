<?php
require_once("View/Layoutview.php");

require_once("View/Menuview.php");
require_once("Controller/Menucontroller.php");

require_once("View/Gameview.php");
require_once("Controller/Gamecontroller.php");
require_once("Model/Gamemodel.php");

require_once("Model/ScoreDAL.php");

require_once("View/Navigationview.php");

class Mastercontroller
{
    private $currentgamemessage;
    
    public function Startapplication()
    {
        $Layout = new LayoutView();
        $DAL = new ScoreDAL();
        $Gamemodel = new Gamemodel($DAL);
        $Gameview = new Gameview($Gamemodel); 
        $Gamecontroller = new Gamecontroller($Gameview,$Gamemodel);
        $Navigationview =  new Navigationview();
        
        $Menuview = new Menuview($DAL);
        $Menucontroller = new Menucontroller($Menuview,$Gamecontroller);
        
        $uri = $Navigationview->GetURL();
        $uri = explode("?",$uri);
        
        if(count($uri) > 1 && $uri[1] == "Game")
        {
            $v = $Gamecontroller->Init();
            $this->currentgamemessage = $Gamecontroller->Currentgamemode();
        }
        else
        {
            $v = $Menucontroller->Init();
        }
        $Layout->render($v,$this->currentgamemessage);
    }
}