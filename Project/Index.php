<?php
session_start();
require_once('Controller/Mastercontroller.php');
$mc = new Mastercontroller;
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$mc->Startapplication();
