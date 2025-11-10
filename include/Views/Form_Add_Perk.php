<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Popup</title>
    <link rel="stylesheet" href="../assets/css/principal.css">
</head>
<body>
    <!-------------------------------LOGIC------------------------------->
    <?php
        include("../funciones.php");
        include("../_Indexes/Index_Perk.php");
        $perkData=['Ventaja_ID'=>'', 'Nombre'=>'', 'Descripción'=>''];
        
        if(isset($_GET["id"])){
            $perkData=$perkController->selectPerk($_GET["id"]);
            $action="principal.php?methodPerk=update";
            $title="Actualizar Ventaja";
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
        <form id="form-data-perk" action= <?php echo $action; ?> method="post">
            <table class="table-form" style="margin:auto">
                <tr style="display:none"><td><input type="text" name="id" id="id" value="<?php echo $id; ?>" /></td></tr>
                <tr>
                    <td>Título Ventaja:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Ventaja" name="name" id="name" value="<?php echo $perkData["Nombre"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Entre 5 y 20 caracteres'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Descripción:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" value="<?php echo $perkData["Descripción"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Entre 5 y 255 caracteres'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td colspan="3" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="3"><input type="button" class="btn-log element-green-bg" id="btn-data-perk" value="Enviar" /></td></tr>
            </table>
        </form>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
    <script>
        $("#btn-data-perk").on("click",function() {
            var name = $("#name").val().trim();
            var desc = $("#desc").val().trim();

            if(name.length < 5 || name.length > 20) {
                $("#error").text("El campo Nombre debe tener entre 5 y 20 caracteres.");
                $("#name").focus();
                return;
            }

            if(desc.length < 5 || desc.length > 255) {
                $("#error").text("El campo Descripción debe tener entre 5 y 255 caracteres.");
                $("#desc").focus();
                return;
            }

            $("#form-data-perk").submit();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>