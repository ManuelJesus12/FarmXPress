<?php
class FavModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar Productos Favoritos
     * Params: $offset (para paginación)
     * Return: Array de productos favoritos o 0 si no hay resultados, -1 en caso de error
     */
    public function viewListFav(){
        try{
            $sql=$this->db->prepare("SELECT Nombre, Referencia, Precio_Mensual, Imagen, Estado, P.Producto_ID AS 'PID', P.Usuario_ID AS 'UID', 
            (SELECT NOMBRE FROM CATEGORÍAS C WHERE C.CATEGORÍA_ID=P.CATEGORÍA_ID) AS 'CAT', 
            (SELECT PROVINCIA FROM USUARIOS U WHERE U.USUARIO_ID=P.USUARIO_ID) AS 'PROV'
            FROM PRODUCTOS P JOIN SEGUIMIENTOS S ON P.Producto_ID=S.Producto_ID WHERE S.Usuario_ID=(SELECT Usuario_ID FROM USUARIOS WHERE Nombre=?)");
            $sql->bindValue(1, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
            $sql->execute();
            
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            else
                return 0;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar Producto Favorito específico
     * Params: id del producto a seleccionar
     * Return: 1 si el producto está en favoritos, 0 si no lo está, -1 en caso de error
     */
    public function selectFav(&$id){
        try{            
            $sql=$this->db->prepare("SELECT * FROM SEGUIMIENTOS WHERE Producto_ID=? AND Usuario_ID=(SELECT Usuario_ID FROM USUARIOS WHERE Nombre=?)");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->bindValue(2, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
            $sql->execute();

            if($sql->rowCount()!=0) return 1; 
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar Producto en Favoritos o eliminarlo
     * Params: $id (ID del producto), $action (add para añadir, del para eliminar)
     * Return: 1 si la operación fue exitosa, -1 en caso de error
     */
    public function toggleFav(&$id, &$action){
        try{
            if($action=="add")
                $query="INSERT INTO SEGUIMIENTOS (Producto_ID, Usuario_ID) VALUES (?, (SELECT Usuario_ID FROM USUARIOS WHERE Nombre=?))";
            else if($action=="del")
                $query="DELETE FROM SEGUIMIENTOS WHERE Producto_ID=? AND Usuario_ID=(SELECT Usuario_ID FROM USUARIOS WHERE Nombre=?)";
            
            $sql=$this->db->prepare($query);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->bindValue(2, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
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