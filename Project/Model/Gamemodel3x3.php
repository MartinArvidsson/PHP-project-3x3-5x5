<?php
class GameModel3x3
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
    	if($this->totalMoves >= 9)
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
		 for ($i = 0; $i < 3; $i++)
		     if ($board[$i][0] && $board[$i][0] == $board[$i][1] && $board[$i][1] == $board[$i][2])
		         $this->boardtoreturn->winner = $board[$i][0];
		
		//Columns
		for ($i = 0; $i < 3; $i++)
		    if ($board[0][$i] && $board[0][$i] == $board[1][$i] && $board[1][$i] == $board[2][$i])
		        $this->boardtoreturn->winner = $board[0][$i];

		 // //Diagonally
		 if ($board[0][2] && $board[0][2] == $board[1][1] && $board[1][1] == $board[2][0] ||
		 	 $board[0][0] && $board[0][0] == $board[1][1] && $board[1][1] == $board[2][2])
		 	 $this->boardtoreturn->winner = $board[1][1];
		 	 
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
					$_SESSION["PlayerXwinsFT3"] ++;
						
					if(!isset($_SESSION["FT3Winner"]))
					{
						$_SESSION["FT3Winner"] = "";
					}
						if($_SESSION["PlayerXwinsFT3"] == 3)
						{
							//Spelare X vann FT3 Skicka till Menumodel så det kan presentera datan
							$_SESSION["FT3Winner"] = $Winner;
							$this->gamemessage = "Player \"$Winner\" you won the game!";
							$this->DAL->IncreasePlayerXScoreFT3();
			                $_SESSION["PlayerXwinsFT3"] = 0;
			                $_SESSION["PlayerOwinsFT3"] = 0;
						}
					return $this->gamemessage;
				}
				else
				{
					$_SESSION["PlayerOwinsFT3"] ++;
					if(!isset($_SESSION["FT3Winner"]))
					{
						$_SESSION["FT3Winner"] = "";
					}					
						if($_SESSION["PlayerOwinsFT3"] == 3)
						{
							//Spelare O vann FT3 Skicka till Menumodel så det kan presentera datan
	
							$_SESSION["FT3Winner"] = $Winner;
							$this->gamemessage = "Player \"$Winner\" you won the game!";
							$this->DAL->IncreasePlayerOScoreFT3();
			                $_SESSION["PlayerXwinsFT3"] = 0;
			                $_SESSION["PlayerOwinsFT3"] = 0;							
						}
					return $this->gamemessage;
				}
			return $this->gamemessage; //Vem som vann.
		}
		return $this->gamemessage; //Tom sträng då kraven inte uppfylldes
	}
	
	public function CheckforFT3Winner()
	{
		if(!isset($_SESSION["FT3Winner"]))
		{
			$_SESSION["FT3Winner"] = "";
		}
		return $_SESSION["FT3Winner"];
	}
	public function currentXwinsFT3()
	{
		if(!isset($_SESSION["PlayerXwinsFT3"]))
		{
			$_SESSION["PlayerXwinsFT3"] = 0;
		}
		return $_SESSION["PlayerXwinsFT3"];
	}
	
	public function currentOwinsFT3()
	{
		if(!isset($_SESSION["PlayerOwinsFT3"]))
		{
			$_SESSION["PlayerOwinsFT3"] = 0;
		}
		return $_SESSION["PlayerOwinsFT3"];
	}
	
	public function PlayerCanceledGame()
	{
		$_SESSION["PlayerOwinsFT3"] = 0;
		$_SESSION["PlayerXwinsFT3"] = 0;
	}
}