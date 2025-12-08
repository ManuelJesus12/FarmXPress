<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Popup</title>
    <link rel="stylesheet" href="../assets/css/principal.css">
</head>
<body>
    <!-------------------------------LÓGICA------------------------------->
    <?php
        $dirLocation=2;
        include("../_Indexes/Index_Interface.php");
        include("../_Indexes/Index_User.php");
        $userData=['Usuario_ID'=>'', 'Nombre'=>'', 'CIF'=>'', 'Email'=>'', 'Contraseña'=>'', 'Telefono'=>'', 'Direccion'=>'', 'Comunidad'=>'', 'Provincia'=>''];

        if(isset($_GET["id"])){
            $userData=$userController->selectUser($_GET["id"]);
            $action="principal.php?methodUser=update&userId=".$_GET["id"];
            $title="Actualizar Usuario";
        }else{
            $action="principal.php?methodUser=insert";
            $title="Registro de Usuario";
        }
    ?>
    <!-------------------------------LÓGICA------------------------------->

    <!-------------------------------FORM------------------------------->
    <div id="formPopup" class="popup">
    <div class="popup-content" style='position:relative; top: -80; width: 900px'>
        <button class="close-btn" id="closeFormBtn" style="position:fixed;">X</button>
        <h2 style='margin-top: -30px'><?php echo $title ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data' id="form-data-user" novalidate>
            <?php if(isset($_GET["id"])){ ?>
                <input type="hidden" name="userId" id="userId" value="<?php echo $userData["Usuario_ID"]; ?>" />
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

                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Nombre de Empresa" name="name" id="name" class="form-control" value="<?php echo $userData["Nombre"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-name"></div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="cif" class="form-label">CIF: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de CIF: A12345678" name="cif" id="cif" class="form-control" value="<?php echo $userData["CIF"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-cif"></div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="phone" class="form-label">Teléfono: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de teléfono: 123456789" name="phone" id="phone" class="form-control" value="<?php echo $userData["Telefono"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-phone"></div>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <label for="address" class="form-label"  style='margin-bottom: -2px'>Dirección: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de Dirección" name="address" id="address" class="form-control" value="<?php echo $userData["Direccion"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-address"></div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="region" class="form-label">Comunidad Autónoma: <span class="error">*</span></label>
                        <select name="region" id="region" class="form-select" required>
                            <option value="">Seleccione</option>
                        </select>
                        <div class="form-text text-danger" id="error-region"></div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="province" class="form-label">Provincia: <span class="error">*</span></label>
                        <select name="province" id="province" class="form-select" required disabled>
                            <option value="">Seleccione</option>
                        </select>
                        <div class="form-text text-danger" id="error-province"></div>
                    </div>

                    <?php if(!isset($_GET["id"])){ ?>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="password" class="form-label"  style='margin-bottom: -2px'>Contraseña: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="password" placeholder="Ejemplo de contraseña" name="password" id="password" class="form-control" required />
                        </div>
                        <div class="form-text text-danger" id="error-password"></div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select name="tipo" id="tipo" class="form-select">
                            <option value="P">Proveedor</option>
                            <option value="C">Cliente</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <label for="avatar" class="form-label" style='margin-bottom: 0px'>Avatar:</label>
                        <input type="file" name="avatar" id="avatar" class="form-control"  />
                        <small class="form-text text-muted">PNG o JPG de máximo 1MB</small>
                        <div class="form-text text-danger" id="error-avatar"></div>
                    </div>
                    <?php } ?>

                    <div class="col-12 text-center mt-2">
                        <input type="button" id="btn-data-user" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" value="Enviar" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script>
        const currentRegion   = "<?php echo $userData["Comunidad"] ?>";
        const currentProvince = "<?php echo $userData["Provincia"] ?>";
    </script>
    <script src="../assets/js/form_field_validation.js"></script>
    <script src="../assets/js/form_user_validation.js"></script>
    <script src="../assets/js/provinces_load.js"></script>
    
    <script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>