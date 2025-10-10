<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Popup</title>
    <link rel="stylesheet" href="../assets/css/formPopup.css">
</head>
<body>
    <!-------------------------------LOGIC------------------------------->
    <?php
        include("../funciones.php");
        include("../_Indexes/Index_Perk.php");
        $name=$desc=" ";

        if(isset($_GET["id"])){
            $action="principal.php?methodPerk=update";
            $title="Actualizar Ventaja";

            $perkData=$perkController->selectPerk($_GET["id"]);
            $name=$perkData['Nombre'];
            $desc=$perkData['Descripción'];
            $id=$_GET["id"];
        }else if (isset($_GET["subId"])){
            $action="principal.php?methodPerk=insert";
            $title="Añadir Ventaja";
            $id=$_GET["subId"];
        }
    ?>
    <!-------------------------------LOGIC------------------------------->

    <!-------------------------------FORM------------------------------->
    <div id="formPopup" class="popup">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn">X</button>
        <h2><?php echo $title ?></h2>
        <table class="table-form" style="margin:auto">
            <form id="form-data-perk" action= <?php echo $action; ?> method="post">
                <tr style="display:none"><td><input type="text" name="id" id="id" value="<?php echo $id; ?>" /></td></tr>
                <tr>
                    <td>Título Ventaja:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Ventaja" name="name" id="name" value="<?php echo $name; ?>" required /></td>
                </tr>
                <tr>
                    <td>Descripción:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" value="<?php echo $desc; ?>" required /></td>
                </tr>
                <tr>
                    <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="2"><input type="button" class="btn-log element-green-bg" id="btn-data-perk" value="Enviar" /></td></tr>
            </form>
        </table>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
    <script>
        $("#btn-data-perk").on("click",function() {
            var name = $("#name").val().trim();
            var desc = $("#desc").val().trim();

            if(name.length < 3 || name.length > 20) {
                $("#error").text("El campo Nombre debe tener entre 3 y 2 caracteres.");
                $("#name").focus();
                return;
            }

            if(desc.length < 3 || desc.length > 255) {
                $("#error").text("El campo Descripción debe tener entre 3 y 255 caracteres.");
                $("#desc").focus();
                return;
            }

            var fieldValues = [name, desc, $("#id").val()];
            document.cookie = "data-perk=" + encodeURIComponent(JSON.stringify(fieldValues)) + "; path=/; max-age=" + (60);
            $("#form-data-perk").submit();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>