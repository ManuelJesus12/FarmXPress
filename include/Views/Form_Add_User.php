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
        include("../funciones.php");
        include("../_Indexes/Index_User.php");
        $userData=['Usuario_ID'=>'', 'Nombre'=>'', 'CIF'=>'', 'Email'=>'', 'Contraseña'=>'', 'Teléfono'=>'', 'Dirección'=>''];

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
    <div id="formPopup" class="popup" style="top: -90;">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn" style="top: 105;">X</button>
        <h2><?php echo $title ?></h2>
        <table class="table-form" style="margin:auto">
            <form id="form-data-user" action= <?php echo $action; ?> method="post" enctype='multipart/form-data'>
                <?php if(isset($_GET["id"])){ ?>
                    <tr>
                        <td colspan="2"><input type="hidden" name="userId" id="userId" value="<?php echo $_GET["id"]; ?>" /></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Email:  <span class="error">*</span></td>
                    <td><input type="email" placeholder="ejemplo@gmail.com" name="email" id="email" value="<?php echo $userData["Email"]; ?>" required /></td>
                </tr>
                <tr>
                    <td>CIF:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de CIF: A12345678" name="cif" id="cif" value="<?php echo $userData["CIF"]; ?>" required /></td>
                </tr>
                <tr>
                    <td>Nombre:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Nombre de Empresa" name="name" id="name" value="<?php echo $userData["Nombre"]; ?>" required /></td>
                </tr>
                <?php if(!isset($_GET["id"])){ ?>
                    <tr>
                        <td>Contraseña:  <span class="error">*</span></td>
                        <td><input type="password" placeholder="Ejemplo de contraseña" name="password" id="password" required /></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Teléfono:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de teléfono: 123456789" name="phone" id="phone" value="<?php echo $userData["Teléfono"]; ?>" required /></td>
                </tr>
                <tr>
                    <td>Dirección:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Dirección" name="address" id="address" value="<?php echo $userData["Dirección"]; ?>" required /></td>
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
                    <?php if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR" && !isset($_GET["id"])){ ?>
                    <tr>
                        <td>Tipo:  <span class="error">*</span></td>
                        <td><select name="tipo" id="tipo" style="width: 100%;">
                            <option value="P">Proveedor</option>
                            <option value="C">Cliente</option>
                        </select></td>
                    </tr>
                    <?php } ?>
                <tr>
                    <td>Avatar: </td>
                    <td><input type="file" name="avatar" id="avatar" /></td>
                </tr>
                <tr>
                    <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="2"><input type="button" class="btn-log element-green-bg" id="btn-data-user" value="Enviar" /></td></tr>
            </form>
        </table>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script src="../assets/js/form_field_validation.js"></script>
    <script src="../assets/js/form_user_validation.js"></script>
    <script src="../assets/js/provinces_load.js"></script>
    
    <script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>