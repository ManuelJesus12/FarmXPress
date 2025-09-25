<?php
if(!isset($c)) $c=PDOConnect($c);

require_once 'Models/Model_Admin.php';
require_once 'Controllers/Controller_Admin.php';

// INITIALIZE MODEL AND CONTROLLER
$adminModel = new AdminModel($c);
$adminController = new AdminController($adminModel);

if(isset($_GET['methodAdmin'])){
    $methods = explode('-', $_GET['methodAdmin']);
    
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("CreateBD", $methods))
        $message = $adminController -> CreateDB();
    if(in_array("DeleteBD", $methods))  
        $message = $adminController -> DeleteDB();
    if(in_array("DataUpload", $methods))  
        $message = $adminController -> DataUpload();
    /*--------------------------------------------------------------------------*/

    if($c!=false && isset($_SESSION["usuario"])){
        /*--------------------------------------------------------------------------*/
        if(in_array("select", $methods))  
            $message = $adminController -> listLog($_GET['type']);
        if(in_array("store", $methods))  
            $message = $adminController -> storeLog();
        if(in_array("print", $methods))  
            $message = $adminController -> printLog();
        /*--------------------------------------------------------------------------*/

        // INITIALIZE VIEW
        /*--------------------------------------------------------------------------*/
        if(in_array("newLog", $methods)  || in_array("viewLog", $methods))
            $message = $adminController -> viewLogMenu();
        else  
            echo $message;
        /*--------------------------------------------------------------------------*/
    }else setcookie("error", 1, time()+3600, "/");
}
?>