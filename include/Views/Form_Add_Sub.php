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
        include("../_Indexes/Index_Sub.php");
        $subData=['Suscripción_ID'=>'', 'Nombre'=>'', 'Precio_Mensual'=>'', 'Duración_Base'=>''];

        if(isset($_GET["id"])){
            $subData=$subController->selectSub($_GET["id"]);
            $action="principal.php?methodSub=update&sub=".$_GET["id"];
            $title="Actualizar Suscripción";
        }else{
            $action="principal.php?methodSub=insert";
            $title="Añadir Suscripción";
        }
    ?>
    <!-------------------------------LOGIC------------------------------->

    <!-------------------------------FORM------------------------------->
    <div id="formPopup" class="popup">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn">X</button>
        <h2><?php echo $title ?></h2>
        <table class="table-form" style="margin:auto">
            <form id="form-data-sub" action= <?php echo $action; ?> method="post">
                <tr>
                    <td>Nombre Suscripción:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Suscripción" name="name" id="name" value="<?php echo $subData["Nombre"]; ?>" required /></td>
                </tr>
                <tr>
                    <td>Precio Mensual:  <span class="error">*</span></td>
                    <td><input type="number" placeholder="10" name="price" id="price" value="<?php echo $subData["Precio_Mensual"]; ?>" required /></td>
                </tr>
                <tr>
                    <td>Duración Base (Meses):  <span class="error">*</span></td>
                    <td><input type="number" placeholder="12" name="months" id="months" value="<?php echo $subData["Duración_Base"]; ?>" required /></td>
                </tr>
                <tr>
                    <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="2"><input type="button" class="btn-log element-green-bg" id="btn-data-sub" value="Enviar" /></td></tr>
            </form>
        </table>
    </div>
</div>
<!-------------------------------FORM------------------------------->

<!-------------------------------SCRIPT------------------------------->
<script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
<script>
    $("#btn-data-sub").on("click",function() {
        var name = $("#name").val().trim();
        var price = $("#price").val().trim();;
        var months = $("#months").val().trim();;

        if(name.length < 5 || name.length > 20) {
            $("#error").text("El campo Nombre debe tener entre 5 y 20 caracteres.");
            $("#name").focus();
            return;
        }

        if(isNaN(price) || price <= 0) {
            $("#error").text("El campo Precio Mensual debe ser un número positivo.");
            $("#price").focus();
            return;
        }

        if(isNaN(months) || months <= 0) {
            $("#error").text("El campo Duración Base debe ser un número positivo.");
            $("#months").focus();
            return;
        }

        var fieldValues = [name, price, months];
        document.cookie = "data-sub=" + encodeURIComponent(JSON.stringify(fieldValues)) + "; path=/; max-age=" + (60);
        $("#form-data-sub").submit();
    });
</script>
<!-------------------------------SCRIPT------------------------------->
</body>
</html>