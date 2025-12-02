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

    /* Función: Listar Categorias
     * Params: $offset (para paginación)
     * Return: Array de Categorias o 0 si no hay resultados, -1 en caso de error
     */
    public function listCategory(){
        try{
            $query="SELECT *, (SELECT P.Nombre FROM Categorias P WHERE P.Categoria_ID=C.Cat_Padre_ID) AS Cat_Padre FROM Categorias C";
            if(isset($_GET["methodCat"]) && $_GET["methodCat"]=="viewUpdate") $query.=" WHERE C.Categoria_ID NOT LIKE :selectID";
            
            $sql=$this->db->prepare($query);
            if(isset($_GET["methodCat"]) && $_GET["methodCat"]=="viewUpdate")  $sql->bindValue(":selectID", $_GET["id"], PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar Categoria especifica
     * Params: id de la categoria a seleccionar
     * Return: Datos de la categoria seleccionada o -1 en caso de error
     */
    public function selectCategory($id){
        try{
            $sql=$this->db->prepare("SELECT * FROM Categorias WHERE Categoria_ID=?");
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

    /* Función: Insertar Categoria
     * Params: $data (array con los datos de la categoria)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertCategory(&$data){
        try{
            $data[2] = ($data[2] == "") ? null : $data[2];

            $sql=$this->db->prepare("INSERT INTO Categorias (Nombre, Descripcion, Cat_Padre_ID) VALUES (?, ?, ?)");
            for($i=0;$i<3;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar Categoria
     * Params: $id (referenciado) y $data (array con los datos de la categoria)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateCategory(&$id, &$data){
        try{
            $data[2] = ($data[2] == 0) ? null : $data[2];

            $sql=$this->db->prepare("UPDATE Categorias SET Nombre=?, Descripcion=?, Cat_Padre_ID=? WHERE Categoria_ID=?");
            $sql->bindValue(1, $data[0]);
            $sql->bindValue(2, $data[1]);
            $sql->bindValue(3, $data[2]);
            $sql->bindValue(4, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar Categoria
     * Params: id de la categoria a eliminar
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteCategory($id){
        try{
            $sql=$this->db->prepare("DELETE FROM Categorias WHERE Categoria_ID=?");
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