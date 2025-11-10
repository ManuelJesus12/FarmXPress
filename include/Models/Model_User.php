<?php
class UserModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar usuarios
     * Params: $offset (paginación)
     * Return: Página de lista de usuarios, 0 si no hay usuarios, -1 en caso de error
     */
    public function listUser(){
        try{
            $sql=$this->db->prepare("SELECT * FROM USUARIOS ORDER BY USUARIO_ID ASC");
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    
    /* Función: Seleccionar un usuario por un campo y su valor
     * Params: $field (campo a buscar), $value (valor del campo)
     * Return: Array con el usuario encontrado, 0 si no hay usuarios, -1 en caso de error
     */
    public function selectUser(&$value, &$field = "Usuario_ID"){
        try{
            $sql=$this->db->prepare("SELECT * FROM USUARIOS WHERE $field=?");
            $sql->bindValue(1, $value);
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

    /* Función: Insertar un nuevo usuario
     * Params: $data (datos del usuario)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertUser(&$data){
        try{
            $date=date("Y-m-d H:i:s");
            $estado=(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]=="ADMINISTRADOR") ? 1 : 0;
            
            //*-----------------------------CONSULTA DE INSERTAR------------------------------*//
            $sql=$this->db->prepare("INSERT INTO USUARIOS (Email, CIF, Nombre, Contraseña, Teléfono, Dirección, Comunidad, Provincia, Tipo, Fecha_Registro, Avatar, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            for($i=0;$i<=8;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->bindValue(10, $date); //Fecha_Registro
            $sql->bindValue(11, $data[9]); //Avatar
            $sql->bindValue(12, $estado, PDO::PARAM_INT);
            $sql->execute();

            //*-----------------------------CLIENTE / PROVEEDOR------------------------------*//
            $table = ($data[6]=="C") ? "CLIENTES" : "PROVEEDORES";
            $sql=$this->db->prepare("INSERT INTO $table (USUARIO_ID) VALUES (?)");
            $sql->bindValue(1, $this->db->lastInsertId(), PDO::PARAM_INT);
            $sql->execute();
            //*-----------------------------CLIENTE / PROVEEDOR------------------------------*//
            //*-----------------------------CONSULTA DE INSERTAR------------------------------*//

            $this->sendRegisterMail($data[0], $data[2]);
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un usuario existente
     * Params: $id (ID del usuario), $data (datos del usuario)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */ 

    public function updateUser(&$id, &$data){
        try{
            $sql=$this->db->prepare("UPDATE USUARIOS SET Email=?, CIF=?, Nombre=?, Teléfono=?, Dirección=?, Comunidad=?, Provincia=?, Avatar=? WHERE USUARIO_ID=?");            
            $sql->bindValue(1, $data[0]); //Email
            $sql->bindValue(2, $data[1]); //Cif
            $sql->bindValue(3, $data[2]); //Nombre
            $sql->bindValue(4, $data[4]); //Telefono
            $sql->bindValue(5, $data[5]); //Direccion
            $sql->bindValue(6, $data[6]); //Comunidad
            $sql->bindValue(7, $data[7]); //Provincia
            $sql->bindValue(8, $data[9]);
            $sql->bindValue(9, $id);
            $sql->execute();
            
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar un usuario
     * Params: $id (ID del usuario a eliminar)
     * Return: 1 si se elimina correctamente, -1 en caso de error
     */
    public function deleteUser($id){
        try{
            $avatar=$this->selectUser($id)['Avatar'];
            unlink("../assets/img/users/" . $avatar);

            $sql=$this->db->prepare("DELETE FROM USUARIOS WHERE USUARIO_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Activar o desactivar un usuario
     * Params: $id (ID del usuario), $active (1 para activar, 0 para desactivar)
     * Return: 1 si se actualiza correctamente, -1 en caso de error
     */
    public function activeUser($id, $active){
        try{
            $sql=$this->db->prepare("UPDATE USUARIOS SET Estado=? WHERE USUARIO_ID=?");
            $sql->bindValue(1, $active, PDO::PARAM_INT);
            $sql->bindValue(2, $id, PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    public function validateUser(){
        try{
            $sql=$this->db->prepare("UPDATE USUARIOS SET Estado=? WHERE NOMBRE=?");
            $sql->bindValue(1, 1, PDO::PARAM_INT);
            $sql->bindValue(2, $_SESSION["User"]["Nombre"], PDO::PARAM_INT);
            $sql->execute();

            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Iniciar sesión de usuario
     * Params: $nombre (nombre de usuario), $contraseña (contraseña del usuario)
     * Return: 1 si el login es exitoso, 0 si las credenciales son incorrectas, -1 si hay un error
     */
    public function loginUser(&$nombre, &$contraseña){
        if($nombre=="ADMINISTRADOR" and $contraseña=="ADMINAPP") return 1;
        else{
            try{
                $field="Nombre"; $user = $this->selectUser($nombre, $field);

                if(is_array($user)){
                    if(password_verify($contraseña, $user['Contraseña']))
                        return 1;
                    else return 0;
                }else   return 0;
            }catch(PDOException $e){
                return -1;
            }
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar el número de usuarios
     * Params: No recibe parámetros
     * Return: Número total de usuarios en la base de datos, 0 si no hay usuarios, -1 en caso de error
     */
    public function countUser(){
        try{
            $sql=$this->db->prepare("SELECT COUNT(USUARIO_ID) AS 'COUNT', MAX(USUARIO_ID) AS 'MAX' FROM USUARIOS");
            $sql->execute();
            
            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC)[0];
            else return 0;
        }catch(PDOException $e) {
            return 0;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Enviar un correo electrónico al usuario
     * Params: $email (correo electrónico del usuario), $name (nombre del usuario)
     * Return: Mensaje de éxito o error al enviar el correo
     */
    public function sendRegisterMail(&$email, &$name){
        try{
            require '../assets/vendor/PHPMailer/src/PHPMailer.php';
            require '../assets/vendor/PHPMailer/src/SMTP.php';
            require '../assets/vendor/PHPMailer/src/Exception.php';
            
            $phpmailer =  new \PHPMailer\PHPMailer\PHPMailer;
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
            $phpmailer->Subject = 'Gracias por su registro';
            $phpmailer->Body = "Verifica su cuenta haciendo click 
            <a href='https://localhost/FARMXPRESS/include/principal.php?methodUser=validate'>aquí</a>
            para poder comenzar a alquilar productos.";
            $phpmailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
            ));

            if($phpmailer->send()) return 1;
            else return 0;
            
        }catch(Exception $e) {
            return $e->getMessage();
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>