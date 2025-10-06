<?php
global $PDOConnect, $dirLocation;
$dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
require_once $dir.'Models/Model_Product.php';
require_once $dir.'Controllers/Controller_Product.php';

// INITIALIZE MODEL AND CONTROLLER
$productModel = new ProductModel($PDOConnect);
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
        $result = $productController->uploadImage($_POST['prodId'], $_FILES['imagen']);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
    /*--------------------------------------------------------------------------*/
    if(in_array("select", $methods)){
        if(isset($_GET['page']) && $_GET['page']>0){
            $offset = $_GET['page']-1;
            $productController -> viewListProduct($offset);
        }else header("Location: principal.php?methodProd=select&page=1");
    }
    /*--------------------------------------------------------------------------*/

    /*--------------------------------------------------------------------------*/
    if(in_array("viewProduct", $methods)){
        if(isset($_GET['id'])) $message = $productController -> viewPageProduct($_GET['id']);
        else header("Location: principal.php?methodProd=select");
    }
    /*--------------------------------------------------------------------------*/
}
?>