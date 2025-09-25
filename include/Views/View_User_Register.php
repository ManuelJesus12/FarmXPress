<!-------------------------------LOGIC------------------------------->
<?php
    $email=$cif=$name=$passwd=$phone=$address="";
    include("_Indexes/Index_User.php");

    if(in_array("viewUpdate", $methods)){
        $action="principal.php?methodUser=update";
        $title="Actualizar Usuario"; $field="Nombre";

        $userData=$userController->selectUser($field, $_SESSION["usuario"]);
        $userId=$userData[0]['Usuario_ID'];
        $email=$userData[0]['Email']; $cif=$userData[0]['CIF'];
        $name=$userData[0]['Nombre']; $phone=$userData[0]['Teléfono']; 
        $address=$userData[0]['Dirección'];
    }else{
        $action="principal.php?methodUser=insert-login";
        $title="Registro de Usuario";
    }
?>
<!-------------------------------LOGIC------------------------------->

<!-------------------------------FORM------------------------------->
<article class="col-6 form-log site-section rounded pb-2">
    <?php echo "<h2>$title</h2>"; ?>

    <table class="table-form" style="margin:auto">
        <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data' id="form-data-user">
            <?php if(in_array("viewUpdate", $methods)){ ?>
                <tr>
                    <td colspan="2"><input type="hidden" name="userId" id="userId" value="<?php echo $userId ?>" /></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Email: <span class="error">*</span></td>
                <td><input type="email" placeholder="ejemplo@gmail.com" name="email" id="email" value="<?php echo $email; ?>" required /></td>
            </tr>
            <tr>
                <td>CIF: <span class="error">*</span></td>
                <td><input type="text" placeholder="Ejemplo de CIF: A12345678" name="cif" id="cif" value="<?php echo $cif; ?>" required /></td>
            </tr>
            <tr>
                <td>Nombre: <span class="error">*</span></td>
                <td><input type="text" placeholder="Nombre de Empresa" name="name" id="name" value="<?php echo $name; ?>" required /></td>
            </tr>
            <?php if($_GET["methodUser"]=="viewRegister"){ ?>
                <tr>
                    <td>Contraseña: <span class="error">*</span></td>
                    <td><input type="password" placeholder="Ejemplo de contraseña" name="password" id="password" value="<?php echo $passwd; ?>" required /></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Teléfono: <span class="error">*</span></td>
                <td><input type="text" placeholder="Ejemplo de teléfono: 123456789" name="phone" id="phone" value="<?php echo $phone; ?>" required /></td>
            </tr>
            <tr>
                <td>Dirección: <span class="error">*</span></td>
                <td><input type="text" placeholder="Ejemplo de Dirección" name="address" id="address" value="<?php echo $address; ?>" required /></td>
            </tr>
                <?php if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR"){ ?>
                <tr>
                    <td>Tipo: </td>
                    <td><select name="tipo" id="tipo" required>
                        <option value="P">Proveedor</option>
                        <option value="C">Cliente</option>
                    </select></td>
                </tr>
                <?php } ?>
            <tr>
                <td>Avatar: </td>
                <td><input type="file" name="avatar" id="avatar" /></td>
            </tr>
            <?php if(in_array("viewRegister", $methods)){ ?>
            <tr>
                <td><input type="checkbox" name="terms" id="terms" /></td>
                <td><span>Acepto los <a href="../index.php?view=legal">Términos y Condiciones</a> y la <a href="../index.php?view=privacy">Política de Privacidad</a></span></td>
            </tr>
            <?php } ?>
            <tr><td colspan="2"><input type="button" class="btn-log element-green-bg" id="btn-data-user" value="Enviar" /></td></tr>
            <tr>
                <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
            </tr>
            <?php if(in_array("viewRegister", $methods)){ ?>
                <tr>
                    <td colspan="2">¿Ya tienes una cuenta? <a href="principal.php?methodUser=viewLogin">Iniciar Sesión</a></td>
                </tr>
                <tr>
                    <td colspan="2">¿Deseas ser uno de nuestros Proveedores? <a href="../index.php?view=contact">Contáctanos</a></td>
                </tr>
            <?php } ?>
        </form>
    </table>
</article>
<!-------------------------------FORM------------------------------->


    <!-------------------------------SCRIPT------------------------------->
    <script src="../assets/js/form_user_validation.js"></script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>