<?php
if(!isset($c)) $c=PDOConnect($c);

if(isset($dirChangeVar) && $dirChangeVar==1) $dir="../"; 
else if(dirChangeProgram()==0) $dir="include/"; else $dir="";
require_once $dir.'Models/Model_Product.php';
require_once $dir.'Controllers/Controller_Product.php';


// INITIALIZE MODEL AND CONTROLLER
$productModel = new ProductModel($c);
$productController = new ProductController($productModel);

if(isset($_GET['methodProd'])){
    $methods = explode('-', $_GET['methodProd']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods))
        $message = $productController -> insertProduct();
    if(in_array("update", $methods))
        $message = $productController -> updateProduct($_GET['prod']);
    if(in_array("delete", $methods))
        $message = $productController -> deleteProduct($_POST['deleteId']);
    
    if(in_array("uploadImage", $methods))
        $result = $productController->uploadImage($_POST['prodId'], $_FILES["imagen"]);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("select", $methods)){
        if(!isset($_GET['page']))
            header("Location: principal.php?methodProd=select&page=1");
        else{
            $offset=$_GET['page'];
            $productController -> viewListProduct($offset);
        }
    }
    /*--------------------------------------------------------------------------*/

    /*--------------------------------------------------------------------------*/
    if(in_array("viewProduct", $methods)){
        if(!isset($_GET['id']))
            header("Location: principal.php?methodProd=select&page=1");
        else if(!isset($_GET['page']))
            header("Location: principal.php?methodProd=viewProduct&id=".$_GET['id']."&page=1");
        else
            $message = $productController -> viewPageProduct($_GET['id']);
    }
    /*--------------------------------------------------------------------------*/
}
?>