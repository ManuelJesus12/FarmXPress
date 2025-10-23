<?php
class ReviewController {
    private $reviewModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($reviewModel) {
        $this->reviewModel = $reviewModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Ver lista de reseñas de un producto
     * Params: $pId (ID del producto), $offset (paginación)
     * Return: Página de lista de reseñas.
     */
    public function viewListReview(&$pId){ 
        return $this->reviewModel->listReview($pId);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar una reseña por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con las reseñas encontradas, 0 si no hay reseñas, -1 en caso de error
     */
    public function selectReview(&$pId){
        return $this->reviewModel->selectReview($pId);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una nueva reseña
     * Params: $data (datos de la reseña)
     * Return: Redirección a la vista del producto
     */
    public function insertReview(){
        include("../assets/php/validateBackEnd.php");
        $this->reviewModel->insertReview($data);
        header("Location: principal.php?methodProd=viewProduct&id=".$_POST["pId"]."&success=1");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una reseña existente
     * Params: No recibe parámetros, utiliza datos de la cookie
     * Return: Redirección a la vista del producto
     */
    public function updateReview(){
        include("../assets/php/validateBackEnd.php");
        $this->reviewModel->updateReview($data);
        header("Location: principal.php?methodProd=viewProduct&id=".$_POST["pId"]);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una reseña
     * Params: $id (ID de la reseña)
     * Return: Mensaje de éxito o error
     */
    public function deleteReview(&$id){
        if($this->reviewModel->deleteReview($id)==1) return "Ventaja eliminada correctamente";
        else return "Error al eliminar la ventaja";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////¡
}
?>