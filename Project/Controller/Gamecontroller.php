<?php
class Gamecontroller
{
    public function __construct(Gameview3x3 $_View3,Gamemodel3x3 $_Model3,Gameview5x5 $_View5,Gamemodel5x5 $_Model5)
    {
        $this->View3 = $_View3;
        $this->Model3 = $_Model3;
        $this->View5 = $_View5;
        $this->Model5 = $_Model5;
    }
    
    
    public function Choose3x3Game()
    {
        $_SESSION["IsgameFT3"] = true;
        $this->Currentgamemode();
        $_SESSION["Currentgamemode"] = "First to three wins is the winner!";
        return $this->Init();
    }
    
    public function Choose5x5game()
    {

        $_SESSION["IsgameFT3"] = false;
        $this->Currentgamemode();
        $_SESSION["Currentgamemode"] = "First to five wins is the winner!";
        return $this->Init();
    }
    
    public function Init()
    {
        if($this->Currentgamemode() == "First to three wins is the winner!")
        {
            return $this->Start3x3Game();
        }
        elseif($this->Currentgamemode() == "First to five wins is the winner!")
        {
            return $this->Start5x5Game();
        }
    }
    
    private function Start3x3Game()
    {
        if($this->View3->Doesuserwanttomove()) //If a gameseries is started, generate a board and after that start the game, and after that send data to model to validate.
        {
             $board = $this->View3->Getaboard();
             $this->View3->StartGame();
             $this->Model3->ValidateData($board,$this->View3->GetMovesMade());
        }
        
        if($this->View3->Doesuserwanttoplayagain()) //If play again is pressed, redirect to gamepage and empty board.
        {
            $this->View3->Getaboard();
            header("location:Index.php?Game3x3");
            return $this->View3;
        }
        
        if($this->View3->DoesUserwanttostartagain()) //Go back to start
        {
            header("location:Index.php");
        }
        $this->View3->Getaboard();
        return $this->View3;
    }
    
    private function Start5x5Game()
    {
        if($this->View5->Doesuserwanttomove()) //If a gameseries is started, generate a board and after that start the game, and after that send data to model to validate.
        {
             $board = $this->View5->Getaboard();
             $this->View5->StartGame();
             $this->Model5->ValidateData($board,$this->View5->GetMovesMade());
        }
        
        if($this->View5->Doesuserwanttoplayagain()) //If play again is pressed, redirect to gamepage and empty board.
        {
            $this->View5->Getaboard();
            header("location:Index.php?Game5x5");
            return $this->View5;
        }
        
        if($this->View->DoesUserwanttostartagain()) //Go back to start
        {
            header("location:Index.php");
        }
        
        $this->View5->Getaboard();
        return $this->View5;
    }
    
    public function Currentgamemode()
    {
        if(!isset($_SESSION["Currentgamemode"]))
        {
            $_SESSION["Currentgamemode"] = "";
        }
        return $_SESSION["Currentgamemode"];
    }
}