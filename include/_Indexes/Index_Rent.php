<?php
global $PDOConnect, $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Rent.php';
require_once $dir.'Controllers/Controller_Rent.php';


// INITIALIZE MODEL AND CONTROLLER
$rentModel = new RentModel($PDOConnect);
$rentController = new RentController($rentModel);

if(isset($_GET['methodRent'])){
    $methods = explode('-', $_GET['methodRent']);
    // CONTROLLER FUNCTION 
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods)){
        if(isset($_COOKIE["data-rent"])){
            $data = json_decode($_COOKIE["data-rent"], true);
            $message = $rentController -> insertRent($data["pId"], $data["month"], $data["price"]);
        }else
            header("Location: principal.php?methodProd=viewProduct&id=".$pId."&page=1&success=0");
    }
    
    if(in_array("update", $methods))
        $message = $rentController -> updateRent($_GET['Rent']);
    if(in_array("active", $methods))
        $message = $rentController -> activeRent($_POST["rId"], $_POST["pId"]);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("select", $methods)){
        $message = $rentController -> viewListRent();
    }
    if(in_array("viewStripe", $methods)){
        $message = $rentController -> viewStripe();
    }
    /*--------------------------------------------------------------------------*/

}
?>