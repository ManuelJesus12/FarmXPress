<?php
class PerkController {
    private $perkModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($perkModel) {
        $this->perkModel = $perkModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Recuperar ventajas de una suscripción
     * Params: $id (ID de la suscripción)
     * Return: Array con las ventajas, 0 si no hay ventajas, -1 en caso de error
     */	
    public function viewListPerk(&$id){
        return $this->perkModel->listPerk($id);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar una ventaja por su ID
     * Params: $id (ID de la ventaja)
     * Return: Array con los datos de la ventaja, -1 en caso de error
     */
    public function selectPerk(&$id){
        return $this->perkModel->selectPerk($id);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una ventaja
     * Params: No recibe parámetros, los datos se obtienen de la cookie "data-perk"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertPerk(){
        include("../assets/php/vBackEndCatPerk.php");
        $this->perkModel->insertPerk($data);
        header("Location: principal.php?methodSub=select");
        
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una ventaja
     * Params: No recibe parámetros, los datos se obtienen de la cookie "data-perk"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function updatePerk(){
        include("../assets/php/vBackEndCatPerk.php");
        $this->perkModel->updatePerk($data);
        header("Location: principal.php?methodSub=select");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una ventaja
     * Params: $id (ID de la ventaja)
     * Return: Mensaje de éxito o error
     */
    public function deletePerk(&$id){
        if($this->perkModel->deletePerk($id)==1) return "Ventaja eliminada correctamente";
        else return "Error al eliminar la ventaja";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////¡
}
?>