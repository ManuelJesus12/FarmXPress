<?php
if(!isset($c)) $c=PDOConnect($c);

if(dirChangeProgram()==1) $dir=""; else $dir="include/";
require_once $dir.'Models/Model_Visit.php';
require_once $dir.'Controllers/Controller_Visit.php';

// INITIALIZE MODEL AND CONTROLLER
$visitModel = new VisitModel($c);
$visitController = new VisitController($visitModel);

// CONTROLLER FUNCTION HANDLING
$visitController->insertVisit();

// INITIALIZE VIEW

?>