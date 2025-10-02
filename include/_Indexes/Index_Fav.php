<?php
if(!isset($c)) $c=PDOConnect($c);

global $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Fav.php';
require_once $dir.'Controllers/Controller_Fav.php';

// INITIALIZE MODEL AND CONTROLLER
$favModel = new FavModel($c);
$favController = new FavController($favModel);

if(isset($_GET['methodFav'])){
    $methods = explode('-', $_GET['methodFav']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("toggleFav", $methods))
        $message = $favController -> toggleFav($_POST['prodId'], $_POST['action']);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("select", $methods)){
        if(!isset($_GET['page']))
            header("Location: principal.php?methodFav=select&page=1");
        else{ 
            $offset=$_GET['page'];
            $favController -> viewListFav($offset);
        }
    }
    /*--------------------------------------------------------------------------*/
}
?>