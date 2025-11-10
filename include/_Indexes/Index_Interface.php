<?php
session_start();
$dir=($url==0) ? 'include/' : '';
require_once $dir.'Controllers/Controller_Interface.php';

$interfaceController = new CategoryController();
$PDOConnect  = $interfaceController->PDOConnect();
$dirLocation = $interfaceController->dirChangeProgram();
?>