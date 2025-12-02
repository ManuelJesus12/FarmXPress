<?php
class UserController {
    private $userModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
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
        if(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]=="ADMINISTRADOR"){
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
     * Params: No recibe parámetros
     * Return: Redirección a la vista de lista de usuarios o login según el tipo de usuario
     */
    public function insertUser(){
        include("../assets/php/vBackEndUser.php");
        if($this->userModel->insertUser($data)==1){
            if(!isset($_SESSION["User"])){
                $this->loginUser($_POST['name'], $_POST['password']);
                $this->userModel->sendRegisterMail($data[0], $data[2]);
                header("Location: ../index.php?action=1");
            }else header("Location: principal.php?methodUser=select&action=insert");
        }
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un usuario existente
     * Params: No recibe parámetros, utiliza los datos de la cookie "data-user"
     * Return: Redirección a la vista de lista de usuarios o al index según el tipo de usuario
     */
    public function updateUser(){
        include("../assets/php/vBackEndUser.php");
        if($this->userModel->updateUser($_POST['userId'], $data)==1){
            if ($_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){
                $_SESSION["User"]["Email"] =$data[0];
                $_SESSION["User"]["Nombre"]=$data[2];
                $_SESSION["User"]["Avatar"]=$data[9];
                header("Location: ../index.php?action=2");
            }else
                header("Location: principal.php?methodUser=select&action=update");
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
        return $this->userModel->activeUser($id, $active);
    }

    public function validateUser(){
        $this->userModel->validateUser();
        header("Location: ../index.php?action=3");
    }


    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Iniciar sesión de usuario
     * Params: $nombre (nombre de usuario), $contraseña (contraseña del usuario)
     * Return: 1 si el login es exitoso, 0 si las credenciales son incorrectas, -1 si hay un error
     */
    public function loginUser(&$nombre, &$contraseña){
        $nombre = trim($nombre); $contraseña = trim($contraseña); $field="Nombre";
        $loginControl=$this->userModel->loginUser($nombre, $contraseña);

        if($loginControl==1){
            if($nombre!='ADMINISTRADOR'){
                $user = $this->selectUser($nombre, $field);
                $_SESSION["User"]=$user;
            }else{
                $_SESSION["User"]["Nombre"]="ADMINISTRADOR";
                $_SESSION["User"]["Tipo"]="C";
            }
        }
        return $loginControl;
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Cerrar sesión de usuario y eliminar cookies
     * Params: No recibe parámetros
     * Return: No devuelve nada, solo destruye la sesión y elimina las cookies
     */
    public function logoutUser(){
        setcookie("search-options", 0, time()-1, "/");
        session_destroy();
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