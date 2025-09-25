<?php
class AdminController {
    private $adminModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($adminModel) {
        $this->adminModel = $adminModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /*
     * Función: Mostrar Menu de Logs
     * Params: Ninguno
     * Return: Vista del menú de logs
     */
    public function viewLogMenu(){
        include("Views/Admin_Log_Menu.php");
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /*
     * Función: Crear Base de Datos
     * Params: Ninguno
     * Return: Mensaje de éxito o error
     */
    public function CreateDB() {
        $controlBD=$this->adminModel->CreateDB();

        if($controlBD==1)
            return "Base de Datos creada con éxito";
        else if($controlBD==-1)
            return "Error en la creación de la Base de Datos";
        else if($controlBD==0)
            return "Fallo de conexión con la Base de Datos";
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Eliminar Base de Datos
     * Params: Ninguno
     * Return: Mensaje de éxito o error
     */
    public function DeleteDB() {
        $controlBD=$this->adminModel->DeleteDB();

        if($controlBD==1){
            $files = glob('../assets/img/users/*');
            foreach($files as $file){ if(is_file($file) && basename($file)!="anon.png") unlink($file); }

            $files = glob('../assets/img/products/*');
            foreach($files as $file){ if(is_file($file) && basename($file)!="anon.png") unlink($file); }

            return "Base de Datos eliminada con éxito";
        }else if($controlBD==-1)
            return "Error en la eliminación de la Base de Datos";
        else if($controlBD==0)
            return "Fallo de conexión con la Base de Datos";
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Cargar Datos de la Base de Datos
     * Params: Ninguno
     * Return: Mensaje de éxito o error
     */
    public function DataUpload() {
        $controlBD=$this->adminModel->DataUpload();

        if($controlBD==1)
            return "Datos cargados con éxito";
        else if($controlBD==-1)
            return "Error en la carga de datos";
        else if($controlBD==0)
            return "Fallo de conexión con la Base de Datos";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /*
     * Función: Listar Logs
     * Params: Tipo de log (read o list)
     * Return: Vista de los logs o contenido del log seleccionado
     */
    public function listLog(&$type){        
        if($_GET["type"]=="read"){
            $logControl=$this->adminModel->printLog($_POST["log"]);
        }else{
            $data = json_decode($_COOKIE["search-log"], true);
            $logControl=$this->adminModel->listLog($data, $type);
            include("Views/Admin_Log_View.php");
        }
        return;
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Almacenar Log
     * Params: Ninguno
     * Return: Resultado de la operación de almacenamiento del log
     */
    public function storeLog(){
        return $this->adminModel->storeLog();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

}
?>