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
    public function viewRegister(){
        require_once 'Views/View_User_Register.php';
    }
    public function viewUpdate(){
        require_once 'Views/View_User_Register.php';
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    
    /* Función: Ver lista de usuarios
     * Params: $offset (paginación)
     * Return: Página de lista de usuarios o control de usuario si se llama desde el administrador.
     */
    public function viewListUser(&$offset){
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR"){
            $offset--;
            
            if($offset>=0 || isset($_GET["methodAdmin"])){
                $userControl=$this->userModel->listUser($offset);
                if(!isset($_GET["methodAdmin"])){
                    include("Views/View_List_User.php");
                    return 1;
                }else
                    return $userControl;
            
            }else
                header("Location: principal.php?methodUser=select&page=1");
        }else
            echo "<h2>Acceso a esta sección denegado</h2>";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un usuario por campo y valor
     * Params: $field (campo a buscar), $value (valor a buscar)
     * Return: Array con el usuario encontrado, 0 si no hay usuarios, -1 en caso de error
     */
    public function selectUser(&$field, &$value){
        return $this->userModel->selectUser($field, $value);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un nuevo usuario
     * Params: No recibe parámetros, utiliza los datos de la cookie "data-user"
     * Return: Redirección a la vista de lista de usuarios o login según el tipo de usuario
     */
    public function insertUser(){
        try{

            if(isset($_COOKIE["data-user"])){
                $data = json_decode($_COOKIE["data-user"], true);
            
                if($this->userModel->insertUser($data)==1){
                    setcookie("user-avatar", 0, time()-1,"/");

                    if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR")
                        header("Location: principal.php?methodUser=select&action=insert");
                    else
                        $this->loginUser($data[2], $data[3]);
                
                }else
                    return "Error al registrar el usuario, datos incompletos o incorrectos.";
            }else
                return "No se han recibido datos para el registro de usuario.";
            
        }catch (Exception $e) {
            return "Error al registrar el usuario";
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un usuario existente
     * Params: No recibe parámetros, utiliza los datos de la cookie "data-user"
     * Return: Redirección a la vista de lista de usuarios o al index según el tipo de usuario
     */
    public function updateUser(){
        if(isset($_COOKIE["data-user"])){
            if(isset($_GET['userId']) && $_GET['userId']!=null) $id=$_GET['userId']; 
            else{
                $field="Nombre";
                $id=$this->selectUser($field, $_SESSION["usuario"])[0]['Usuario_ID'];
            }

            $data = json_decode($_COOKIE["data-user"], true);
            if($this->userModel->updateUser($id, $data)==1){
                setcookie("user-avatar", 0, time()-1,"/");

                if($_SESSION["usuario"]!="ADMINISTRADOR") $_SESSION["usuario"]=$data[2];
                if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR")
                    header("Location: principal.php?methodUser=select&action=update");
                else
                    header("Location: ../index.php?action=2");
            }
        }else
            return "No se han recibido datos para actualizar el usuario.";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Eliminar un usuario
     * Params: $id (ID del usuario a eliminar)
     * Return: Mensaje de éxito o error
     */
    public function deleteUser(&$id){
        include("_Indexes/Index_Product.php");
        $productController -> activeByUser($id);
        $this->userModel->deleteUser($id)==1;
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
        try{
            $nombre = trim($nombre); $contraseña = trim($contraseña);
            $loginControl=$this->userModel->loginUser($nombre, $contraseña);

            if($loginControl==1) $_SESSION["usuario"]=$nombre;
            return $loginControl;
        }catch (Exception $e){
            return "Login failed.";
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Cerrar sesión de usuario y eliminar cookies
     * Params: No recibe parámetros
     * Return: No devuelve nada, solo destruye la sesión y elimina las cookies
     */
    public function logoutUser(){
        try{
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time()-1, '/');
                }
            }
            echo "<script>localStorage.clear();</script>";
            
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