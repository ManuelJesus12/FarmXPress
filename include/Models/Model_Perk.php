<?php
class PerkModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Recuperar ventajas de una suscripción
     * Params: $id (ID de la suscripción)
     * Return: Array con las ventajas, 0 si no hay ventajas, -1 en caso de error
     */
    public function listPerk(&$id){
        try{
            $sql=$this->db->prepare("SELECT * FROM VENTAJAS WHERE SUSCRIPCIÓN_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar una ventaja por su ID
     * Params: $id (ID de la ventaja)
     * Return: Array con los datos de la ventaja, -1 en caso de error
     */
    public function selectPerk($id){
        try{
            $sql=$this->db->prepare("SELECT * FROM VENTAJAS WHERE VENTAJA_ID=?");
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

    /* Función: Insertar una ventaja
     * Params: Recibe la cookie "data-perk"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertPerk(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO VENTAJAS (Nombre, Descripción, Suscripción_ID) VALUES (?, ?, ?)");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            setcookie("data-perk", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una ventaja
     * Params: Recibe la cookie "data-perk"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function updatePerk(&$data){
        try{
            $sql=$this->db->prepare("UPDATE VENTAJAS SET Nombre=?, Descripción=? WHERE VENTAJA_ID=?");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            setcookie("data-perk", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una ventaja
     * Params: $id (ID de la ventaja)
     * Return: 1 si se ha eliminado correctamente, -1 en caso de error
     */
    public function deletePerk(&$id){
        try{
            $sql=$this->db->prepare("DELETE FROM VENTAJAS WHERE VENTAJA_ID=?");
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