<?php
class RentModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Ver lista de alquileres de un usuario
     * Params: $offset (paginación)
     * Return: Página de lista de alquileres.
     */
    public function listRent(&$offset){
        try{
            $query="SELECT *, P.PRODUCTO_ID AS 'PID' FROM ALQUILERES A JOIN PRODUCTOS P ON A.PRODUCTO_ID=P.PRODUCTO_ID WHERE A.USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?) AND A.ESTADO=1";
            if($offset!=-1) $query.=" LIMIT 11 OFFSET ?";

            $sql=$this->db->prepare($query);
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            if($offset!=-1)$sql->bindValue(2, 10*$offset, PDO::PARAM_INT);
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

    /* Función: Seleccionar un alquiler por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con los alquileres encontrados, 0 si no hay alquileres, -1 en caso de error
     */
    public function selectRent(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM ALQUILERES WHERE USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?) AND PRODUCTO_ID=? AND ESTADO=1");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->bindValue(2, $pId, PDO::PARAM_INT);
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

    /* Función: Seleccionar el último alquiler realizado
     * Params: Void
     * Return: Array con el último alquiler, 0 si no hay alquileres, -1 en caso de error
     */
    public function selectLastRent(){
        try{
            $sql=$this->db->prepare("SELECT * FROM ALQUILERES A JOIN PRODUCTOS P ON A.PRODUCTO_ID=P.PRODUCTO_ID WHERE ALQUILER_ID=?");
            $sql->bindValue(1, $this->db->lastInsertId(), PDO::PARAM_INT);
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

    /* Función: Insertar un nuevo alquiler
     * Params: $id (ID del producto), $month (meses de alquiler), $price (precio del alquiler)
     * Return: 1 o -1 en caso de error
     */
    public function insertRent(&$id, &$month, &$price){
        try{
            $sql=$this->db->prepare("INSERT INTO ALQUILERES (USUARIO_ID, PRODUCTO_ID, FECHA_INICIO, FECHA_FIN, ESTADO, PRECIO_TOTAL) VALUES ((SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?), ?, ?, ?, ?, ?)");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->bindValue(2, $id, PDO::PARAM_INT);
            $sql->bindValue(3, date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->bindValue(4, date("Y-m-d H:i:s", strtotime("+".$month." months")), PDO::PARAM_STR);
            $sql->bindValue(5, 1, PDO::PARAM_INT);
            $sql->bindValue(6, $price*$month, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un alquiler
     * Params: $month (meses de alquiler), $mPrice (precio del alquiler), $rId (ID del alquiler)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateRent(&$month, &$mPrice, &$rId){
        try{
            $sql=$this->db->prepare("UPDATE ALQUILERES SET FECHA_FIN = ADDDATE(FECHA_FIN, INTERVAL ? MONTH), PRECIO_TOTAL=PRECIO_TOTAL + ? WHERE ALQUILER_ID=?");
            $sql->bindValue(1, $month, PDO::PARAM_INT);
            $sql->bindValue(2, $month*$mPrice, PDO::PARAM_INT);
            $sql->bindValue(3, $rId, PDO::PARAM_INT);
            $sql->execute();
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Desactivar un alquiler
     * Params: $rId (ID del alquiler)
     * Return: 1 si se activa correctamente, -1 en caso de error
     */
    public function activeRent(&$rId){
        try{
            $date=date("Y-m-d H:i:s");

            $sql=$this->db->prepare("UPDATE ALQUILERES SET ESTADO=?, FECHA_FIN=? WHERE ALQUILER_ID=?");
            $sql->bindValue(1, 0, PDO::PARAM_INT);
            $sql->bindValue(2, $date, PDO::PARAM_STR);
            $sql->bindValue(3, $rId, PDO::PARAM_INT);
            $sql->execute();
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar el número de alquileres
     * Params: Void
     * Return: Número de alquileres, 0 si no hay alquileres, -1 en caso de error
     */
    public function countRent(){
        try{
            $sql=$this->db->prepare("SELECT COUNT(ALQUILER_ID) AS 'COUNT' FROM ALQUILERES");
            $sql->execute();
            
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT'];
            else
                return 0;
        }catch(PDOException $e) {
            return 0;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>