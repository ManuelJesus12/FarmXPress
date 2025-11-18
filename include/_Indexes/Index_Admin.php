<?php
global $PDOConnect, $dirLocation;
require_once 'Models/Model_Admin.php';
require_once 'Controllers/Controller_Admin.php';

// INITIALIZE MODEL AND CONTROLLER
$adminModel = new AdminModel($PDOConnect);
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
    if(in_array("store", $methods))  
        $message = $adminController -> storeLog();
    if(in_array("print", $methods))  
        $message = $adminController -> printLog();
    if(in_array("select", $methods))  
        $message = $adminController -> listLog($_GET['type']);
    /*--------------------------------------------------------------------------*/

    if($PDOConnect!=false && isset($_SESSION["User"])){
        // INITIALIZE VIEW
        /*--------------------------------------------------------------------------*/
        if(in_array("newLog", $methods)  || in_array("viewLog", $methods))
            $message = $adminController -> viewLogMenu();
        /*--------------------------------------------------------------------------*/
    }
}
?>