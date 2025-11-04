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
        include("../_Indexes/Index_Category.php");
        $categoryData=['Categoría_ID'=>'', 'Nombre'=>'', 'Descripción'=>'', 'Cat_Padre_ID'=>''];

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
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn">X</button>
        <h2><?php echo $title ?></h2>
        <form id="form-data-cat" action= <?php echo $action; ?> method="post">
            <table class="table-form" style="margin:auto">
                <tr>
                    <td>Nombre Categoría: <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Categoría" name="name" id="name" value="<?php echo $categoryData["Nombre"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Descripción Categoría:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" value="<?php echo $categoryData["Descripción"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Categoría Padre:  <span class="error">*</span></td>
                    <td><select name="parent_cat" id="parent_cat" style="width: 100%;">
                        <option value="">Sin Padre</option>
                        <?php
                            $offset=1;
                            $categoryControl = $categoryController->viewListCategory($offset);

                            if(is_array($categoryControl)){
                                foreach($categoryControl as $category){
                                    $selected = ($category['Categoría_ID'] == $categoryData['Cat_Padre_ID']) ? 'selected' : '';
                                    echo "<option value='".$category['Categoría_ID']."' $selected>".$category['Nombre']."</option>";
                                }
                            }
                        ?>
                    </select></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td colspan="3" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="3"><input type="button" class="btn-log element-green-bg" id="btn-data-cat" value="Enviar" /></td></tr>
            </table>
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

            if (name.length < 5 || name.length > 20) {
                $("#error").text("El campo Nombre debe tener entre 5 y 20 caracteres.");
                $("#name").focus();
                return;
            }

            if (desc.length < 5 || desc.length > 255) {
                $("#error").text("El campo Descripción debe tener al menos 5 caracteres.");
                $("#desc").focus();
                return;
            }

            $("#form-data-cat").submit();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>