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

    public function listProductP(&$value, &$field = "Nombre"){
        try{
            $sql=$this->db->prepare("SELECT *, (SELECT NOMBRE FROM CATEGORÍAS C WHERE C.CATEGORÍA_ID=P.CATEGORÍA_ID) AS 'CAT'
            FROM PRODUCTOS P WHERE Usuario_ID=(SELECT Usuario_ID FROM USUARIOS WHERE $field=?)");
            $sql->bindValue(1, $value, PDO::PARAM_STR);
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
    public function listProductC(&$offset=0){
        try{
            $placeholder = "%"; $offset=$offset*10;

            //*-----------------------------QUERY BUILD------------------------------*//
            $query = "SELECT Producto_ID, Usuario_ID, Nombre, Referencia, Precio_Mensual, Estado, Imagen, 
            (SELECT Provincia FROM USUARIOS U WHERE U.Usuario_ID=P.Usuario_ID) AS 'PROV', 
            (SELECT Nombre FROM USUARIOS U WHERE U.Usuario_ID=P.Usuario_ID) AS 'PNOM', 
            (SELECT Nombre FROM CATEGORÍAS C WHERE C.Categoría_ID=P.Categoría_ID) AS 'CAT' 
            FROM PRODUCTOS P WHERE P.Categoría_ID LIKE ? OR P.Categoría_ID IS NULL";
            $parameters = [$placeholder];

            if(isset($_COOKIE["search-options"])){
                $search=json_decode($_COOKIE["search-options"], true);
                if ($search["category"]!="") {
                    $query = "SELECT Producto_ID, Usuario_ID, Nombre, Referencia, Precio_Mensual, Estado, Imagen, 
                    (SELECT Provincia FROM USUARIOS U ON U.Usuario_ID=P.Usuario_ID) AS 'PROV', 
                    (SELECT Nombre FROM USUARIOS U ON U.Usuario_ID=P.Usuario_ID) AS 'PNOM',  
                    (SELECT Nombre FROM CATEGORÍAS C ON C.Categoría_ID=P.Categoría_ID) AS 'CAT'
                    FROM PRODUCTOS P WHERE P.Categoría_ID = ?";
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
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un producto por un campo y valor
     * Params: $id (ID del producto)
     * Return: Array con los productos, 0 si no hay productos, -1 en caso de error
     */
    public function selectProduct(&$value, &$field = "Producto_ID"){
        try{
            $sql=$this->db->prepare("SELECT * FROM PRODUCTOS WHERE $field=?");
            $sql->bindValue(1, $value, PDO::PARAM_INT);
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

    /* Función: Insertar un producto
     * Params: Recibe la cookie "data-prod"
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertProduct(&$data){
        try{
            //*-----------------------------DATA------------------------------*//
            include("_Indexes/Index_User.php"); $field="Nombre";
            $data[4]=($data[4]=="") ? null : $data[4];
            $data[5]=$userController->selectUser($_SESSION["usuario"], $field)['Usuario_ID'];
            $data[6]=(isset($_COOKIE["product-image"])) ? $_COOKIE["product-image"] : null;
            //*-----------------------------DATA------------------------------*//

            $sql=$this->db->prepare("INSERT INTO PRODUCTOS (Nombre, Descripción, Referencia, Precio_Mensual, Categoría_ID, Usuario_ID, Imagen, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
            for($i=0;$i<7;$i++) $sql->bindValue(($i+1), $data[$i]);
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
            if(isset($_COOKIE["product-image"])) $data[5]=$_COOKIE["product-image"]; 
            else{
                $prod=$this->selectProduct($id);
                $data[5]=(is_array($prod)) ? $prod['Imagen'] : null;
            }

            $sql=$this->db->prepare("UPDATE PRODUCTOS SET Nombre=?, Descripción=?, Referencia=?, Precio_Mensual=?, Categoría_ID=?, Imagen=? WHERE Producto_ID=?");
            for($i=0;$i<6;$i++) $sql->bindValue(($i+1), $data[$i]);
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
            $imagen=$this->selectProduct($id)['Imagen'];
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
    public function activeProduct($id, $active=0){
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
    public function liberateProduct(&$uId){
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
            $oldImage = $this->selectProduct($id)['Imagen'];
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