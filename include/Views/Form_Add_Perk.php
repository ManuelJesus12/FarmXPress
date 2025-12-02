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
        include("../_Indexes/Index_Perk.php");
        $perkData=['Ventaja_ID'=>'', 'Nombre'=>'', 'Descripcion'=>''];
        
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
    <div class="popup-content" style='position:relative; top: -40;'>
        <button class="close-btn" id="closeFormBtn" style="position:fixed;">X</button>
        <h2 style='margin-top: -30px'><?php echo $title ?></h2>
        <form id="form-data-perk" action= <?php echo $action; ?> method="post" class="needs-validation" novalidate>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

            <div class="container-fluid">
                <div class="row gx-3">
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Título Ventaja: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de Ventaja" name="name" id="name" class="form-control" value="<?php echo $perkData["Nombre"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-name"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="desc" class="form-label">Descripción: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" class="form-control" value="<?php echo $perkData["Descripcion"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-desc"></div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <div id="error">Los campos marcados con un * son obligatorios</div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <input type="button" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" id="btn-data-perk" value="Enviar" />
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
        $("#btn-data-perk").on("click",function() {
            var name = $("#name").val().trim();
            var desc = $("#desc").val().trim();

            // Clear previous errors
            $('#error-name, #error-desc').text('');
            $('#name, #desc').removeClass('input-error');

            if(name.length < 5 || name.length > 20) {
                $("#error-name").text("El campo Nombre debe tener entre 5 y 20 caracteres.");
                $("#name").addClass('input-error').focus();
                return;
            }

            if(desc.length < 5 || desc.length > 255) {
                $("#error-desc").text("El campo Descripción debe tener entre 5 y 255 caracteres.");
                $("#desc").addClass('input-error').focus();
                return;
            }

            $("#form-data-perk").submit();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>