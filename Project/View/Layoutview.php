<?php
class LayoutView 
{
  
  public function render($v,$Currentgame) 
  {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <link href="../Project/Content/Stylesheet.css" rel="stylesheet" type="text/css">
          <title>PhP Project</title>
        </head>
        <body>
          <h1>Luffarschack</h1>
            <h2>'.$Currentgame.'</h2>
          <div class="container">
              ' . $v->response() . '
          </div>
         </body>
      </html>
    ';
  }
}