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

    /* Función: Recuperar deudas de un alquiler
     * Params: $rId (ID del alquiler)
     * Return: Cantidad total adeudada, 0 si no hay pagos, -1 en caso de error
     */
    public function selectDebtMoney(&$rId){
        try{
            $sql=$this->db->prepare("SELECT SUM(CANTIDAD) AS 'Debt_Money' FROM PAGOS WHERE ALQUILER_ID=?");
            $sql->bindValue(1, $rId, PDO::PARAM_INT);
            $sql->execute();
            
            if($sql->rowCount()!=0)
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            else
                return 0;
        }catch(PDOException $e) {
            return -1;
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar pago
     * Params: $rId (ID del alquiler), $month (mes a pagar), $price (cantidad a pagar)
     * Return: 1 si se inserta correctamente, -1 en caso de error
     */
    public function insertPay(&$rId, &$month, &$price){
        try{
            $date=date("Y-m-d H:i:s");
            
            $sql=$this->db->prepare("INSERT INTO PAGOS (FECHA_HORA, CANTIDAD, MESES_EXTRA, ALQUILER_ID) VALUES (?, ?, ?, ?)");
            $sql->bindValue(1, $date,  PDO::PARAM_STR);
            $sql->bindValue(2, $price, PDO::PARAM_INT);
            $sql->bindValue(3, $month, PDO::PARAM_INT);
            $sql->bindValue(4, $rId,   PDO::PARAM_INT);
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