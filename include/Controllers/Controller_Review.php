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
    public function viewListReview(&$pId, &$offset){
        $offset2 = $offset-1;
        if($offset2>=0)
            return $this->reviewModel->listReview($pId, $offset2);
        else
            header("Location: principal.php?methodProd=viewProduct&id=".$pId."&page=1");
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
        try{
            if(isset($_COOKIE["data-rev"])) $data=$_COOKIE["data-rev"]; else $data=0;
            $this->reviewModel->insertReview($data);
            header("Location: principal.php?methodProd=viewProduct&id=".$_POST["pId"]."&page=1&success=1");
        }catch(Exception $e){
            return "No se han recibido datos para insertar la ventaja.";
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una reseña existente
     * Params: No recibe parámetros, utiliza datos de la cookie
     * Return: Redirección a la vista del producto
     */
    public function updateReview(){
        if(isset($_COOKIE["data-rev"])){
            $data = json_decode($_COOKIE["data-rev"], true);
            $this->reviewModel->updateReview($data);
            header("Location: principal.php?methodProd=viewProduct&id=".$_POST["pId"]);
        }else
            return "No se han recibido datos para actualizar la ventaja.";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una reseña
     * Params: $id (ID de la reseña)
     * Return: Mensaje de éxito o error
     */
    public function deleteReview(&$id){
        if($this->reviewModel->deleteReview($id)==1)
            return "Ventaja eliminada correctamente";
        else
            return "Error al eliminar la ventaja";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////¡
}
?>