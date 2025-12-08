<?php
class AdminModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /*
     * Función: Crear Base de Datos
     * Params: Ninguno
     * Return: 1 si se creó correctamente, 0 si hubo un fallo de conexión, -1 si hubo un error en la creación
     */
    public function createDB(){
        try{
            try{
                $pdo = new PDO("mysql:host=localhost", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = file_get_contents('../assets/FarmXPress_BD.sql');
                $statements = array_filter(array_map('trim', explode(';', $sql)));
                foreach ($statements as $stmt) {
                    if (!empty($stmt)) $pdo->exec($stmt);
                }

                return 1;
            }catch(PDOException $f) {
                return 0;
            }
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Eliminar Base de Datos
     * Params: Ninguno
     * Return: 1 si se eliminó correctamente, 0 si hubo un fallo de conexión, -1 si hubo un error en la eliminación
     */
    public function DeleteDB(){
        try{
            try{
                if(!$this->db) throw new Exception ("Error en la eliminacion de la Base de Datos");
                $this->db->exec("DROP DATABASE FARMXPRESS");

                return 1;
            }catch(PDOException $e) {
                return 0;
            }
        }catch(Exception $f) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Cargar Datos de la Base de Datos
     * Params: Ninguno
     * Return: 1 si se cargaron correctamente, 0 si hubo un fallo de conexión, -1 si hubo un error en la carga
     */
    public function DataUpload(){
        try{
            try{
                $sql = file_get_contents('../assets/FarmXPress_Data.sql');
                $statements = array_filter(array_map('trim', explode(';', $sql)));
                foreach ($statements as $stmt) {
                    if (!empty($stmt)) $this->db->exec($stmt);
                }

                return 1;
            }catch(PDOException $f) {
                return 0;
            }
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /*
     * Función: Listar Logs
     * Params: Array de datos de búsqueda y tipo de log (rent o visit)
     * Return: Array con los registros encontrados o 0 si no hay registros
     */
    public function listLog(&$data, &$type){
        try{
            $placeholder="%";
            //*-----------------------------QUERY BUILD------------------------------*//
            if($type=="rent")
                $query="SELECT U.Usuario_ID AS 'UID', U.Nombre AS 'UNOM', CIF, A.Alquiler_ID, P.Nombre AS 'PID', Fecha_Inicio, Fecha_Fin, Precio_Total, A.Estado AS 'Estado' FROM Alquileres A JOIN Usuarios U ON A.Usuario_ID=U.Usuario_ID JOIN Productos P ON A.Producto_ID=P.Producto_ID";
            else if($type=="visit")
                $query="SELECT U.Usuario_ID AS 'UID', Nombre, CIF, Ruta, Fecha_Hora FROM Visitas V JOIN Usuarios U ON V.Usuario_ID=U.Usuario_ID";
            $query.= " WHERE U.Usuario_ID LIKE ?";

            if($data[1]!="" || $data[2]!=""){
                if($type=="visit"){
                    if($data[1]!="") $query.=" AND FECHA_HORA>=?";
                    if($data[2]!="") $query.=" AND FECHA_HORA<=?";
                }
                else if($type=="rent"){
                    if($data[1]!="") $query.=" AND FECHA_INICIO>=?";
                    if($data[2]!="") $query.=" AND FECHA_FIN<=?";
                }
            }
            //*-----------------------------QUERY BUILD------------------------------*//

            //*-----------------------------QUERY BIND------------------------------*//
            $sql = $this->db->prepare($query);
            if($data[0]!="") $sql->bindParam(1, $data[0]); else $sql->bindValue(1, $placeholder);
            if($data[1]!="" && $data[2]!=""){
                $sql->bindParam(2, $data[1]);
                $sql->bindParam(3, $data[2]);
            }else if($data[1]!="" && $data[2]=="") 
                $sql->bindParam(2, $data[1]);
            else if($data[2]!="" && $data[1]=="")
                $sql->bindParam(2, $data[2]);
            //*-----------------------------QUERY BIND------------------------------*//

            $sql->execute();
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            else
                return 0;
        }catch(Exception $e){
            return 0;
        }
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Imprimir Log
     * Params: Nombre del log a imprimir
     * Return: Imprime el contenido del log en una tabla HTML
     */
    public function printLog(&$name){
        echo "<article class='col-12 list-log form-log site-section rounded'>";
            if(str_contains($name, "Visitas"))
                echo "<table class='table table-striped'><thead><tr><th>Usuario ID</th><th>Nombre</th><th>CIF</th><th>Fecha y Hora</th><th>Ruta</th></tr></thead><tbody>";
            else if(str_contains($name, "Alquileres"))
                echo "<table class='table table-striped'><thead><tr><th>Usuario ID</th><th>Nombre Usuario</th><th>CIF</th><th>Alquiler ID</th><th>Nombre Producto</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Precio Total</th><th>Estado</th></tr></thead><tbody>";
            
            $f1 = fopen("../logs/".$name, "r+");
            while(!feof($f1)){
                $vis = explode(",",unserialize(trim(fgets($f1))));
                echo "<tr>";
                for($i=0;$i<count($vis);$i++) echo "<td>".$vis[$i]."</td>";
                echo "</tr>";
            }
        echo "</tbody></table></article>";
    }

    ///////////////////////////////////////////////////////////////

    /*
     * Función: Almacenar Log
     * Params: Tipo de log (visit o rent) y array de datos a almacenar
     * Return: Almacena los datos en un archivo de log correspondiente
     */    
    public function storeLog(){
        if($_POST["type"]=="visit")
            $name="../logs/Visitas_".date("Y-m-d").".txt";
        else if($_POST["type"]=="rent")
            $name="../logs/Alquileres_".date("Y-m-d").".txt";

        $f1 = fopen($name, "w+");
        foreach ($_POST["sql"] as $valores) {
            if($_POST["type"]=="visit")
                $string=$valores["UID"].",".$valores["Nombre"].",".$valores["CIF"].",".$valores["Fecha_Hora"].",".$valores["Ruta"].",";
            else if($_POST["type"]=="rent")
                $string=$valores["UID"].",".$valores["UNOM"].",".$valores["CIF"].",".$valores["Alquiler_ID"].",".$valores["PID"].",".$valores["Fecha_Inicio"].",".$valores["Fecha_Fin"].",".$valores["Precio_Total"].",".$valores["Estado"].",";
            $vis = serialize(new Visit($string));

            if($count==0) fputs($f1,$vis); else fputs($f1,"\n".$vis);
            $count++;
        }
        fclose($f1);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    public function contact(&$mail, &$name, &$subject, &$body){
        try{
            require_once '../assets/vendor/PHPMailer/src/PHPMailer.php';
            require_once '../assets/vendor/PHPMailer/src/SMTP.php';
            require_once '../assets/vendor/PHPMailer/src/Exception.php';
            
            $phpmailer =  new \PHPMailer\PHPMailer\PHPMailer;
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = 587;
            $phpmailer->Username = 'farmxpress0@gmail.com';
            $phpmailer->Password = 'btrh raeq lpko zlxk';
            $phpmailer->setFrom($mail, $name);
            $phpmailer->addAddress('farmxpress0@gmail.com', 'FarmXPress Admin');
            $phpmailer->isHTML(true);
            $phpmailer->Subject = $subject;
            $phpmailer->Body = "<h2>Email de $mail - $name<h2><br><br>".$body;
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
}

///////////////////////////////////////////////////////////////
class Visit{
    public $string;

    //CONSTRUCTOR
    public function __construct(&$string) {
        $this->string = $string;
    }

    public function __toString(){
        return $this->string;
    }
}
///////////////////////////////////////////////////////////////
?>