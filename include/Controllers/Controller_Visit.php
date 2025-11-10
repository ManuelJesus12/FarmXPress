<?php
class VisitController {
    private $visitModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($visitModel) {
        $this->visitModel = $visitModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Listar visitas
     * Params: No recibe parámetros, utiliza la sesión para verificar el acceso
     * Return: Página de lista de visitas si el usuario es administrador, mensaje de acceso denegado en caso contrario
     */
    public function listVisit(){
        if(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]=="ADMINISTRADOR"){
            $controlVisit = $this->visitModel->listVisit();
            include("Views/View_List_Visit.php");
            return 1;
        }else
            echo "<h2>Acceso a esta sección denegado</h2>";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una nueva visita
     * Params: No recibe parámetros, utiliza la sesión para obtener el nombre del usuario
     * Return: No devuelve nada, solo inserta la visita en la base de datos
     */
    public function insertVisit(){
        $this->visitModel->insertVisit();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>