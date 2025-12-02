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

    public function listAllActiveRents(){
        try{
            $sql=$this->db->prepare("SELECT * FROM Alquileres WHERE Estado=1");
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Ver lista de Alquileres de un usuario
     * Params: $offset (paginacion)
     * Return: Página de lista de Alquileres.
     */
    public function listRent(){
        try{
            $query="SELECT P.Producto_ID AS 'PID', A.Alquiler_ID AS 'RID', Nombre, Referencia, Imagen, Fecha_Inicio, Fecha_Fin, Precio_Total, (Precio_Total - SUM(Cantidad)) AS 'Deuda'
            FROM Alquileres A JOIN Productos P ON A.Producto_ID=P.Producto_ID LEFT JOIN Pagos G ON A.Alquiler_ID=G.Alquiler_ID
            WHERE A.Usuario_ID=(SELECT Usuario_ID FROM Usuarios WHERE Nombre=?) AND A.Estado=1 GROUP BY A.Alquiler_ID";
            $sql=$this->db->prepare($query);
            $sql->bindValue(1,$_SESSION["User"]["Nombre"], PDO::PARAM_STR);
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

    /* Funcion: Seleccionar un alquiler por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con los Alquileres encontrados, 0 si no hay Alquileres, -1 en caso de error
     */
    public function selectRent(&$pId){
        try{
            $sql=$this->db->prepare("SELECT * FROM Alquileres A JOIN Productos P ON A.Producto_ID=P.Producto_ID 
            WHERE A.Usuario_ID=(SELECT Usuario_ID FROM Usuarios WHERE Nombre=?) AND A.Producto_ID=? AND A.Estado=1");
            $sql->bindValue(1, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
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

    /* Funcion: Insertar un nuevo alquiler
     * Params: $id (ID del producto), $month (meses de alquiler), $price (precio del alquiler)
     * Return: 1 o -1 en caso de error
     */
    public function insertRent(&$id, &$month, &$price){
        try{
            $sql=$this->db->prepare("INSERT INTO Alquileres (Usuario_ID, Producto_ID, Fecha_Inicio, Fecha_Fin, Estado, 
                            Precio_Total) VALUES ((SELECT Usuario_ID FROM Usuarios WHERE Nombre=?), ?, ?, ?, ?, ?)");
            $sql->bindValue(1,$_SESSION["User"]["Nombre"], PDO::PARAM_STR);
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

    /* Funcion: Actualizar un alquiler
     * Params: $month (meses de alquiler), $mPrice (precio del alquiler), $rId (ID del alquiler)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function updateRent(&$month, &$mPrice, &$rId){
        try{
            $sql=$this->db->prepare("UPDATE Alquileres SET Mail_Bool=1, Fecha_Fin = ADDDATE(Fecha_Fin, INTERVAL ? MONTH), Precio_Total=Precio_Total + ? WHERE Alquiler_ID=?");
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

    /* Funcion: Desactivar un alquiler
     * Params: $rId (ID del alquiler)
     * Return: 1 si se activa correctamente, -1 en caso de error
     */
    public function activeRent(&$rId){
        try{
            $sql=$this->db->prepare("UPDATE Alquileres SET Estado=0, Mail_Bool=0, Fecha_Fin=NOW() WHERE Alquiler_ID=?");
            $sql->bindValue(1, $rId, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    public function toggleMailBoolRent(&$rId){
        try{
            $sql=$this->db->prepare("UPDATE Alquileres SET Mail_Bool=0 WHERE Alquiler_ID=?");
            $sql->bindValue(1, $rId, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Funcion: Contar el número de Alquileres
     * Params: Void
     * Return: Número de Alquileres, 0 si no hay Alquileres, -1 en caso de error
     */
    public function countRent(){
        try{
            $sql=$this->db->prepare("SELECT COUNT(Alquiler_ID) AS 'COUNT' FROM Alquileres");
            $sql->execute();
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT'];
            else return 0;
        }catch(PDOException $e) {
            return 0;
        }
    }

    /* Funcion: Recabar datos de los Alquileres de un Producto
     * Params: $id (ID del producto)
     * Return: Consulta si se activa correctamente, 0 en caso de no encontrar datos y -1 en caso de error
     */
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Funcion: Recabar informacion de los Alquileres de un Producto
     * Params: $id (ID del producto)
     * Return: Consulta si se activa correctamente, 0 en caso de no encontrar datos y -1 en caso de error
     */
    public function listRentDataByProduct(&$id){
        try{
            $query="SELECT Nombre, Cif, Email, Telefono, Provincia, Avatar, Fecha_Inicio, Fecha_Fin, Precio_Total, 
            A.Estado AS 'STATRENT' FROM Alquileres A JOIN Usuarios U ON U.Usuario_ID=A.Usuario_ID WHERE A.Producto_ID=?";
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
            $query="SELECT IFNULL(COUNT(Alquiler_ID),0) AS 'TOTAL_RENTS', IFNULL(SUM(Precio_Total),0) AS 'TOTAL_EARNINGS', 
            (SELECT AVG(Calificacion) FROM Reseñas WHERE Producto_ID=A.Producto_ID) AS 'AVG_RATE', 
            (SELECT NOMBRE FROM Productos WHERE Producto_ID=A.Producto_ID) AS 'PNOM'
            FROM Alquileres A WHERE Producto_ID=?";
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

    /* Funcion: Enviar un correo electronico al usuario
     * Params: $email (correo electronico del usuario), $name (nombre del producto), $bool (tipo de correo)
     * Return: Mensaje de exito o error al enviar el correo
     */
    public function sendRentEmail(&$email, &$name, &$bool){
        try{
            global $dirLocation; $dir = ($dirLocation == 0) ? "" : "../";
            require_once $dir.'assets/vendor/PHPMailer/src/PHPMailer.php';
            require_once $dir.'assets/vendor/PHPMailer/src/SMTP.php';
            require_once $dir.'assets/vendor/PHPMailer/src/Exception.php';

            //1=Nuevo Alquiler, 0=Alquiler Anulado//
            if($bool==1){
                $subject="Nuevo Alquiler";
                $body="Su producto $name ha sido alquilado.";
            }else if($bool==0){
                $subject="Uno de sus Productos vuelve a estar disponible";
                $body="Su producto $name vuelve a estar disponible al haber sido anulado su alquiler previo.";
            }else{
                $subject="Notificacion de Alquiler";
                $body="A su alquiler del producto $name le quedan solo 5 días.";
            }

            $phpmailer = new \PHPMailer\PHPMailer\PHPMailer;
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = 587;
            $phpmailer->Username = 'farmxpress0@gmail.com';
            $phpmailer->Password = 'btrh raeq lpko zlxk';
            $phpmailer->setFrom('farmxpress0@gmail.com', 'FarmXPress');
            $phpmailer->addAddress($email, $name);
            $phpmailer->isHTML(true);
            $phpmailer->Subject = $subject;
            $phpmailer->Body = $body;

            if($phpmailer->send()) return 1;
            else return 0;
            
        }catch(Exception $e) {
            return -1;
        }
    }
}
?>