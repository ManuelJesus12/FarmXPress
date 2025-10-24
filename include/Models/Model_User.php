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

    /* Función: Insertar un nuevo usuario
     * Params: $data (datos del usuario)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertUser(&$data){
        try{
            $date=date("Y-m-d H:i:s");

            //*-----------------------------INSERT CODE------------------------------*//
            $sql=$this->db->prepare("INSERT INTO USUARIOS (Email, CIF, Nombre, Contraseña, Teléfono, Dirección, Comunidad, Provincia, Tipo, Fecha_Registro, Avatar, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            for($i=0;$i<=8;$i++) $sql->bindValue($i+1, $data[$i]);
            $sql->bindValue(10, $date); //Fecha_Registro
            $sql->bindValue(11, $data[9]); //Avatar

            if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR")
                $sql->bindValue(12, 1, PDO::PARAM_INT);
            else 
                $sql->bindValue(12, 0, PDO::PARAM_INT);
            $sql->execute();

            //*-----------------------------CLIENT / SUPPLIER------------------------------*//
            if($data[6]=="C") $table="CLIENTES";
            else if($data[6]=="P") $table="PROVEEDORES";

            $sql=$this->db->prepare("INSERT INTO $table (USUARIO_ID) VALUES (?)");
            $sql->bindValue(1, $this->db->lastInsertId(), PDO::PARAM_INT);
            $sql->execute();
            //*-----------------------------CLIENT / SUPPLIER------------------------------*//
            //*-----------------------------INSERT CODE------------------------------*//

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

            if($file==null) $file="anon.png";
            setcookie("UserAvatar", "assets/img/users/".$file, time()+3600*24*7, "/");
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
            $sql=$this->db->prepare("DELETE FROM USUARIOS WHERE USUARIO_ID=?");
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();

            unlink("../assets/img/users/" . $avatar);
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
            echo $e->getMessage();
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>