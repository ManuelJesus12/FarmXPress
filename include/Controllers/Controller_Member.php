<?php
class MemberController {
    private $memberModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($memberModel) {
        $this->memberModel = $memberModel;
    }
    ///////////////////////////////////////////////////////////////

    public function viewStripe(){
        include("Views/_Stripe_Payment.php");
    }

    ///////////////////////////////////////////////////////////////
    
    public function viewUpdateMember(){
        $member=$this->selectMember();
        include("Views/Form_Upd_Member.php");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Listar Miembros
     * Params: Ninguno
     * Return: Datos de la membresia
     */
    public function selectMember(){
        return $this->memberModel->selectMember();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar Membresia
     * Params: Ninguno
     * Return: Redirección con mensaje de éxito o error
     */
    public function insertMember(&$sId){
        $action = ($this->memberModel->insertMember($sId)==1) ? 1 : -1;
        header("Location: principal.php?methodSub=select&page=1&action=$action");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar Membresia
     * Params: $month (referenciado para actualizar)
     * Return: Redirección con mensaje de éxito o error
     */
    public function updateMember(&$month){
        $action = ($this->memberModel->updateMember($month)==1) ? 2 : -2;
        header("Location: principal.php?methodSub=select&page=1&action=$action");
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Desactivar Envio de Email de Membresia
     * Params: $id (referenciado para actualizar)
     * Return: Estado de la operación
     */
    public function toggleMailBoolMember(&$id){
        return $this->memberModel->toggleMailBoolMember($id);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Desactivar Membresia
     * Params: Ninguno
     * Return: Desactiva las membresias caducadas y notifica a los usuarios con membresias próximas a caducar
     */
    public function activeMember(){
        $memberControl=$this->memberModel->listMember();

        if(is_array($memberControl)){
            foreach($memberControl as $mem){
                $diffDays=(strtotime($mem["Fecha_Fin"]) - strtotime(date("Y-m-d")))/86400;

                if($diffDays<=0){ //Desactivar membresia
                    $this->memberModel->activeMember($mem["Membresia_ID"]);
                    if(isset($_SESSION["User"]) && $mem["UNOM"]==$_SESSION["User"]["Nombre"]) 
                        echo "<script>showBoxActiveMember('".$mem["SNOM"]."')</script>";

                }else if($diffDays>0 && $diffDays<5){ //Enviar Email
                    $this->memberModel->sendMemberEmail($mem["Email"], $mem["UNOM"], $mem["SNOM"]);
                    $this->toggleMailBoolMember($mem["Membresia_ID"]);
                }
            }
        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar Membresias
     * Params: Ninguno
     * Return: Número total de Membresias
     */
    public function countMember(){
        return $this->memberModel->countMember();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>