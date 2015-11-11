<?php
require_once("View/Layoutview.php");

require_once("View/Menuview.php");
require_once("Controller/Menucontroller.php");

require_once("View/Gameview3x3.php");
require_once("View/Gameview5x5.php");

require_once("Controller/Gamecontroller.php");

require_once("Model/Gamemodel3x3.php");
require_once("Model/Gamemodel5x5.php");

require_once("Model/ScoreDAL.php");

require_once("View/Navigationview.php");

class Mastercontroller
{
    private $currentgamemessage;
    
    public function Startapplication()
    {
        $Layout = new LayoutView();
        $DAL = new ScoreDAL();
        $Gamemodel3x3 = new Gamemodel3x3($DAL);
        $Gameview3x3 = new Gameview3x3($Gamemodel3x3);
        
        $Gamemodel5x5 = new Gamemodel5x5($DAL);
        $Gameview5x5 = new Gameview5x5($Gamemodel5x5);
        
        $Gamecontroller = new Gamecontroller($Gameview3x3,$Gamemodel3x3,$Gameview5x5,$Gamemodel5x5);
        $Navigationview =  new Navigationview();
        
        $Menuview = new Menuview($DAL);
        $Menucontroller = new Menucontroller($Menuview,$Gamecontroller);
        
        $uri = $Navigationview->GetURL();
        $uri = explode("?",$uri);
        
        if(count($uri) > 1 && $uri[1] == "Game3x3")
        {
            $v = $Gamecontroller->Choose3x3Game();
            $this->currentgamemessage = $Gamecontroller->Currentgamemode();
        }
        elseif(count($uri) > 1 && $uri[1] == "Game5x5")
        {
            $v = $Gamecontroller->Choose5x5game();
            $this->currentgamemessage = $Gamecontroller->Currentgamemode();
        }
        else
        {
            $v = $Menucontroller->Init();
        }
        $Layout->render($v,$this->currentgamemessage);
    }
}