<?php
class CategoryController {
    private $categoryModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($categoryModel) {
        $this->categoryModel = $categoryModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar Categorías
     * Params: $opt (opción de visualización)
     * Return: 1 si se muestra la vista, o un array de categorías si $opt es 1
     */
    public function viewListCategory(&$opt=0){
        $categoryControl=$this->categoryModel->listCategory();
        if($opt!=1){
            if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR") include("Views/View_List_Cat.php");
            else echo "<h2>Acceso a esta sección denegado</h2>";
        }else
            return $categoryControl;
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar Categoría específica
     * Params: id de la categoría a seleccionar
     * Return: Datos de la categoría seleccionada
     */
    public function selectCategory(&$id){
        return $this->categoryModel->selectCategory($id);
    }
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar Categoría
     * Params: Ninguno (los datos se obtienen de una cookie)
     * Return: Redirige a la vista de categorías después de insertar
     */
    public function insertCategory(){
        if(isset($_COOKIE["data-cat"])){
            $data = json_decode($_COOKIE["data-cat"], true);
            if($this->categoryModel->insertCategory($data)==1) setcookie("data-cat", "", time() - 3600, "/");
            header("Location: principal.php?methodCat=select&action=insert");
        }else
            return "No se han recibido datos para insertar la categoría.";
    }

    ///////////////////////////////////////////////////////////////
    
    /* Función: Actualizar Categoría
     * Params: id de la categoría a actualizar (referenciado)
     * Return: Redirige a la vista de categorías después de actualizar
     */
    public function updateCategory(&$id){
        if(isset($_COOKIE["data-cat"])){
            $data = json_decode($_COOKIE["data-cat"], true);
            $this->categoryModel->updateCategory($id, $data);
            header("Location: principal.php?methodCat=select&action=update");
        }else
            return "No se han recibido datos para actualizar la categoría.";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar Categoría
     * Params: id de la categoría a eliminar (referenciado)
     * Return: Mensaje de éxito o error al eliminar la categoría
     */
    public function deleteCategory(&$id){
        if($this->categoryModel->deleteCategory($id)==1)
            return "Categoría eliminada correctamente";
        else
            return "Error al eliminar la categoría";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

}
?>