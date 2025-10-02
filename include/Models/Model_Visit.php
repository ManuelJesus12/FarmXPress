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

    /* Función: Listar visitas
     * Params: No recibe parámetros, utiliza la sesión para verificar el acceso
     * Return: Página de lista de visitas si el usuario es administrador, 0 si no hay visitas
     */
    public function listVisit(){
        $sql=$this->db->query("SELECT NOMBRE, EMAIL, CIF, TELÉFONO, DIRECCIÓN, TIPO, RUTA, FECHA_HORA FROM USUARIOS JOIN VISITAS ON USUARIOS.USUARIO_ID=VISITAS.USUARIO_ID"); 
        if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
        else return 0;
    }
    
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar una nueva visita
     * Params: No recibe parámetros, utiliza la sesión para obtener el nombre del usuario
     * Return: No devuelve nada, solo inserta la visita en la base de datos
     */
    public function insertVisit(){
        $date=date("Y-m-d H:i:s");
        $url=explode("/",$_SERVER["PHP_SELF"]); $url=$url[count($url)-1];
        if($_SERVER["QUERY_STRING"]!="") $url.="?".$_SERVER["QUERY_STRING"];
        
        $sql=$this->db->prepare("INSERT INTO VISITAS (RUTA, FECHA_HORA, USUARIO_ID) VALUES (?, ?, (SELECT USUARIO_ID FROM USUARIOS WHERE NOMBRE = ?))");
        $sql->bindParam(1, $url);
        $sql->bindParam(2, $date);
        $sql->bindParam(3, $_SESSION["usuario"], PDO::PARAM_STR);
        $sql->execute();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>