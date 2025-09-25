<?php
if(!isset($c)) $c=PDOConnect($c);

if(isset($dirChangeVar) && $dirChangeVar==1) $dir="../"; 
else if(dirChangeProgram()==0) $dir="include/"; else $dir="";
require_once $dir.'Models/Model_Rent.php';
require_once $dir.'Controllers/Controller_Rent.php';


// INITIALIZE MODEL AND CONTROLLER
$rentModel = new RentModel($c);
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
        $offset=$_GET['page'];
        $message = $rentController -> viewListRent($offset);
    }
    if(in_array("viewStripe", $methods)){
        $message = $rentController -> viewStripe();
    }
    /*--------------------------------------------------------------------------*/

}
?>