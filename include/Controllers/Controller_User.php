<?php
class UserController {
    private $userModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    public function viewLogin(){
        require_once 'Views/View_User_Login.php';
    }
    public function viewUserForm(){
        require_once 'Views/View_User_Register.php';
    }
    public function viewProfile(){
        require_once 'Views/View_User_Profile.php';
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    
    /* Función: Ver lista de usuarios
     * Params: void
     * Return: Página de lista de usuarios o para Logs de Administrador
     */
    public function viewListUser(){
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR"){
            $userControl=$this->userModel->listUser();

            if(!isset($_GET["methodAdmin"])) include("Views/View_List_User.php");
            else return $userControl;
        }else
            echo "<h2>Acceso a esta sección denegado</h2>";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un usuario por campo y valor
     * Params: $field (campo a buscar), $value (valor a buscar)
     * Return: Array con el usuario encontrado, 0 si no hay usuarios, -1 en caso de error
     */
    public function selectUser(&$value, &$field = "Usuario_ID"){
        return $this->userModel->selectUser($value, $field);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un nuevo usuario
     * Params: No recibe parámetros, utiliza los datos de la cookie "data-user"
     * Return: Redirección a la vista de lista de usuarios o login según el tipo de usuario
     */
    public function insertUser(){
        include("../assets/php/vBackEndUser.php");
        if($this->userModel->insertUser($data)==1){
            if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR")
                header("Location: principal.php?methodUser=select&action=insert");
            else
                $this->loginUser($data[2], $data[3]);
            setcookie("user-avatar", 0, time()-1,"/");
        }else
            return "Error al registrar el usuario, datos incompletos o incorrectos.";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un usuario existente
     * Params: No recibe parámetros, utiliza los datos de la cookie "data-user"
     * Return: Redirección a la vista de lista de usuarios o al index según el tipo de usuario
     */
    public function updateUser(){
        include("../assets/php/vBackEndUser.php"); $field="Nombre";
        $id=(isset($_GET['userId']) && $_GET['userId']!=null) ? $_GET['userId'] : 
        $this->selectUser($_SESSION["usuario"], $field)['Usuario_ID'];

        if($this->userModel->updateUser($id, $data)==1){
            if($_SESSION["usuario"]!="ADMINISTRADOR"){
                $_SESSION["usuario"]=$data[2];
                header("Location: ../index.php?action=2");
            }else
                header("Location: principal.php?methodUser=select&action=update");
            setcookie("user-avatar", 0, time()-1,"/");
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar un usuario y reactivar productos en alquiler
     * Params: $id (ID del usuario a eliminar)
     * Return: Mensaje de éxito o error
     */
    public function deleteUser(&$id){
        include("_Indexes/Index_Product.php");
        $productController -> liberateProduct($id);
        $this->userModel->deleteUser($id);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Activar o desactivar un usuario
     * Params: $id (ID del usuario), $active (estado de activación)
     * Return: Mensaje de éxito o error
     */
    public function activeUser(&$id, &$active){
        if($this->userModel->activeUser($id, $active)==1)
            return "Usuario activado/desactivado correctamente";
        else
            return "Error al activar/desactivar el usuario";
    }


    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Iniciar sesión de usuario
     * Params: $nombre (nombre de usuario), $contraseña (contraseña del usuario)
     * Return: 1 si el login es exitoso, 0 si las credenciales son incorrectas, -1 si hay un error
     */
    public function loginUser(&$nombre, &$contraseña){
        $nombre = trim($nombre); $contraseña = trim($contraseña);
        $loginControl=$this->userModel->loginUser($nombre, $contraseña);
        
        if($loginControl==1){
            $_SESSION["usuario"]=$nombre;
            $this->userModel->deleteCookies();
        }
        return $loginControl;
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Cerrar sesión de usuario y eliminar cookies
     * Params: No recibe parámetros
     * Return: No devuelve nada, solo destruye la sesión y elimina las cookies
     */
    public function logoutUser(){
        try{
            $this->userModel->deleteCookies();
            session_destroy();
        }catch (Exception $e){
            return "Logout failed.";
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Procesar la subida del avatar de usuario
     * Params: $id (ID del usuario), $file (archivo del avatar)
     * Return: Resultado del procesamiento del avatar
     */
    public function uploadAvatar(&$id, &$file){
        return $this->userModel->avatarProcess($id, $file);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar el número de usuarios
     * Params: No recibe parámetros
     * Return: Número total de usuarios en la base de datos
     */
    public function countUser(){
        return $this->userModel->countUser();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

}
?>