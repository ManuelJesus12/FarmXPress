<!-------------------------------LOGIC------------------------------->
<?php
    $userData=['Usuario_ID'=>'', 'Nombre'=>'', 'CIF'=>'', 'Email'=>'', 'Contraseña'=>'', 'Teléfono'=>'', 'Dirección'=>''];
    
    if($_GET["methodUser"]=="viewUpdate"){
        $title="Actualizar Usuario"; $field="Nombre";
        $userData=$this->selectUser($_SESSION["usuario"], $field);
        $action="principal.php?methodUser=update";
    }else{
        $action="principal.php?methodUser=insert-login";
        $title="Registro de Usuario";
    }
?>
<!-------------------------------LOGIC------------------------------->

<!-------------------------------FORM------------------------------->
<article class="col-8 form-log site-section rounded pb-2">
    <?php echo "<h2>$title</h2>"; ?>

    <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data' id="form-data-user">
        <table class="table-form" style="margin:auto">
            <?php if($_GET["methodUser"]=="viewUpdate"){ ?>
                <tr>
                    <td colspan="2"><input type="hidden" name="userId" id="userId" class="input-form" value="<?php echo $userData["Usuario_ID"] ?>" /></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Email: <span class="error">*</span></td>
                <td><input type="email" placeholder="ejemplo@gmail.com" name="email" id="email" class="input-form" value="<?php echo $userData["Email"]; ?>" required /></td>
            </tr>
            <tr>
                <td>CIF: <span class="error">*</span></td>
                <td><input type="text" placeholder="Ejemplo de CIF: A12345678" name="cif" id="cif" class="input-form" value="<?php echo $userData["CIF"]; ?>" required /></td>
            </tr>
            <tr>
                <td>Nombre: <span class="error">*</span></td>
                <td><input type="text" placeholder="Nombre de Empresa" name="name" id="name" class="input-form" value="<?php echo $userData["Nombre"]; ?>" required /></td>
            </tr>
            <?php if($_GET["methodUser"]=="viewRegister"){ ?>
                <tr>
                    <td>Contraseña: <span class="error">*</span></td>
                    <td><input type="password" placeholder="Ejemplo de contraseña" name="password" id="password" class="input-form" required /></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Teléfono: <span class="error">*</span></td>
                <td><input type="text" placeholder="Ejemplo de teléfono: 123456789" name="phone" id="phone" class="input-form" value="<?php echo $userData["Teléfono"]; ?>" required /></td>
            </tr>
            <tr>
                <td>Dirección: <span class="error">*</span></td>
                <td><input type="text" placeholder="Ejemplo de Dirección" name="address" id="address" class="input-form" value="<?php echo $userData["Dirección"]; ?>" required /></td>
            </tr>
            <tr>
                <td>Comunidad Autónoma: <span class="error">*</span></td>
                <td>
                    <select name="region" id="region" class="input-form" required >
                        <option value="">Seleccione</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Provincia: <span class="error">*</span></td>
                <td>
                    <select name="province" id="province" class="input-form" required disabled >
                        <option value="">Seleccione</option>
                    </select>
                </td>
            </tr>
            <?php if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR"){ ?>
            <tr>
                <td>Tipo: </td>
                <td><select name="tipo" id="tipo" class="input-form" equired>
                    <option value="P">Proveedor</option>
                    <option value="C">Cliente</option>
                </select></td>
            </tr>
            <?php } ?>
            <tr>
                <td>Avatar: </td>
                <td><input type="file" name="avatar" id="avatar" /></td>
            </tr>
            <?php if($_GET["methodUser"]=="viewRegister"){ ?>
            <tr>
                <td><input type="checkbox" name="terms" id="terms" /></td>
                <td><span>Acepto los <a href="../index.php?view=legal">Términos y Condiciones</a> y la <a href="../index.php?view=privacy">Política de Privacidad</a></span></td>
            </tr>
            <?php } ?>
            <tr><td colspan="2"><input type="button" id="btn-data-user" class="btn-log element-green-bg form-input" value="Enviar" /></td></tr>
            <tr>
                <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
            </tr>
            <?php if($_GET["methodUser"]=="viewRegister"){ ?>
                <tr>
                    <td colspan="2">¿Ya tienes una cuenta? <a href="principal.php?methodUser=viewLogin">Iniciar Sesión</a></td>
                </tr>
                <tr>
                    <td colspan="2">¿Deseas ser uno de nuestros Proveedores? <a href="../index.php?view=contact">Contáctanos</a></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</article>
<!-------------------------------FORM------------------------------->


    <!-------------------------------SCRIPT------------------------------->
    <script src="../assets/js/form_field_validation.js"></script>
    <script src="../assets/js/form_user_validation.js"></script>
    <script src="../assets/js/provinces_load.js"></script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>