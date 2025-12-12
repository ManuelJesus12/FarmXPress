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

    /* Funcion: Ver lista de Reseñas de un producto
     * Params: $pId (ID del producto), $offset (paginacion)
     * Return: Página de lista de Reseñas.
     */
    public function listReview(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM Reseñas R 
                                JOIN Usuarios U ON R.Usuario_ID=U.Usuario_ID WHERE Producto_ID=? ORDER BY Fecha_Hora DESC");
            $sql->bindValue(1, $pId, PDO::PARAM_INT);
            $sql->execute();
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Seleccionar una reseña por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con las Reseñas encontradas, 0 si no hay Reseñas, -1 en caso de error
     */
    public function selectReview(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM Reseñas WHERE Usuario_ID=(SELECT Usuario_ID FROM Usuarios WHERE Nombre=?) AND Producto_ID=?");
            $sql->bindValue(1, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
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

    /* Funcion: Insertar una nueva reseña
     * Params: $data (datos de la reseña)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertReview(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO Reseñas (Comentario, Calificacion, Fecha_Hora, Producto_ID, Usuario_ID) VALUES (?, ?, ?, ?, (SELECT Usuario_ID FROM Usuarios WHERE Nombre=?))");
            $sql->bindValue(1, $data[0]);
            $sql->bindValue(2, $data[1]);
            $sql->bindValue(3, date("Y-m-d H:i:s"));
            $sql->bindValue(4, $data[2]);
            $sql->bindValue(5, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Eliminar una reseña por ID
     * Params: $id (ID de la reseña)
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteReview(&$id){
        try{
            $sql=$this->db->prepare("DELETE FROM Reseñas WHERE Reseña_ID=?");
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