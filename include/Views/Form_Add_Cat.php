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
        include("../_Indexes/Index_Category.php");
        $categoryData=['Categoria_ID'=>'', 'Nombre'=>'', 'Descripcion'=>'', 'Cat_Padre_ID'=>''];

        if(isset($_GET["id"])){
            $categoryData=$categoryController->selectCategory($_GET["id"]);
            $action="principal.php?methodCat=update&cat=".$_GET["id"];
            $title="Actualizar Categoría";
        }else{
            $action="principal.php?methodCat=insert";
            $title="Añadir Categoría";
        }
    ?>
    <!-------------------------------LOGIC------------------------------->

    <!-------------------------------FORM------------------------------->
    <div id="formPopup" class="popup">
    <div class="popup-content" style='position:relative; top: -80;'>
        <button class="close-btn" id="closeFormBtn" style="position:fixed;">X</button>
        <h2 style='margin-top: -30px'><?php echo $title ?></h2>
        <form id="form-data-cat" action= <?php echo $action; ?> method="post" class="needs-validation" novalidate>
            <div class="container-fluid">
                <div class="row gx-3">
                    <div class="col-12 mb-3">
                        <label for="name" class="form-label">Nombre Categoria: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de Categoria" name="name" id="name" class="form-control" value="<?php echo $categoryData["Nombre"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-name"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="desc" class="form-label">Descripción Categoria: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" class="form-control" value="<?php echo $categoryData["Descripcion"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-desc"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="parent_cat" class="form-label">Categoria Padre:</label>
                        <div class="input-group">
                            <select name="parent_cat" id="parent_cat" class="form-select">
                                <option value="">Sin Padre</option>
                                <?php
                                    $offset=1;
                                    $categoryControl = $categoryController->viewListCategory($offset);

                                    if(is_array($categoryControl)){
                                        foreach($categoryControl as $category){
                                            $selected = ($category['Categoria_ID'] == $categoryData['Cat_Padre_ID']) ? 'selected' : '';
                                            echo "<option value='".$category['Categoria_ID']."' $selected>".$category['Nombre']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <div id="error">Los campos marcados con un * son obligatorios</div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <input type="button" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" id="btn-data-cat" value="Enviar" />
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
        $("#btn-data-cat").on("click",function() {
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

            $("#form-data-cat").submit();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>