<?php
if(!isset($c)) $c=PDOConnect($c);

global $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Member.php';
require_once $dir.'Controllers/Controller_Member.php';

// INITIALIZE MODEL AND CONTROLLER
$memberModel = new MemberModel($c);
$memberController = new MemberController($memberModel);

if(isset($_GET['methodMember'])){
    $methods = explode('-', $_GET['methodMember']);
    /*--------------------------------------------------------------------------*/
    // CONTROLLER FUNCTION HANDLING
    if(in_array("insert", $methods)){
        $data = json_decode($_COOKIE['data-member'], true);
        $message = $memberController -> insertMember($data['sId']);
    }
    if(in_array("update", $methods))
        $message = $memberController -> updateMember($_POST['months']);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("viewUpdate", $methods)){
        $message = $memberController -> viewUpdateMember();
    }
    if(in_array("viewStripe", $methods)){
        $message = $memberController -> viewStripe();
    }
    /*--------------------------------------------------------------------------*/

}

?>