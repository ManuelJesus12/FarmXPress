<?php
if(!isset($c)) $c=PDOConnect($c);

if(isset($dirChangeVar) && $dirChangeVar==1) $dir="../"; else $dir="";
require_once $dir.'Models/Model_Sub.php';
require_once $dir.'Controllers/Controller_Sub.php';


// INITIALIZE MODEL AND CONTROLLER
$subModel = new SubModel($c);
$subController = new SubController($subModel);

if(isset($_GET['methodSub'])){
    $methods = explode('-', $_GET['methodSub']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods))
        $message = $subController -> insertSub();
    if(in_array("update", $methods))
        $message = $subController -> updateSub($_GET['sub']);
    if(in_array("delete", $methods))
        $message = $subController -> deleteSub($_POST['deleteId']);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("select", $methods)){
        if(!isset($_GET['page']))
            header("Location: principal.php?methodSub=select&page=1");
        else{
            $offset=$_GET['page'];
            $subController -> viewListSub($offset);
        }
    }
    /*--------------------------------------------------------------------------*/
}
?>