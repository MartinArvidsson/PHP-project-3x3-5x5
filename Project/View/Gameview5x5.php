<?php

class Gameview5x5
{
    private static $NewGame = 'Gameview::NewGame';
    private static $BacktoStart = 'Gameview::StartMenu';
    private $player = "X";
    private $board;
    private $message;
    private $gameOver = false;
    private $gameWon  = false;
    private $Boxcounter = 0;
    private $TotalMoves = 0;
    private $boarddata = array();
    private $valuetoremove = array();
    private $CurrentGamemode ="";
   
    public function __construct(Gamemodel5x5 $_Model)
    {
        $this->gameOver = false;
        $this->gameWon = false;
        $this->Model = $_Model;
    }
    
    public function Getaboard() //Creates a 3X3 board if none exists, otherwhise set it to the value of the session
    {
        if (!isset($_SESSION["board"]))
        {
            $this->board = new stdClass;
            $this->board->board = array();
            for($xlength = 0; $xlength < 5; $xlength++)
            {
                for($ylength = 0; $ylength < 5; $ylength++)
                {
                    $this->board->board[$xlength][$ylength] = null;
                    
                }
            }
            $_SESSION["board"] = $this->board;
            $this->player = "X";
            $_SESSION["player"] = $this->player;
        }
        else
        {
            $this->board = $_SESSION["board"];
            $this->player = $_SESSION["player"];
        }
        
        return $this->board;
    }
    
    public function startGame()
    {
        $this->Trytomove();
    }

    public function response() //What gets shown in layoutview.
    {
        return $this->DisplayBoard();
    }
    
    
    private function DisplayBoard()
    {
        $this->message = $this->Model->getwhowonmessage();

            $currentXwins = $this->Model->currentXwinsFT5();
            $currentOwins = $this->Model->currentOwinsFT5();
        if($this->message == "") // IF the game hasn't been played before or no winner is found, generate the 3x3 board.
        {
            $text = "
                <div id =\"board\">
                <a> Current X wins : $currentXwins</a>
                <br>
                <a> Current O wins : $currentOwins</a>
                    <form method=\"post\">
            ";
            $text .= $this->GenerateBoardtoplay();
			return $text;
        }
        else
        {
            if($this->Model->CheckforFT5Winner()) //If someone won the entire FT5 Series
            {
                $_SESSION["totalmoves"] = 0;
                $_SESSION["FT5Winner"] = "";
                $text = "<p>$this->message</p>";
                $text .= $this->GenerateBoardtoshow();
                $text .= "<form method = post><input type=\"submit\" name=". self::$BacktoStart . " value=\"Back to start\"/></form>";
                $this->message ="";
                return $text;
            }
            if($this->message =="Oavgjort!") //If no winner was found, play again
            {
                $_SESSION["totalmoves"] = 0;
                $this->message ="";
                $text = "<p>No winner, game tied sadly!, Go again</p>";
                $text .= $this->GenerateBoardtoshow();
                $text .= "<form method = post><input type=\"submit\" name=". self::$NewGame . " value=\"Play again\"/></form>";
                return $text;
            }
            else //If a series is underway..
            {
                $_SESSION["totalmoves"] = 0;
                $text = "<p>$this->message</p>";
                $text .= $this->GenerateBoardtoshow();
                $text .= "<form method = post><input type=\"submit\" name=". self::$NewGame . " value=\"Play again\"/></form>";
                $this->message ="";
                return $text;
            }
        }

    }
    
    private function GenerateBoardtoplay() //Generates a playable board
    {
        $boardtogen =  "<table>";
        for ($xlength = 0; $xlength < 5; $xlength++)
		{
    		$boardtogen .= "<tr>";
    		for ($ylength = 0; $ylength < 5; $ylength++)
    		{
    			$this->Boxcounter ++;
    			$boardtogen .= "<td id= \"board_cell\">";
    			$board = $this->board->board;
    			if($board[$xlength][$ylength])
    			{
    			    $boardtogen .= "<img src=\"../Project/Content/Pictures/{$board[$xlength][$ylength]}.png\" alt=\"{$board[$xlength][$ylength]}\" title=\"{$board[$xlength][$ylength]}\" />";
    			}
    			else
    			{
    			//REGULAR BUTTON
    		    $boardtogen .= "
    			    <input type=\"submit\" name= \"{$xlength}-{$ylength}\" value=\"$this->player\" id=\"Gamebutton\"></>
    			";
    		}
    		$boardtogen .= "</td>";
            }
            $boardtogen .= "</tr>";
		}
		
		return $boardtogen;
    }
    
    private function GenerateBoardtoshow() //Generate same board as above but with buttons disabled, since it's only for show when someone has won or tied the game.
    {
        $boardtogen =  "<table>";
        for ($xlength = 0; $xlength < 5; $xlength++)
		{
    		$boardtogen .= "<tr>";
    		for ($ylength = 0; $ylength < 5; $ylength++)
    		{
    			$this->Boxcounter ++;
    			$boardtogen .= "<td id= \"board_cell\">";
    			$board = $this->board->board;
    			if($board[$xlength][$ylength])
    			{
    			    $boardtogen .= "<img src=\"../Project/Content/Pictures/{$board[$xlength][$ylength]}.png\" alt=\"{$board[$xlength][$ylength]}\" title=\"{$board[$xlength][$ylength]}\" />";
    			}
    			else
    			{
    			//REGULAR BUTTON
    		    $boardtogen .= "
    			    <input type=\"submit\" name= \"{$xlength}-{$ylength}\" value=\"$this->player\" disabled = true id=\"Gamebutton\"></>
    			";
    		}
    		$boardtogen .= "</td>";
            }
            $boardtogen .= "</tr>";
		}
		
		return $boardtogen;
    }    
        
    private function Trytomove() //Attempts to place a marker on the board, this functionallity could prob. have been placed in the model and not in the view...
	{
	    $boardtoval = array_unique($this->boarddata);
		foreach ($boardtoval as $key => $value)
		{
			if ($value == $this->player)
			{	
				$coords = explode("-", $key);
				$this->board->board[$coords[0]][$coords[1]] = $this->player;
                $this->player = $this->player == "X" ? "O" : "X";
                $_SESSION["player"] = $this->player;
				//IF
				if(!isset($_SESSION["totalmoves"]))
				{
                    $_SESSION["totalmoves"] = 0;
				}
				$_SESSION["totalmoves"] ++;
			}
		}
	}
	//Button functionality.
    public function Doesuserwanttomove()
    {
        //Checks all boardpositons for a POST and uses that position in validation
        for($xcheck = 0; $xcheck < 5; $xcheck++)
        {
            for($ycheck = 0; $ycheck < 5; $ycheck++)
            {
                if(isset($_POST[$xcheck."-".$ycheck]))
        	    {
        	        $this->boarddata = $_POST;
        	        return true;
        	    }
            }
        }
        unset($_SESSION["board"]);        
        return false;
	}
	
	public function Doesuserwanttoplayagain() //Checks if Play again is pressed.
	{
	    if(isset($_POST[self::$NewGame]))
	    {
	        unset($_SESSION["board"]);
            $_SESSION["totalmoves"] = 0;	        
	        return true;
	    }
	    return false;
	}
	
	public function DoesUserwanttostartagain() //Checks if game over is pressed.
	{
	    if(isset($_POST[self::$BacktoStart]))
	    {
	        unset($_SESSION["board"]);
            $_SESSION["totalmoves"] = 0;	        
	        return true;
	    }
	    return false;
	}
    
    public function GetMovesMade() //Returns total moves made to the controller to send to model for validation.
    {
        return $_SESSION["totalmoves"];
    }

}