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
    public function viewListProduct(&$offset){
        $tipo = (!isset($_COOKIE["UserType"])) ? "C" : $_COOKIE["UserType"];

        if($tipo=="P"){
            $productControl=$this->productModel->listProductP($offset);
            include("Views/View_List_Prod.php");
        }else{
            $productControl=$this->productModel->listProductC($offset);
            include("Views/Client_List_Prod.php");
        }
    }

    ///////////////////////////////////////////////////////////////

    public function viewListProductCarousel(&$offset){
        return $this->productModel->listProductC($offset);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Mostrar página de detalles de un producto
     * Params: $id (ID del producto)
     * Return: Array con los productos, 0 si no hay productos, -1 en caso de error
     */
    public function viewPageProduct(&$id){
        try{
            $field = "Producto_ID"; $product=$this->selectProduct($field, $id);
            if(is_array($product)) include("Views/View_User_Product.php");
            else header("Location: principal.php?methodProd=select&error=1");

            return 1;
        } catch(Exception $e){
            echo "<h2>Producto no identificado, lo sentimos.</h2>";
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un producto por un campo y valor
     * Params: $field (campo a buscar), $value (valor a buscar)
     * Return: Array con los productos encontrados, 0 si no hay productos, -1 en caso de error
     */
    public function selectProduct(&$field, &$value){
        return $this->productModel->selectProduct($field, $value);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un producto
     * Params: No recibe parámetros, los datos se obtienen de la cookie "data-prod"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertProduct(){
        if(isset($_COOKIE["data-prod"])){
            $data = json_decode($_COOKIE["data-prod"], true);
            if($this->productModel->insertProduct($data)==1){
                setcookie("data-prod", 0, time()-1,"/");
                setcookie("product-image", 0, time()-1,"/");
                header("Location: principal.php?methodProd=select&action=insert");
            }
        }else
            return "No se han recibido datos para insertar el producto.";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un producto
     * Params: $id (ID del producto)
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function updateProduct(&$id){
        if(isset($_COOKIE["data-prod"])){
            $data = json_decode($_COOKIE["data-prod"], true);
            if($this->productModel->updateProduct($id, $data)==1){      
                setcookie("data-prod", 0, time()-1,"/");
                setcookie("product-image", 0, time()-1,"/");
                header("Location: principal.php?methodProd=select&action=update");
            }
        }else
            return "No se han recibido datos para actualizar el producto.";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar un producto
     * Params: $id (ID del producto)
     * Return: Mensaje de éxito o error al eliminar el producto
     */
    public function deleteProduct(&$id){
        if($this->productModel->deleteProduct($id)==1)
            return "Producto eliminado correctamente";
        else
            return "Error al eliminar el Producto";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Activar o desactivar un producto
     * Params: $id (ID del producto), $active (estado del producto)
     * Return: Mensaje de éxito o error al activar/desactivar el producto
     */
    public function activeProduct(&$id, &$active){
        if($this->productModel->activeProduct($id, $active)==1)
            return "Producto activado/desactivado correctamente";
        else
            return "Error al activar/desactivar el Producto";
    }
    
    public function liberateProduct(&$uId){
        return $this->productModel->liberateProduct($uId);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Subir una imagen de producto
     * Params: $id (ID del producto), $file (archivo de imagen)
     * Return: Resultado del procesamiento de la imagen
     */
    public function uploadImage(&$id, &$file){
        return $this->productModel->imageProcess($id, $file);
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