<?php
class CategoryModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar Categorías
     * Params: $offset (para paginación)
     * Return: Array de categorías o 0 si no hay resultados, -1 en caso de error
     */
    public function listCategory(&$offset=0){
        try{
            $query="SELECT *, (SELECT P.NOMBRE FROM CATEGORÍAS P WHERE P.CATEGORÍA_ID=C.CAT_PADRE_ID) AS Cat_Padre FROM CATEGORÍAS C";
            if(isset($_GET["methodCat"])){
                if($_GET["methodCat"]=="viewUpdate") $query.=" WHERE C.CATEGORÍA_ID NOT LIKE :selectID";
                else if($_GET["methodCat"]!="viewAdd") { $query.=" LIMIT 11 OFFSET :offset"; }
            }
            
            $sql=$this->db->prepare($query);
            if(isset($_GET["methodCat"])){
                if($_GET["methodCat"]=="viewUpdate") $sql->bindValue(":selectID", $_GET["id"], PDO::PARAM_INT);
                else if($_GET["methodCat"]!="viewAdd") $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
            }
            
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

    /* Función: Seleccionar Categoría específica
     * Params: id de la categoría a seleccionar
     * Return: Datos de la categoría seleccionada o -1 en caso de error
     */
    public function selectCategory($id){
        try{
            $sql=$this->db->prepare("SELECT * FROM CATEGORÍAS WHERE CATEGORÍA_ID=?");
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

    /* Función: Insertar Categoría
     * Params: $data (array con los datos de la categoría)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertCategory(&$data){
        try{
            $sql=$this->db->prepare("INSERT INTO CATEGORÍAS (Nombre, Descripción, Cat_Padre_ID) VALUES (?, ?, ?)");
            $sql->bindValue(1, $data[0]);
            $sql->bindValue(2, $data[1]);
            if (empty($data[2]))
                $sql->bindValue(3, null, PDO::PARAM_NULL);
            else
                $sql->bindValue(3, $data[2], PDO::PARAM_INT);
            $sql->execute();

            setcookie("data-cat", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar Categoría
     * Params: $id (referenciado) y $data (array con los datos de la categoría)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateCategory(&$id, &$data){
        try{
            $sql=$this->db->prepare("UPDATE CATEGORÍAS SET Nombre=?, Descripción=?, Cat_Padre_ID=? WHERE CATEGORÍA_ID=?");
            $sql->bindValue(1, $data[0]);
            $sql->bindValue(2, $data[1]);
            if (empty($data[2]))
                $sql->bindValue(3, null, PDO::PARAM_NULL);
            else
                $sql->bindValue(3, $data[2], PDO::PARAM_INT);
            $sql->bindValue(4, $id, PDO::PARAM_INT);
            $sql->execute();

            setcookie("data-cat", 0, time()-1,"/");
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar Categoría
     * Params: id de la categoría a eliminar
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteCategory($id){
        try{
            $sql=$this->db->prepare("DELETE FROM CATEGORÍAS WHERE CATEGORÍA_ID=?");
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