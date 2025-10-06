<?php
global $PDOConnect, $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Visit.php';
require_once $dir.'Controllers/Controller_Visit.php';

// INITIALIZE MODEL AND CONTROLLER
$visitModel = new VisitModel($PDOConnect);
$visitController = new VisitController($visitModel);

// CONTROLLER FUNCTION HANDLING

// INITIALIZE VIEW

?>