<?php
if(!isset($c)) $c=PDOConnect($c);

if(isset($dirChangeVar) && $dirChangeVar==1) $dir="../"; 
else if(dirChangeProgram()==0) $dir="include/"; else $dir="";
require_once $dir.'Models/Model_User.php';
require_once $dir.'Controllers/Controller_User.php';

// INITIALIZE MODEL AND CONTROLLER
$userModel = new UserModel($c);
$userController = new UserController($userModel);

if(isset($_GET['methodUser'])){
    $methods = explode('-', $_GET['methodUser']);

    if(in_array("insert", $methods))
        $message = $userController -> insertUser();
    if(in_array("uploadAvatar", $methods))
        $result = $userController->uploadAvatar($_POST['userId'], $_FILES["avatar"]);

    // CONTROLLER FUNCTION HANDLING
    if($c!=false && isset($_SESSION["usuario"])){
        /*--------------------------------------------------------------------------*/
        if(in_array("update", $methods))
            $message = $userController -> updateUser();
        if(in_array("delete", $methods))
            $message = $userController -> deleteUser($_POST["deleteId"]);
        if(in_array("active", $methods))
            $message = $userController -> activeUser($_POST['userId'], $_POST['userBool']);
        /*--------------------------------------------------------------------------*/

        // INITIALIZE VIEW
        /*--------------------------------------------------------------------------*/
        else if(in_array("viewUpdate", $methods))
            $message = $userController -> viewUpdate();
        else if(in_array("select", $methods)){
            if(!isset($_GET['page']))
                header("Location: principal.php?methodUser=select&page=1");
            else{
                $offset=$_GET['page']; 
                $userController -> viewListUser($offset);
            }
        }
        /*--------------------------------------------------------------------------*/
    }
    /*--------------------------------------------------------------------------*/
    if(in_array("login", $methods)){
        $message = $userController -> loginUser($_POST['name'], $_POST['password']);
        if($message == 1) header("Location: ../index.php?action=1"); 
        else header("Location: principal.php?methodUser=viewLogin&login=false");
    }
    if(in_array("logout", $methods)){
        $message = $userController -> logoutUser();
        header("Location: ../index.php?action=0");
    }
    /*--------------------------------------------------------------------------*/

     // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("viewRegister", $methods))
            $message = $userController -> viewRegister();
    if(in_array("viewLogin", $methods))
        $message = $userController -> viewLogin();
    /*--------------------------------------------------------------------------*/
}
?>