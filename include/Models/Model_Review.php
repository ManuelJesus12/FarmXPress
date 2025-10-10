<?php
class ReviewModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Ver lista de reseñas de un producto
     * Params: $pId (ID del producto), $offset (paginación)
     * Return: Página de lista de reseñas.
     */
    public function listReview(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM RESEÑAS R JOIN USUARIOS U ON R.USUARIO_ID=U.USUARIO_ID WHERE PRODUCTO_ID=? ORDER BY FECHA_HORA");
            $sql->bindValue(1, $pId, PDO::PARAM_INT);
            $sql->execute();
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar una reseña por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con las reseñas encontradas, 0 si no hay reseñas, -1 en caso de error
     */
    public function selectReview(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM RESEÑAS WHERE USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE NOMBRE=?) AND PRODUCTO_ID=?");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->bindValue(2, $pId, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC)[0];
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una nueva reseña
     * Params: $data (datos de la reseña)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertReview(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO RESEÑAS (Comentario, Calificación, Fecha_Hora, Producto_ID, Usuario_ID) VALUES (?, ?, ?, ?, (SELECT USUARIO_ID FROM USuARIOS WHERE NOMBRE=?))");
            $sql->bindValue(1, $_POST["res"]);
            $sql->bindValue(2, $_COOKIE["data-rev"]);
            $sql->bindValue(3, date("Y-m-d H:i:s"));
            $sql->bindValue(4, $_POST["pId"]);
            $sql->bindValue(5, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->execute();

            setcookie("data-rev", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar una reseña existente
     * Params: $data (datos de la reseña)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateReview(&$data){
        try{
            $sql=$this->db->prepare("UPDATE RESEÑAS SET Nombre=?, Descripción=? WHERE RESEÑA_ID=?");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            setcookie("data-rev", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar una reseña por ID
     * Params: $id (ID de la reseña)
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteReview(&$id){
        try{
            $sql=$this->db->prepare("DELETE FROM RESEÑAS WHERE RESEÑA_ID=?");
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