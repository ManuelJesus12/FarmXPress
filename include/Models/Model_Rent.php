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
    public function listRent(){
        try{
            $query="SELECT P.PRODUCTO_ID AS 'PID', A.ALQUILER_ID AS 'RID', Nombre, Referencia, Imagen, Fecha_Inicio, Fecha_Fin, Precio_Total, (PRECIO_TOTAL - SUM(CANTIDAD)) AS 'Deuda'
            FROM ALQUILERES A JOIN PRODUCTOS P ON A.PRODUCTO_ID=P.PRODUCTO_ID LEFT JOIN PAGOS G ON A.ALQUILER_ID=G.ALQUILER_ID
            WHERE A.USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?) AND A.ESTADO=1 GROUP BY A.ALQUILER_ID";
            $sql=$this->db->prepare($query);
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

    /* Función: Seleccionar un alquiler por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con los alquileres encontrados, 0 si no hay alquileres, -1 en caso de error
     */
    public function selectRent(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM ALQUILERES A JOIN PRODUCTOS P ON A.PRODUCTO_ID=P.PRODUCTO_ID 
            WHERE A.USUARIO_ID=(SELECT USUARIO_ID FROM USUARIOS WHERE Nombre=?) AND A.PRODUCTO_ID=? AND A.ESTADO=1");
            $sql->bindValue(1, $_SESSION["usuario"], PDO::PARAM_STR);
            $sql->bindValue(2, $pId, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC)[0];
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
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT'];
            else return 0;
        }catch(PDOException $e) {
            return 0;
        }
    }

    /* Función: Recabar datos de los Alquileres de un Producto
     * Params: $id (ID del producto)
     * Return: Consulta si se activa correctamente, 0 en caso de no encontrar datos y -1 en caso de error
     */
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Recabar información de los Alquileres de un Producto
     * Params: $id (ID del producto)
     * Return: Consulta si se activa correctamente, 0 en caso de no encontrar datos y -1 en caso de error
     */
    public function listRentDataByProduct(&$id){
        try{
            $query="SELECT Nombre, Cif, Email, Teléfono, Provincia, Avatar, Fecha_Inicio, Fecha_Fin, Precio_Total, 
            A.Estado AS 'STATRENT' FROM ALQUILERES A JOIN USUARIOS U ON U.USUARIO_ID=A.USUARIO_ID WHERE A.PRODUCTO_ID=?";
            $sql=$this->db->prepare($query);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            else
                return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    public function listRentStatsByProduct(&$id){
        try{
            $query="SELECT IFNULL(COUNT(ALQUILER_ID),0) AS 'TOTAL_RENTS', IFNULL(SUM(PRECIO_TOTAL),0) AS 'TOTAL_EARNINGS', 
            (SELECT AVG(CALIFICACIÓN) FROM RESEÑAS WHERE PRODUCTO_ID=A.PRODUCTO_ID) AS 'AVG_RATE', 
            (SELECT NOMBRE FROM PRODUCTOS WHERE PRODUCTO_ID=A.PRODUCTO_ID) AS 'PNOM'
            FROM ALQUILERES A WHERE PRODUCTO_ID=?";
            $sql=$this->db->prepare($query);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC)[0];
            else
                return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Enviar un correo electrónico al usuario
     * Params: $email (correo electrónico del usuario), $name (nombre del usuario)
     * Return: Mensaje de éxito o error al enviar el correo
     */
    public function sendRentEmail(&$email, &$name){
        try{
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = 587;
            $phpmailer->Username = 'farmxpress0@gmail.com';
            $phpmailer->Password = 'infofarmxpressmjfs';
            $phpmailer->setFrom('CorreoGmail', 'Sistema de Reservas');
            $phpmailer->addAddress($email, $name);
            $phpmailer->isHTML(true);
            $phpmailer->Subject = 'Asunto';
            $phpmailer->Body = "Aqui puedes poner lo que quieras de html";

            if(!$phpmailer->send())
                echo "No existe su correo electrónico o no se ha podido enviar el correo de confirmación.";
            
        }catch(PDOException $e) {
            return -1;
        }
    }
}
?>