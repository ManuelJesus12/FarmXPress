<?php
class VisitModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Funcion: Listar Visitas
     * Params: No recibe parámetros, utiliza la sesion para verificar el acceso
     * Return: Página de lista de Visitas si el usuario es administrador, 0 si no hay Visitas
     */
    public function listVisit(){
        $sql=$this->db->query("SELECT Nombre, Email, Cif, Telefono, Direccion, Tipo, Ruta, Fecha_Hora FROM Usuarios JOIN Visitas ON Usuarios.Usuario_ID=Visitas.Usuario_ID"); 
        if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
        else return 0;
    }
    
    ///////////////////////////////////////////////////////////////

    /* Funcion: Insertar una nueva visita
     * Params: No recibe parámetros, utiliza la sesion para obtener el Nombre del usuario
     * Return: No devuelve nada, solo inserta la visita en la base de datos
     */
    public function insertVisit(){
        $date=date("Y-m-d H:i:s");
        $url=explode("/",$_SERVER["PHP_SELF"]); $url=$url[count($url)-1];
        if($_SERVER["QUERY_STRING"]!="") $url.="?".$_SERVER["QUERY_STRING"];
        
        $sql=$this->db->prepare("INSERT INTO Visitas (Ruta, Fecha_Hora, Usuario_ID) VALUES (?, ?, (SELECT Usuario_ID FROM Usuarios WHERE Nombre = ?))");
        $sql->bindParam(1, $url);
        $sql->bindParam(2, $date);
        $sql->bindParam(3, $_SESSION["User"]["Nombre"], PDO::PARAM_STR);
        $sql->execute();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>