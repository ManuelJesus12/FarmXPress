<?php
class MemberModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar Membresías
     * Params: Ninguno
     * Return: Array de membresías o 0 si no hay resultados, -1 en caso de error
     */
    public function listMember(){
        try{
            $sql=$this->db->prepare("SELECT * FROM MEMBRESÍAS");
            $sql->execute();
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            else
                return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar Membresía activa del usuario
     * Params: Ninguno
     * Return: Datos de la membresía seleccionada o -1 en caso de error
     */
    public function selectMember(){
        try{
            $sql=$this->db->prepare("SELECT * FROM MEMBRESÍAS M JOIN SUSCRIPCIONES S ON S.Suscripción_ID=M.Suscripción_ID WHERE USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?) AND ESTADO=1");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->execute();

            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            else
                return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar Membresía
     * Params: $id (ID de la suscripción)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */

    public function insertMember(&$id){
        try{
            include("_Indexes/Index_Sub.php");
            $sql=$this->db->prepare("INSERT INTO MEMBRESÍAS (USUARIO_ID, SUSCRIPCIÓN_ID, FECHA_INICIO, FECHA_FIN, ESTADO) VALUES ((SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?), ?, ?, ?, ?)");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->bindValue(2, $id, PDO::PARAM_INT);
            $sql->bindValue(3, date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->bindValue(4, date("Y-m-d H:i:s", strtotime("+".$subController->selectSub($id)[0]['Duración_Base']." months")), PDO::PARAM_STR);
            $sql->bindValue(5, 1, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar Membresía
     * Params: $month (referenciado para actualizar)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */

    public function updateMember(&$month){
        try{
            $sql=$this->db->prepare("UPDATE MEMBRESÍAS SET FECHA_FIN = ADDDATE(FECHA_FIN, INTERVAL ? MONTH) WHERE USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?) AND ESTADO=1");
            $sql->bindValue(1, $month, PDO::PARAM_INT);
            $sql->bindValue(2, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Desactivar Membresía
     * Params: $id (ID de la membresía a desactivar)
     * Return: 1 si se desactiva correctamente, -1 en caso de error
     */

    public function activeMember(&$id){
        try{
            $sql=$this->db->prepare("UPDATE MEMBRESÍAS SET ESTADO=0 WHERE MEMBRESÍA_ID=?");
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

    /* Función: Contar Membresías
     * Params: Ninguno
     * Return: Número total de membresías o 0 si no hay resultados
     */
    public function countMember(){
        try{
            $sql=$this->db->prepare("SELECT COUNT(MEMBRESÍA_ID) AS 'COUNT' FROM MEMBRESÍAS");
            $sql->execute();
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT'];
            else return 0;
        }catch(PDOException $e) {
            return 0;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>