<!-------------------------------LOGIC------------------------------->
<?php
    $userData=['Usuario_ID'=>'', 'Nombre'=>'', 'CIF'=>'', 'Email'=>'', 'Contraseña'=>'', 'Telefono'=>'', 'Direccion'=>'', 'Comunidad'=>'', 'Provincia'=>''];
    if($_GET["methodUser"]=="viewUpdate"){
        $title="Actualizar Usuario"; $field="Nombre";
        $userData=$this->selectUser($_SESSION["User"]["Nombre"], $field);
        $action="principal.php?methodUser=update";
    }else{
        $action="principal.php?methodUser=insert";
        $title="Registro de Usuario";
    }

    if(isset($_GET["error"])) echo "<script>showFieldError('".$_GET["error"]."');</script>";
?>
<!-------------------------------LOGIC------------------------------->

<!-------------------------------FORM------------------------------->
<article class="col-12 col-md-8 form-log site-section rounded pb-2 mx-auto">
    <?php echo "<h2>$title</h2>"; ?>

    <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data' id="form-data-user" novalidate>
        <?php if($_GET["methodUser"]=="viewUpdate"){ ?>
            <input type="hidden" name="userId" id="userId" value="<?php echo $userData["Usuario_ID"] ?>" />
        <?php } ?>

        <div class="container-fluid">
            <div class="row gx-3">
                <div class="col-lg-12 col-md-6 mb-3">
                    <label for="email" class="form-label">Email: <span class="error">*</span></label>
                    <div class="input-group">
                        <input type="email" placeholder="ejemplo@gmail.com" name="email" id="email" class="form-control" value="<?php echo $userData["Email"]; ?>" required />
                    </div>
                    <div class="form-text text-danger" id="error-email"></div>
                </div>

                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre: <span class="error">*</span></label>
                    <div class="input-group">
                        <input type="text" placeholder="Nombre de Empresa" name="name" id="name" class="form-control" value="<?php echo $userData["Nombre"]; ?>" required />
                    </div>
                    <div class="form-text text-danger" id="error-name"></div>
                </div>

                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="cif" class="form-label">CIF: <span class="error">*</span></label>
                    <div class="input-group">
                        <input type="text" placeholder="Ejemplo de CIF: A12345678" name="cif" id="cif" class="form-control" value="<?php echo $userData["CIF"]; ?>" required />
                    </div>
                    <div class="form-text text-danger" id="error-cif"></div>
                </div>

                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="phone" class="form-label">Teléfono: <span class="error">*</span></label>
                    <div class="input-group">
                        <input type="text" placeholder="Ejemplo de teléfono: 123456789" name="phone" id="phone" class="form-control" value="<?php echo $userData["Telefono"]; ?>" required />
                    </div>
                    <div class="form-text text-danger" id="error-phone"></div>
                </div>

                <div class="col-lg-6 mb-3">
                    <label for="address" class="form-label">Dirección: <span class="error">*</span></label>
                    <div class="input-group">
                        <input type="text" placeholder="Ejemplo de Dirección" name="address" id="address" class="form-control" value="<?php echo $userData["Direccion"]; ?>" required />
                    </div>
                    <div class="form-text text-danger" id="error-address"></div>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="region" class="form-label">Comunidad Autónoma: <span class="error">*</span></label>
                    <select name="region" id="region" class="form-select" required>
                        <option value="">Seleccione</option>
                    </select>
                    <div class="form-text text-danger" id="error-region"></div>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="province" class="form-label">Provincia: <span class="error">*</span></label>
                    <select name="province" id="province" class="form-select" required disabled>
                        <option value="">Seleccione</option>
                    </select>
                    <div class="form-text text-danger" id="error-province"></div>
                </div>

                <?php if($_GET["methodUser"]=="viewRegister"){ ?>
                <div class="col-12 col-md-6 mb-3">
                    <label for="password" class="form-label">Contraseña: <span class="error">*</span></label>
                    <div class="input-group">
                        <input type="password" placeholder="Ejemplo de contraseña" name="password" id="password" class="form-control" required />
                    </div>
                    <div class="form-text text-danger" id="error-password"></div>
                </div>
                <?php } ?>

                <div class="col-12 col-md-6 mb-3">
                    <label for="avatar" class="form-label">Avatar:</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" />
                    <small class="form-text text-muted">PNG o JPG de máximo 1MB</small>
                    <div class="form-text text-danger" id="error-avatar"></div>
                </div>

                <?php if($_GET["methodUser"]=="viewRegister"){ ?>
                <div class="col-lg-12 mb-3 align-items-center">
                    <input type="checkbox" name="terms" id="terms" class="me-2" />
                    <label for="terms" class="mb-0">Acepto los <a href="../index.php?view=legal">Términos y Condiciones</a> y la <a href="../index.php?view=privacy">Política de Privacidad</a></label>
                    <div class="form-text text-danger" id="error-terms"></div>
                </div>
                <?php } ?>

                <div class="col-12 text-center mt-2">
                    <input type="button" id="btn-data-user" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" value="Enviar" />
                </div>

                <div class="col-12 text-center mt-2">
                    <div id="error">Los campos marcados con un * son obligatorios</div>
                </div>

                <?php if($_GET["methodUser"]=="viewRegister"){ ?>
                <div class="col-12 text-center mt-2">
                    <div>¿Ya tienes una cuenta? <a href="principal.php?methodUser=viewLogin">Iniciar Sesión</a></div>
                    <div>¿Deseas ser uno de nuestros Proveedores? <a href="../index.php?view=contact">Contáctanos</a></div>
                </div>
                <?php } ?>
            </div>
        </div>
    </form>
</article>
<!-------------------------------FORM------------------------------->


    <!-------------------------------SCRIPT------------------------------->
    <script>
        const currentRegion   = "<?php echo $userData["Comunidad"] ?>";
        const currentProvince = "<?php echo $userData["Provincia"] ?>";
    </script>
    <script src="../assets/js/form_field_validation.js"></script>
    <script src="../assets/js/form_user_validation.js"></script>
    <script src="../assets/js/provinces_load.js"></script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>