<?php
class ProductModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Recuperar productos de un usuario Proveedor
     * Params: $offset (paginación)
     * Return: Array con los productos, 0 si no hay productos, -1 en caso de error
     */

    public function listProductP($offset){
        try{
            $sql=$this->db->prepare("SELECT * FROM PRODUCTOS WHERE Usuario_ID=(SELECT Usuario_ID FROM USUARIOS WHERE Nombre=?) LIMIT 7 OFFSET ?");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->bindValue(2, $offset*6, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Recuperar catálogo de productos para mostrar a un un usuario Cliente
     * Params: $offset (paginación)
     * Return: Array con los productos, 0 si no hay productos, -1 en caso de error
     */
    public function listProductC($offset){
        try{
            $placeholder = "%"; $offset=$offset*10;

            //*-----------------------------QUERY BUILD------------------------------*//
            $query = "SELECT * FROM PRODUCTOS P1 JOIN PROVEEDORES P2 ON P1.USUARIO_ID=P2.USUARIO_ID JOIN USUARIOS U ON P2.USUARIO_ID=U.USUARIO_ID WHERE (Categoría_ID LIKE ? OR Categoría_ID IS NULL)";
            $parameters = [$placeholder];

            if(isset($_COOKIE["search-options"])){
                $search=json_decode($_COOKIE["search-options"], true);

                if ($search["category"]!="") {
                    $query = "SELECT * FROM PRODUCTOS P1 JOIN PROVEEDORES P2 ON P1.USUARIO_ID=P2.USUARIO_ID JOIN USUARIOS U ON P2.USUARIO_ID=U.USUARIO_ID WHERE Categoría_ID = ?";
                    $parameters[0] = $search["category"];
                }
                if ($search["minPrice"]!="") {
                    $query .= " AND Precio_Mensual >= ?";
                    $parameters[] = $search["minPrice"];
                }
                if ($search["maxPrice"]!="") {
                    $query .= " AND Precio_Mensual <= ?";
                    $parameters[] = $search["maxPrice"];
                }
                if ($search["region"]!="") {
                    $query .= " AND Comunidad LIKE ?";
                    $parameters[] = $search["region"];
                }
                if ($search["province"]!="") {
                    $query .= " AND Provincia LIKE ?";
                    $parameters[] = $search["province"];
                }
            }

            $query .= " LIMIT 11 OFFSET ?";
            //*-----------------------------QUERY BUILD------------------------------*//

            //*-----------------------------QUERY BIND------------------------------*//
            $sql = $this->db->prepare($query);
            foreach ($parameters as $index => $value) $sql->bindValue($index + 1, $value);
            $sql->bindValue(count($parameters)+1, $offset, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() != 0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
            //*-----------------------------QUERY BIND------------------------------*//
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un producto por un campo y valor
     * Params: $id (ID del producto)
     * Return: Array con los productos, 0 si no hay productos, -1 en caso de error
     */
    public function selectProduct(&$field, &$value){
        try{
            $sql=$this->db->prepare("SELECT * FROM PRODUCTOS WHERE $field=?");
            $sql->bindValue(1, $value, PDO::PARAM_INT);
            $sql->execute();
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un producto
     * Params: Recibe la cookie "data-prod"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertProduct(&$data){
        try{
            //*-----------------------------DATA------------------------------*//
            include("_Indexes/Index_User.php"); $field="Nombre";
            $data[4]=($data[4]=="") ? null : $data[4];
            $uid=$userController->selectUser($field, $_SESSION["usuario"])[0]['Usuario_ID'];
            if(isset($_COOKIE["product-image"])) $file=$_COOKIE["product-image"]; else $file=null;
            //*-----------------------------DATA------------------------------*//

            $sql=$this->db->prepare("INSERT INTO PRODUCTOS (Nombre, Descripción, Referencia, Precio_Mensual, Categoría_ID, Usuario_ID, Imagen, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bindValue(1, $data[0]);
            $sql->bindValue(2, $data[1]);
            $sql->bindValue(3, $data[2]);
            $sql->bindValue(4, $data[3]);
            $sql->bindValue(5, $data[4]);
            $sql->bindValue(6, $uid);
            $sql->bindValue(7, $file);
            $sql->bindValue(8, 1);
            $sql->execute();

            return 1;
        }catch(PDOException $e){
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un producto
     * Params: $id (ID del producto), $data (datos del producto)
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function updateProduct(&$id, &$data){
        try{
            $data[4]=($data[4]=="") ? null : $data[4];
            if(isset($_COOKIE["product-image"])) $file=$_COOKIE["product-image"]; 
            else{
                $field="Producto_ID";
                $prod=$this->selectProduct($field, $id);
                if(is_array($prod)) $file=$prod[0]['Imagen'];
                else $file=null;
            }

            $sql=$this->db->prepare("UPDATE PRODUCTOS SET Nombre=?, Descripción=?, Referencia=?, Precio_Mensual=?, Categoría_ID=?, Imagen=? WHERE Producto_ID=?");
            $sql->bindValue(1, $data[0]);
            $sql->bindValue(2, $data[1]);
            $sql->bindValue(3, $data[2]);
            $sql->bindValue(4, $data[3]);
            $sql->bindValue(5, $data[4]);
            $sql->bindValue(6, $file);
            $sql->bindValue(7, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar un producto
     * Params: $id (ID del producto)
     * Return: 1 si se ha eliminado correctamente, -1 en caso de error
     */
    public function deleteProduct($id){
        try{
            $field="Producto_ID"; $imagen=$this->selectProduct($field, $id)[0]['Imagen'];
            $sql=$this->db->prepare("DELETE FROM PRODUCTOS WHERE PRODUCTO_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            unlink("../assets/img/products/".$imagen);
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Activar o desactivar un producto
     * Params: $id (ID del producto), $active (1 para activar, 0 para desactivar)
     * Return: 1 si se ha actualizado correctamente, -1 en caso de error
     */
    public function activeProduct($id, $active){
        try{
            $sql=$this->db->prepare("UPDATE PRODUCTOS SET Estado=? WHERE PRODUCTO_ID=?");
            $sql->bindValue(1, $active, PDO::PARAM_INT);
            $sql->bindValue(2, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Reactivar productos alquilados por un usuario eliminado
     * Params: $uId (ID del usuario)
     * Return: 1 si se activa correctamente, -1 en caso de error
     */
    public function activeByUser(&$uId){
        try{
            $sql2 = $this->db->prepare("UPDATE PRODUCTOS SET ESTADO=? WHERE PRODUCTO_ID IN (
                SELECT PRODUCTO_ID FROM ALQUILERES A WHERE A.USUARIO_ID=? AND A.ESTADO=1)");
            $sql2->bindValue(1, 1, PDO::PARAM_INT);
            $sql2->bindValue(2, $uId, PDO::PARAM_INT);
            $sql2->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Procesar la imagen del producto
     * Params: $id (ID del producto), $file (archivo de imagen)
     * Return: Nombre de la imagen procesada
     */
    public function imageProcess(&$id, &$file){
        if($id!=null && $id!=""){
            $field="Producto_ID";
            $oldImage = $this->selectProduct($field, $id)[0]['Imagen'];
            if($oldImage) unlink("../assets/img/products/$oldImage");
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $image = $id . "." . $extension;
        }else{
            $idName = $this ->db->prepare("SELECT MAX(PRODUCTO_ID) AS 'LastID' FROM PRODUCTOS");
            $idName->execute();
            $idName = $idName->fetch(PDO::FETCH_ASSOC)['LastID'];
            if($idName==null) $idName=1; else $idName++;
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $image = $idName . "." . $extension;
        }

        $imagentemp = $file["tmp_name"];
        move_uploaded_file($imagentemp, "../assets/img/products/".$image);
        setcookie("product-image", $image, time()+3600,"/");
        return $image;
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar el número total de productos
     * Params: No recibe parámetros
     * Return: Número total de productos, 0 si no hay productos, -1 en caso de error
     */
    public function countProduct(){
        try{
            $sql=$this->db->prepare("SELECT COUNT(PRODUCTO_ID) AS 'COUNT' FROM PRODUCTOS");
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