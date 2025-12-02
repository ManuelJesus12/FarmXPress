<?php
class MemberModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    
    /* Funcion: Listar Membresias
     * Params: Ninguno
     * Return: Array de Membresias o 0 si no hay resultados, -1 en caso de error
     */
    public function listMember(){
        try{
            $sql=$this->db->prepare("SELECT *, U.Nombre AS 'UNOM', S.Nombre AS 'SNOM' FROM Membresias M JOIN Usuarios U 
            ON M.Usuario_ID=U.Usuario_ID JOIN Suscripciones S ON M.Suscripcion_ID=S.Suscripcion_ID WHERE M.Estado=1");
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Seleccionar Membresia activa del usuario
     * Params: Ninguno
     * Return: Datos de la membresia seleccionada o -1 en caso de error
     */
    public function selectMember(){
        try{
            $sql=$this->db->prepare("SELECT * FROM Membresias M JOIN Suscripciones S ON S.Suscripcion_ID=M.Suscripcion_ID WHERE Usuario_ID=(SELECT Usuario_ID FROM Usuarios WHERE Nombre=?) AND Estado=1");
            $sql->bindValue(1, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
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

    /* Funcion: Insertar Membresia
     * Params: $id (ID de la suscripcion)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */

    public function insertMember(&$id){
        try{
            include("_Indexes/Index_Sub.php");
            $sql=$this->db->prepare("INSERT INTO Membresias (Usuario_ID, Suscripcion_ID, Fecha_Inicio, Fecha_Fin, Estado) VALUES ((SELECT Usuario_ID FROM Usuarios WHERE Nombre=?), ?, ?, ?, ?)");
            $sql->bindValue(1, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
            $sql->bindValue(2, $id, PDO::PARAM_INT);
            $sql->bindValue(3, date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->bindValue(4, date("Y-m-d H:i:s", strtotime("+".$subController->selectSub($id)['Duracion_Base']." months")), PDO::PARAM_STR);
            $sql->bindValue(5, 1, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Actualizar Membresia
     * Params: $month (referenciado para actualizar)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */

    public function updateMember(&$month){
        try{
            $sql=$this->db->prepare("UPDATE Membresias SET Fecha_Fin = ADDDATE(Fecha_Fin, INTERVAL ? MONTH), Mail_Bool=1 WHERE Usuario_ID=(SELECT Usuario_ID FROM Usuarios WHERE Nombre=?) AND Estado=1");
            $sql->bindValue(1, $month, PDO::PARAM_INT);
            $sql->bindValue(2, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Funcion: Desactivar Envio de email de Membresia
     * Params: $id (ID de la membresia a desactivar)
     * Return: 1 si se desactiva correctamente, -1 en caso de error
     */

    public function toggleMailBoolMember(&$id){
        try{
            $sql=$this->db->prepare("UPDATE Membresias SET Mail_Bool=0 WHERE Membresia_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Funcion: Desactivar Membresia
     * Params: $id (ID de la membresia a desactivar)
     * Return: 1 si se desactiva correctamente, -1 en caso de error
     */

    public function activeMember(&$id){
        try{
            $sql=$this->db->prepare("UPDATE Membresias SET Estado=0 WHERE Membresia_ID=?");
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

    /* Funcion: Contar Membresias
     * Params: Ninguno
     * Return: Número total de Membresias o 0 si no hay resultados
     */
    public function countMember(){
        try{
            $sql=$this->db->prepare("SELECT COUNT(Membresia_ID) AS 'COUNT' FROM Membresias");
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

    /* Funcion: Enviar un correo electronico al usuario
     * Params: $email (correo electronico del usuario), $name (Nombre del usuario)
     * Return: Mensaje de éxito o error al enviar el correo
     */
    public function sendMemberEmail(&$email, &$uname, &$sname){
        try{
            global $dirLocation; $dir = ($dirLocation == 0) ? "" : "../";
            require_once $dir.'assets/vendor/PHPMailer/src/PHPMailer.php';
            require_once $dir.'assets/vendor/PHPMailer/src/SMTP.php';
            require_once $dir.'assets/vendor/PHPMailer/src/Exception.php';

            $phpmailer = new \PHPMailer\PHPMailer\PHPMailer;
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = 587;
            $phpmailer->Username = 'farmxpress0@gmail.com';
            $phpmailer->Password = 'btrh raeq lpko zlxk';
            $phpmailer->setFrom('farmxpress0@gmail.com', 'FarmXPress');
            $phpmailer->addAddress($email, $uname);
            $phpmailer->isHTML(true);
            $phpmailer->Subject = "Recordatorio de renovacion de membresia - FarmXPress";
            $phpmailer->Body = "Su suscripcion de membresia $sname está a punto de vencer en 5 dias. Por favor, renueve su membresia para continuar disfrutando de nuestros servicios.<br><br>Atentamente,<br>El equipo de FarmXPress.";

            if($phpmailer->send()) return 1;
            else return 0;
            
        }catch(Exception $e) {
            return -1;
        }
    }
}
?>