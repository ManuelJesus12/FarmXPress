<?php
class SubModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Funcion: Ver lista de Suscripciones
     * Params: void
     * Return: Página de lista de Suscripciones.
     */
    public function listSub(){
        try{
            $sql=$this->db->prepare("SELECT * FROM Suscripciones");
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Seleccionar una suscripcion por ID
     * Params: $id (ID de la suscripcion)
     * Return: Array con la suscripcion encontrada, 0 si no hay Suscripciones, -1 en caso de error
     */
    public function selectSub($id){
        try{
            $sql=$this->db->prepare("SELECT * FROM Suscripciones WHERE Suscripcion_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC)[0];
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Funcion: Insertar una nueva suscripcion
     * Params: $data (datos de la suscripcion)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertSub(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO Suscripciones (Nombre, Precio_Mensual, Duracion_Base) VALUES (?, ?, ?)");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Actualizar una suscripcion existente
     * Params: $id (ID de la suscripcion), $data (datos de la suscripcion)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateSub(&$id, &$data){
        try{
            $sql=$this->db->prepare("UPDATE Suscripciones SET Nombre=?, Precio_Mensual=?, Duracion_Base=? WHERE Suscripcion_ID=?");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->bindValue(4, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e){
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Eliminar una suscripcion
     * Params: $id (ID de la suscripcion)
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteSub($id){
        try{
            $sql=$this->db->prepare("DELETE FROM Suscripciones WHERE Suscripcion_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>