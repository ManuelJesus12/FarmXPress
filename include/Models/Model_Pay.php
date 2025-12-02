<?php
class PayModel {
    public $db;

    ///////////////////////////////////////////////////////////////
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar todos los Pagos realizados para un alquiler
     * Params: $rId (ID del alquiler)
     * Return: Consulta con todos los datos, -1 en caso de error
     */
    public function selectPay(&$rId){
        try{
            $sql=$this->db->prepare("SELECT * FROM Pagos WHERE Alquiler_ID=? ORDER BY Fecha_Hora DESC");
            $sql->bindValue(1, $rId, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount()!=0) return $sql->fetchAll(PDO::FETCH_ASSOC);
            else return 0;
        }catch(Exception $e){
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar pago
     * Params: $rId (ID del alquiler), $month (mes a pagar), $price (Cantidad a pagar)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertPay(&$rId, &$month, &$price){
        try{
            $sql=$this->db->prepare("INSERT INTO Pagos (Fecha_Hora, Cantidad, Meses_Extra, Alquiler_ID) VALUES (NOW(), ?, ?, ?)");
            $sql->bindValue(1, $price, PDO::PARAM_INT);
            $sql->bindValue(2, $month, PDO::PARAM_INT);
            $sql->bindValue(3, $rId,   PDO::PARAM_INT);
            $sql->execute();
            
            return 1;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>