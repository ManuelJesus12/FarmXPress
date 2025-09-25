<?php
class FavController {
    private $favModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($favModel) {
        $this->favModel = $favModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar Productos Favoritos
     * Params: $offset (para paginación)
     * Return: 1 si se muestra la vista de favoritos, o un array de productos favoritos si se solicita
     */
    public function viewListFav(&$offset){
        $offset--;

        if($offset>=0){
            $productControl=$this->favModel->viewListFav($offset);
            include("Views/Client_Fav_Prod.php");
            return 1;
        }else
            header("Location: principal.php?methodFav=select&page=1");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar Producto Favorito específico
     * Params: id del producto a seleccionar
     * Return: Datos del producto favorito seleccionado
     */
    public function selectFav(&$id){
        return $this->favModel->selectFav($id);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar Producto en Favoritos o eliminarlo
     * Params: $pId (ID del producto), $action (insertar o eliminar)
     * Return: Mensaje de éxito o error al añadir el producto a favoritos
     */
    public function toggleFav(&$pId, &$action){
        if($this->favModel->toggleFav($pId, $action)==1)
            return "Producto añadido a favoritos correctamente";
        else
            return "Error al añadir el Producto a favoritos";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

}
?>