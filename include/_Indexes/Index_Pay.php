<?php
if(!isset($c)) $c=PDOConnect($c);

global $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Pay.php';
require_once $dir.'Controllers/Controller_Pay.php';


// INITIALIZE MODEL AND CONTROLLER
$payModel = new PayModel($c);
$payController = new PayController($payModel);

if(isset($_GET['methodPay'])){
    $methods = explode('-', $_GET['methodPay']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods)){
        $data = json_decode($_COOKIE["data-pay"], true);
        $message = $payController -> insertPay($data["rId"], $data["mPrice"], $data["month"], $data["amount"]);
    }
    if(in_array("update", $methods))
        $message = $payController -> updatePay($_GET['Pay']);
    if(in_array("active", $methods))
        $message = $payController -> activePay();
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("selectPay", $methods))
        $message = $payController -> selectPay($_GET["rId"]);
    if(in_array("viewPay", $methods))
        $message = $payController -> viewPay();
    if(in_array("viewStripe", $methods)){
        $message = $payController -> viewStripe();
    }
    /*--------------------------------------------------------------------------*/
}
?>