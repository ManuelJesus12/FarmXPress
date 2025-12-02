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

    /* Funcion: Recuperar Ventajas de una suscripcion
     * Params: $id (ID de la suscripcion)
     * Return: Array con las Ventajas, 0 si no hay Ventajas, -1 en caso de error
     */
    public function listPerk(&$id){
        try{
            $sql=$this->db->prepare("SELECT * FROM Ventajas WHERE Suscripcion_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Seleccionar una ventaja por su ID
     * Params: $id (ID de la ventaja)
     * Return: Array con los datos de la ventaja, -1 en caso de error
     */
    public function selectPerk($id){
        try{
            $sql=$this->db->prepare("SELECT * FROM Ventajas WHERE Ventaja_ID=?");
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

    /* Funcion: Insertar una ventaja
     * Params: Array con los datos de la ventaja
     * Return: Redireccion a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertPerk(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO Ventajas (Nombre, Descripcion, Suscripcion_ID) VALUES (?, ?, ?)");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Actualizar una ventaja
     * Params: Array con los datos de la ventaja
     * Return: Redireccion a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function updatePerk(&$data){
        try{
            $sql=$this->db->prepare("UPDATE Ventajas SET Nombre=?, Descripcion=? WHERE Ventaja_ID=?");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Eliminar una ventaja
     * Params: $id (ID de la ventaja)
     * Return: 1 si se ha eliminado correctamente, -1 en caso de error
     */
    public function deletePerk(&$id){
        try{
            $sql=$this->db->prepare("DELETE FROM Ventajas WHERE Ventaja_ID=?");
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