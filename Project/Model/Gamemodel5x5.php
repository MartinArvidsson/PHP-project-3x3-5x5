<?php
class GameModel5x5
{
    private $gamemessage ="";
    private $board;
    private $boardtoreturn;
    private $totalMoves;
    
    public function __construct(ScoreDAL $dal)
    {
    	$this->DAL = $dal;
    }
    
    public function ValidateData($_board,$_totalMoves)
    {
        $this->board = $_board;
        $this->totalMoves = $_totalMoves;
        $this->boardtoreturn = new stdClass;
        $this->boardtoreturn->winner = null;
        $this->boardtoreturn->boardtoreturn = array(array(),array(),array());
        $this->boardtoreturn = $_board;
        
        $this->Checkforwinner($this->board,$this->totalMoves);
    }
    
    private function CheckMove($totalMoves)
    {
    	if($this->totalMoves >= 25)
    	{
			$this->gamemessage ="Oavgjort";
    	}
    	else
    	{
    		return true;
    	}
    }
	//Checks for winners in the board provided, Checks the multidimensional array positions and look for matching marker 3 in a row
    private function Checkforwinner($board,$totalMoves)
	{
		$board = $this->board->board;
		//Rows	
		 for ($i = 0; $i < 5; $i++)
		     if ($board[$i][0] && $board[$i][0] == $board[$i][1] && $board[$i][1] == $board[$i][2] && $board[$i][2] == $board[$i][3] && $board[$i][3] == $board[$i][4])
		         $this->boardtoreturn->winner = $board[$i][0];
		
		//Columns
		for ($i = 0; $i < 5; $i++)
		    if ($board[0][$i] && $board[0][$i] == $board[1][$i] && $board[1][$i] == $board[2][$i] && $board[2][$i] == $board[3][$i] && $board[3][$i] == $board[4][$i])
		        $this->boardtoreturn->winner = $board[0][$i];

		 // //Diagonally
		 if ($board[0][0] && $board[0][0] == $board[1][1] && $board[1][1] == $board[2][2] && $board[2][2] == $board[3][3] && $board[3][3] == $board[4][4] ||
		 	 $board[0][4] && $board[0][4] == $board[1][3] && $board[1][3] == $board[2][2] && $board[2][2] == $board[3][1] && $board[3][1] == $board[4][0])
		 	 $this->boardtoreturn->winner = $board[2][2];
		 	 
		 $this->CheckMove($this->totalMoves);
	}
	
	//The logic after the board has been checked, Did anyone win? if so who? sets a message to be read by view to see the winner.
	//And then peform actions accordingly. (Different views depending on message etc...)
	public function getwhowonmessage()
	{
		if(isset($this->boardtoreturn->winner) && $this->boardtoreturn->winner != null)
		{
			$Winner = $this->boardtoreturn->winner;
			$this->gamemessage = "Player \"$Winner\" you won this round";
				if($Winner == "X")
				{
					$_SESSION["PlayerXwinsFT5"] ++;
					$this->gamemessage = "Player \"$Winner\" you won this round";
					if(!isset($_SESSION["FT5Winner"]))
					{
						$_SESSION["FT5Winner"] = "";
					}					
						if($_SESSION["PlayerXwinsFT5"] == 5) 
						{
	
							//Spelare X vann FT5 Skicka till Menumodel så det kan presentera datan
							$_SESSION["FT5Winner"] = $Winner;
							$this->gamemessage = "Player \"$Winner\" you won the game!";
							$this->DAL->IncreasePlayerXScoreFT5();
		    	            $_SESSION["PlayerXwinsFT5"] = 0;
			                $_SESSION["PlayerOwinsFT5"] = 0;
						}
					return $this->gamemessage;
				}
				else
				{
					$_SESSION["PlayerOwinsFT5"] ++;
					$this->gamemessage = "Player \"$Winner\" you won this round";
					if(!isset($_SESSION["FT5Winner"]))
					{
						$_SESSION["FT5Winner"] = "";
						
					}
						if($_SESSION["PlayerOwinsFT5"] == 5)
						{
							//Spelare O vann FT5 Skicka till Menumodel så det kan presentera datan
							$_SESSION["FT5Winner"] = $Winner;
							$this->gamemessage = "Player \"$Winner\" you won the game!";
							$this->DAL->IncreasePlayerOScoreFT5 ();
		    	            $_SESSION["PlayerXwinsFT5"] = 0; 
			                $_SESSION["PlayerOwinsFT5"] = 0;
						}
					return $this->gamemessage;
				}
			return $this->gamemessage; //Vem som vann.
		}
		return $this->gamemessage; //Tom sträng då kraven inte uppfylldes
	}
	
	public function CheckforFT5Winner()
	{
		if(!isset($_SESSION["FT5Winner"]))
		{
			$_SESSION["FT5Winner"] = "";
		}
		return $_SESSION["FT5Winner"];
	}
	
	public function currentXwinsFT5()
	{
		if(!isset($_SESSION["PlayerXwinsFT5"]))
		{
			$_SESSION["PlayerXwinsFT5"] = 0;
		}
		return $_SESSION["PlayerXwinsFT5"];
	}
	
	public function currentOwinsFT5()
	{
		if(!isset($_SESSION["PlayerOwinsFT5"]))
		{
			$_SESSION["PlayerOwinsFT5"] = 0;
		}
		return $_SESSION["PlayerOwinsFT5"];
	}
	
	public function PlayerCanceledGame()
	{
		$_SESSION["PlayerOwinsFT5"] = 0;
		$_SESSION["PlayerXwinsFT5"] = 0;
	}
}