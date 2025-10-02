<?php
if(!isset($c)) $c=PDOConnect($c);

global $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Perk.php';
require_once $dir.'Controllers/Controller_Perk.php';


// INITIALIZE MODEL AND CONTROLLER
$perkModel = new PerkModel($c);
$perkController = new PerkController($perkModel);

if(isset($_GET['methodPerk'])){
    $methods = explode('-', $_GET['methodPerk']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods))
        $message = $perkController -> insertPerk();
    if(in_array("update", $methods))
        $message = $perkController -> updatePerk();
    if(in_array("delete", $methods))
        $message = $perkController -> deletePerk($_POST['deleteId']);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
}
?>