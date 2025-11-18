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
     * Return: Datos de la membresía
     */
    public function selectMember(){
        return $this->memberModel->selectMember();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar Membresía
     * Params: Ninguno
     * Return: Redirección con mensaje de éxito o error
     */
    public function insertMember(&$sId){
        if($this->memberModel->insertMember($sId)==1)
            header("Location: principal.php?methodSub=select&page=1&action=1");
        else
            header("Location: principal.php?methodSub=select&page=1&action=-1");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar Membresía
     * Params: $month (referenciado para actualizar)
     * Return: Redirección con mensaje de éxito o error
     */
    public function updateMember(&$month){
        if($this->memberModel->updateMember($month)==1)
            header("Location: principal.php?methodSub=select&page=1&action=2");
        else
            header("Location: principal.php?methodSub=select&page=1&action=-2");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Desactivar Membresía
     * Params: Ninguno
     * Return: Mensaje de éxito o error al desactivar la membresía
     */
    public function activeMember(){
        $member=$this->selectMember();
        if(is_array($member) && $member["Fecha_Fin"]<date("Y-m-d H:i:s")){
            if($this->memberModel->activeMember($member["Membresía_ID"])==1)
                ?> <script>showBoxActiveMember("<?php echo $member["Nombre"]; ?>")</script> <?php
        }else
            return 0;
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar Membresías
     * Params: Ninguno
     * Return: Número total de Membresías
     */
    public function countMember(){
        return $this->memberModel->countMember();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>