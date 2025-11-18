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
        $dirLocation=2;
        include("../_Indexes/Index_Interface.php");
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
    <div class="popup-content" style='position:relative; top: -40;'>
        <button class="close-btn" id="closeFormBtn" style="position:fixed;">X</button>
        <h2 style='margin-top: -30px'><?php echo $title ?></h2>
        <form id="form-data-sub" action= <?php echo $action; ?> method="post" class="needs-validation" novalidate>
            <div class="container-fluid">
                <div class="row gx-3">
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Nombre Suscripción: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de Suscripción" name="name" id="name" class="form-control" value="<?php echo $subData["Nombre"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-name"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="price" class="form-label">Precio Mensual: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="number" placeholder="10" name="price" id="price" class="form-control" value="<?php echo $subData["Precio_Mensual"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-price"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="months" class="form-label">Duración Base (Meses): <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="number" placeholder="12" name="months" id="months" class="form-control" value="<?php echo $subData["Duración_Base"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-months"></div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <div id="error">Los campos marcados con un * son obligatorios</div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <input type="button" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" id="btn-data-sub" value="Enviar" />
                    </div>
                </div>
            </div>
        </form>
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

        // Clear previous errors
        $('#error-name, #error-price, #error-months').text('');
        $('#name, #price, #months').removeClass('input-error');

        // Name validation
        if(name.length < 5 || name.length > 20) {
            $("#error-name").text("El campo Nombre debe tener entre 5 y 20 caracteres.");
            $("#name").addClass('input-error').focus();
            return;
        }

        // Price validation
        if(isNaN(price) || Number(price) <= 0) {
            $("#error-price").text("El campo Precio Mensual debe ser un número positivo.");
            $("#price").addClass('input-error').focus();
            return;
        }

        // Months validation
        if(isNaN(months) || Number(months) <= 0) {
            $("#error-months").text("El campo Duración Base debe ser un número positivo.");
            $("#months").addClass('input-error').focus();
            return;
        }

        $("#form-data-sub").submit();
    });
</script>
<!-------------------------------SCRIPT------------------------------->
</body>
</html>