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
    public function viewListRent(){
        $rentControl = $this->rentModel->listRent();
        if(isset($_GET["methodRent"]) && $_GET["methodRent"]=="select") include("Views/Client_List_Rent.php");
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
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Insertar un nuevo alquiler junto al primer pago y desactivar el producto alquilado
     * Params: $pId (ID del producto), $month (meses de alquiler), $price (precio del alquiler)
     * Return: Mensaje de éxito o error
     */
    public function insertRent(&$pId, &$month, &$price){
        if(isset($pId) && isset($month) && isset($price) && $pId!="" && $month!="" && $price!=""){ // Datos recibidos correctamente
            include("_Indexes/Index_Product.php");
            include("_Indexes/Index_User.php");
            include("_Indexes/Index_Pay.php");
            $mailType= 1;
            $product = $productController -> selectProduct($pId); // Datos del Producto
            $user    = $userController -> selectUser($product["Usuario_ID"]); // Datos del Proveedor del Producto

            if($product["Estado"]==1){
                if($this->rentModel->insertRent($pId, $month, $price)==1){ // Insertar Alquiler
                    $rentID=$this->rentModel->db->lastInsertId(); // ID del Alquiler insertado
                    $productController -> activeProduct($pId); // Desactivar Disponibilidad Producto

                    if($payController->insertPay($rentID, $price, $month, $price)==1){ // Insertar Primer Pago
                        $this -> rentModel->sendRentEmail($user["Email"], $product["Nombre"], $mailType); // Enviar correo al Proveedor del Producto
                        $rentControl = $this->rentModel->selectRent($pId); // Datos del Alquiler para visualizar
                        include("Views/Client_Rent_Ok.php");

                        setcookie("data-rent", 0, time() - 3600, "/");
                    }

                }else return "Error al alquilar producto.";
            }else header("Location: principal.php?methodProd=viewProduct&id=".$pId."&success=0");
        }else return "Error inesperado";
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

    /* Función: Desactivar un alquiler y reactivar producto
     * Params: $rId (ID del alquiler), $pId (ID del producto)
     * Return: Mensaje de éxito o error
     */
    public function activeRent(&$rId, &$pId){
        include("_Indexes/Index_Product.php");
        include("_Indexes/Index_User.php");
        $mailType= 0; $active=1;
        $producto=$productController->selectProduct($pId); //Recoger datos producto
        $usuario=$userController->selectUser($producto["Proveedor_ID"]); //Recoger datos proveedor

        $rentControl = $this->rentModel->activeRent($rId); //Desactivar alquiler 
        $productControl=$productController->activeProduct($pId, $active); //Reactivar Producto
        $this->sendRentEmail($usuario["Email"], $producto["Nombre"], $mailType);  //Enviar correo al proveedor
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

    /* Función: Recabar información de los Alquileres de un Producto
     * Params: $id (ID del producto)
     * Return: Consulta si se activa correctamente, 0 en caso de no encontrar datos y -1 en caso de error
     */
    public function listRentDataByProduct(&$id){
        return $this->rentModel->listRentDataByProduct($id);
    }
    
    public function listRentStatsByProduct(&$id){
        return $this->rentModel->listRentStatsByProduct($id);
    }

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////

    /* Función: Comprobar si hay alquileres que deberían desactivarse y notificar al usuario
     * Params: $offset (paginación) seteado por referencia a -1 lo cual selecciona todos los alquileres del usuario
     * Return: Notificación de alquiler activo si corresponde
     */
    public function checkActiveRent(&$offset=-1){
        if(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){
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
}
?>