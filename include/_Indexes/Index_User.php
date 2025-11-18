<?php
global $PDOConnect, $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_User.php';
require_once $dir.'Controllers/Controller_User.php';

// INITIALIZE MODEL AND CONTROLLER
$userModel = new UserModel($PDOConnect);
$userController = new UserController($userModel);

if(isset($_GET['methodUser'])){
    $methods = explode('-', $_GET['methodUser']);

    if(in_array("login", $methods)){
        $message = $userController -> loginUser($_POST['name'], $_POST['password']);
        if($message == 1) header("Location: ../index.php?action=1"); 
        else header("Location: principal.php?methodUser=viewLogin&login=false");
    }
    if(in_array("logout", $methods)){
        $message = $userController -> logoutUser();
        header("Location: ../index.php?action=0");
    }
    // CONTROLLER FUNCTION HANDLING
    if($PDOConnect!=false && isset($_SESSION["User"])){
        /*--------------------------------------------------------------------------*/
        if(in_array("insert", $methods))
            $message = $userController -> insertUser();
        if(in_array("update", $methods))
            $message = $userController -> updateUser();
        if(in_array("delete", $methods))
            $message = $userController -> deleteUser($_POST["deleteId"]);
        if(in_array("active", $methods))
            $message = $userController -> activeUser($_POST['userId'], $_POST['userBool']);
        if(in_array("validate", $methods))
            $message = $userController -> validateUser();
        /*--------------------------------------------------------------------------*/

        // INITIALIZE VIEW
        /*--------------------------------------------------------------------------*/
        else if(in_array("viewUpdate", $methods))
            $message = $userController -> viewUserForm();
        else if(in_array("viewProfile", $methods))
            $message = $userController -> viewProfile();
        else if(in_array("select", $methods)){
            $message = $userController -> viewListUser();
        }
        /*--------------------------------------------------------------------------*/
    }

     // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("viewRegister", $methods))
            $message = $userController -> viewUserForm();
    if(in_array("viewLogin", $methods))
        $message = $userController -> viewLogin();
    /*--------------------------------------------------------------------------*/
}
?>