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

    /* Función: Ver lista de suscripciones
     * Params: $offset (paginación)
     * Return: Página de lista de suscripciones.
     */
    public function listSub(&$offset=0){
        try{
            $sql=$this->db->prepare("SELECT * FROM SUSCRIPCIONES LIMIT 11 OFFSET ?");
            $sql->bindValue(1, 10*$offset, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar una suscripción por ID
     * Params: $id (ID de la suscripción)
     * Return: Array con la suscripción encontrada, 0 si no hay suscripciones, -1 en caso de error
     */
    public function selectSub($id){
        try{
            $sql=$this->db->prepare("SELECT * FROM SUSCRIPCIONES WHERE SUSCRIPCIÓN_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una nueva suscripción
     * Params: $data (datos de la suscripción)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertSub(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO SUSCRIPCIONES (Nombre, Precio_Mensual, Duración_Base) VALUES (?, ?, ?)");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            setcookie("data-sub", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una suscripción existente
     * Params: $id (ID de la suscripción), $data (datos de la suscripción)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateSub(&$id, &$data){
        try{
            $sql=$this->db->prepare("UPDATE SUSCRIPCIONES SET Nombre=?, Precio_Mensual=?, Duración_Base=? WHERE SUSCRIPCIÓN_ID=?");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->bindValue(4, $id, PDO::PARAM_INT);
            $sql->execute();

            setcookie("data-sub", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una suscripción
     * Params: $id (ID de la suscripción)
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteSub($id){
        try{
            $sql=$this->db->prepare("DELETE FROM SUSCRIPCIONES WHERE SUSCRIPCIÓN_ID=?");
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