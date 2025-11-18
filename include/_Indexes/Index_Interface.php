<?php
    session_start();
    $dirAux = $dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
    require_once $dir.'Controllers/Controller_Interface.php';

    $interfaceController = new InterfaceController();
    $PDOConnect  = $interfaceController->PDOConnect();
    $interfaceController->includeVisit();
    $interfaceController->checkRentsActive();
?>