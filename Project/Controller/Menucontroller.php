<?php
class Menucontroller
{
    public function __construct(Menuview $_View,Gamecontroller $_GameC)
    {
        $this->View = $_View;
        $this->GameC = $_GameC;
    }
    
    public function Init()
    {
        if($this->View->ChoosegamemodeFT3())
        {
            header("location:Index.php?Game3x3");
            $this->GameC->Choose3x3Game();
        }
        
        if($this->View->ChoosegamemodeFT5())
        {
            header("location:Index.php?Game5x5");
            $this->GameC->Choose5x5Game();
        }
        return $this->View;
    }
}