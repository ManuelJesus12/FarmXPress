<?php
class PayController {
    public $payModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($payModel) {
        $this->payModel = $payModel;
    }
    ///////////////////////////////////////////////////////////////

    public function viewStripe(){
        include("Views/_Stripe_Payment.php");
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar todos los pagos realizados para un alquiler
     * Params: $rId (ID del alquiler)
     * Return: Consulta con todos los datos, -1 en caso de error
     */
    public function selectPay(&$rId){
        return $this->payModel->selectPay($rId);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar pago
     * Params: $rId (ID del alquiler), $mPrice (precio del mes), $month (mes a pagar), $amount (cantidad a pagar, por defecto 0)
     * Return: Redirección a la página principal con éxito o error, o mensaje de éxito/error
     */
    public function insertPay(&$rId, &$mPrice, &$month, &$amount=0){
        if($this->payModel->insertPay($rId, $month, $amount)==1){
            if($month!="" && !isset($_COOKIE["data-rent"])){
                include("_Indexes/Index_Rent.php");
                $rentController->updateRent($month, $mPrice, $rId);
            }

            if(isset($_GET["methodRent"])) return 1;
            else if(isset($_GET["methodPay"])){
                setcookie("data-pay", "", time() - 3600, "/");
                header("Location: principal.php?methodRent=select&page=1&success=1");
            }else return "Pago realizado correctamente";
        }else{
            if(isset($_GET["methodPay"]))
                header("Location: principal.php?methodRent=select&page=1&success=0");
            else return "Error al realizar el pago";
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

}
?>