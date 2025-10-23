<?php
class SubController {
    private $subModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($subModel) {
        $this->subModel = $subModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Ver lista de subscripciones
     * Params: $offset (paginación)
     * Return: Página de lista de subscripciones.
     */
    public function viewListSub(){
        $subControl=$this->subModel->listSub();

        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR")
            include("Views/View_List_Sub.php");
        else
            include("Views/View_User_Sub.php");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar una subscripción por ID
     * Params: $id (ID de la subscripción)
     * Return: Array con las subscripciones encontradas, 0 si no hay subscripciones, -1 en caso de error
     */
    public function selectsub(&$id){
        return $this->subModel->selectSub($id);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una nueva subscripción
     * Params: No recibe parámetros, utiliza la cookie "data-sub" para obtener los datos
     * Return: Redirección a la lista de subscripciones
     */
    public function insertSub(){
        include("../assets/php/vBackEndSub.php");
        $this->subModel->insertSub($data);
        header("Location: principal.php?methodSub=select&action=insert");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una subscripción existente
     * Params: $id (ID de la subscripción)
     * Return: Redirección a la lista de subscripciones
     */
    public function updateSub(&$id){
        include("../assets/php/vBackEndSub.php");
        $this->subModel->updateSub($id, $data);
        header("Location: principal.php?methodSub=select&action=update");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una subscripción
     * Params: $id (ID de la subscripción)
     * Return: Mensaje de éxito o error
     */
    public function deleteSub(&$id){
        if($this->subModel->deleteSub($id)==1)
            return "Subscripción eliminada correctamente";
        else
            return "Error al eliminar la subscripción";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>