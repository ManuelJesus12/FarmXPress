<?php
class RentController {
    public $rentModel;

    ///////////////////////////////////////////////////////////////
    public function __construct($rentModel) {
        $this->rentModel = $rentModel;
    }
    ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Ver página de pago con Stripe
     * Params: Void
     * Return: Página de pago con Stripe.
     */
    public function viewStripe(){
        include("Views/_Stripe_Payment.php");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Ver lista de alquileres de un usuario
     * Params: $offset (paginación)
     * Return: Página de lista de alquileres.
     */
    public function viewListRent(&$offset){
        $offset--;
        if($offset>=0){
            $rentControl = $this->rentModel->listRent($offset);
            if(isset($_GET["methodRent"]) && $_GET["methodRent"]=="select") include("Views/Client_List_Rent.php");
        }else  header("Location: principal.php?methodRent=select&page=1");
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar un alquiler por ID de producto
     * Params: $pId (ID del producto)
     * Return: Array con los alquileres encontrados, 0 si no hay alquileres, -1 en caso de error
     */
    public function selectRent(&$pId){
        return $this->rentModel->selectRent($pId);
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Seleccionar el último alquiler realizado
     * Params: Void
     * Return: Array con el último alquiler, 0 si no hay alquileres, -1 en caso de error
     */
    public function selectLastRent(){
        return $this->rentModel->selectLastRent();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un nuevo alquiler junto al primer pago y desactivar el producto alquilado
     * Params: $pId (ID del producto), $month (meses de alquiler), $price (precio del alquiler)
     * Return: Mensaje de éxito o error
     */
    public function insertRent(&$pId, &$month, &$price){
        if(isset($pId) && isset($month) && isset($price) && $pId!="" && $month!="" && $price!=""){
            include("_Indexes/Index_Product.php"); 
            $field="Producto_ID"; $active=0;

            if($productController -> selectProduct($field, $pId)[0]["Estado"]==0)
                header("Location: principal.php?methodProd=viewProduct&id=".$pId."&success=0");
            else{
                if($this->rentModel->insertRent($pId, $month, $price)==1){
                    $productController -> activeProduct($pId, $active);
                    $rentControl=$this->selectLastRent();

                    include("_Indexes/Index_Pay.php");
                    if($payController->insertPay($rentControl[0]["Alquiler_ID"], $price, $month, $price)==1){
                        setcookie("data-rent", 0, time() - 3600, "/");
                        include("Views/Client_Rent_Ok.php");
                    }

                }else
                    return "Error al alquilar producto.";
            }
        }else
            return "Error inesperado";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Actualizar un alquiler existente
     * Params: $month (meses extra de alquiler), $mPrice (precio mensual del producto alquilado), $rId (ID del alquiler)
     * Return: Mensaje de éxito o error
     */
    public function updateRent(&$month, &$mPrice, &$rId){
        if(isset($_GET['methodRent']) && !isset($_GET['methodPay'])) $mPrice=0;
        
        if($this->rentModel->updateRent($month, $mPrice, $rId)==1)
            return "Suscripción actualizada correctamente";
        else
            return "Error al actualizar la subscripción";
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Desactivar un alquiler
     * Params: $rId (ID del alquiler), $pId (ID del producto)
     * Return: Mensaje de éxito o error
     */
    public function activeRent(&$rId, &$pId){
        $rentControl = $this->rentModel->activeRent($rId);
        if($rentControl==1){
            include("_Indexes/Index_Product.php");   $active=1;
            $productController -> activeProduct($pId, $active);

            return 1;
        }else
            return "Error inesperado";
    }

    ///////////////////////////////////////////////////////////////

    /* Función: Comprobar si hay alquileres que deberían desactivarse y notificar al usuario
     * Params: $offset (paginación) seteado por referencia a -1 lo cual selecciona todos los alquileres del usuario
     * Return: Notificación de alquiler activo si corresponde
     */
    public function checkActiveRent(&$offset=-1){
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="ADMINISTRADOR"){
            $rentControl = $this->rentModel->listRent($offset);
            
            if(is_array($rentControl)){
                foreach($rentControl as $rent){
                    $timeDiffFin=strtotime($rent["Fecha_Fin"]) - strtotime(date("Y-m-d H:i:s"));

                    if($timeDiffFin<=0){
                        if($this->activeRent($rent["Alquiler_ID"], $rent["PID"])==1){
                            ?> <script>showBoxActiveRent( "<?php echo $rent["Nombre"]; ?>" );</script>  <?php
                        }
                    }
                }
            }

        }
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Contar el número total de alquileres
     * Params: Void
     * Return: Número total de alquileres
     */
    public function countRent(){
        return $this->rentModel->countRent();
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
}
?>