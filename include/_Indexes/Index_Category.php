<?php
global $PDOConnect, $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Category.php';
require_once $dir.'Controllers/Controller_Category.php';

// INITIALIZE MODEL AND CONTROLLER
$categoryModel = new CategoryModel($PDOConnect);
$categoryController = new CategoryController($categoryModel);

if(isset($_GET['methodCat'])){
    $methods = explode('-', $_GET['methodCat']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods))
        $message = $categoryController -> insertCategory();
    if(in_array("update", $methods))
        $message = $categoryController -> updateCategory($_GET['cat']);
    if(in_array("delete", $methods))
        $message = $categoryController -> deleteCategory($_POST['deleteId']);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("select", $methods)){
        if(!isset($_GET['page']))
            header("Location: principal.php?methodCat=select&page=1");
        else{
            $opt=0; $offset=$_GET['page'];
            $categoryController -> viewListCategory($offset, $opt);
        }
    }
    /*--------------------------------------------------------------------------*/

}
?>