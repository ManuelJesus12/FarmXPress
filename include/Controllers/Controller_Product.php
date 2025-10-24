<?php
class ProductController {
    private $productModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($productModel) {
        $this->productModel = $productModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Recuperar productos de un usuario o cliente
     * Params: $offset (paginación)
     * Return: Vista de lista de productos según el tipo de usuario
     */
    public function viewListProduct(&$offset=0){
        $tipo = (!isset($_COOKIE["UserType"])) ? "C" : $_COOKIE["UserType"];

        if($tipo=="P"){
            $productControl=$this->productModel->listProductP($_SESSION["usuario"]);
            include("Views/View_List_Prod.php");
        }else{
            $productControl=$this->productModel->listProductC($offset);
            include("Views/Client_List_Prod.php");
        }
    }

    ///////////////////////////////////////////////////////////////

    public function carouselListProduct(&$offset=0){
        return $this->productModel->listProductC($offset);
    }
    
    public function listProductP(&$value, &$field = "Usuario_ID"){
        return $this->productModel->listProductP($value, $field);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Mostrar página de detalles de un producto
     * Params: $id (ID del producto)
     * Return: Array con los productos, 0 si no hay productos, -1 en caso de error
     */
    public function viewPageProduct(&$id){
        $product=$this->selectProduct($id);
        if(is_array($product)) include("Views/View_User_Product.php");
        else header("Location: principal.php?methodProd=select&page=1&error=1");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un producto por un campo y valor
     * Params: $field (campo a buscar), $value (valor a buscar)
     * Return: Array con los productos encontrados, 0 si no hay productos, -1 en caso de error
     */
    public function selectProduct(&$value, &$field = "Producto_ID"){
        return $this->productModel->selectProduct($value, $field);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un producto
     * Params: No recibe parámetros, los datos se obtienen de la cookie "data-prod"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertProduct(){
        include("../assets/php/vBackEndProduct.php");
        $this->productModel->insertProduct($data);
        header("Location: principal.php?methodProd=select&action=insert");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un producto
     * Params: $id (ID del producto)
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function updateProduct(&$id){
        include("../assets/php/vBackEndProduct.php");
        $this->productModel->updateProduct($id, $data);
        header("Location: principal.php?methodProd=select&action=update");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar un producto
     * Params: $id (ID del producto)
     * Return: Mensaje de éxito o error al eliminar el producto
     */
    public function deleteProduct(&$id){
        return $this->productModel->deleteProduct($id);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Activar o desactivar un producto
     * Params: $id (ID del producto), $active (estado del producto)
     * Return: Mensaje de éxito o error al activar/desactivar el producto
     */
    public function activeProduct(&$id, &$active=0){
        return $this->productModel->activeProduct($id, $active);
    }
    
    public function liberateProduct(&$uId){
        return $this->productModel->liberateProduct($uId);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar el número total de productos
     * Params: No recibe parámetros
     * Return: Número total de productos
     */
    public function countProduct(){
        return $this->productModel->countProduct();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>