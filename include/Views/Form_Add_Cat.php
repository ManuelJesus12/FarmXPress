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
        $name=$desc=$parent_cat=" ";

        $dirChangeVar=1;
        include("../funciones.php");
        include("../_Indexes/Index_Category.php");

        if(isset($_GET["id"])){
            $action="principal.php?methodCat=update&cat=".$_GET["id"];
            $title="Actualizar Categoría";

            $categoryData=$categoryController->selectCategory($_GET["id"]);
            $name=$categoryData[0]['Nombre'];
            $desc=$categoryData[0]['Descripción'];
            $parent_cat=$categoryData[0]['Cat_Padre_ID'];
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
        <table class="table-form" style="margin:auto">
            <form id="form-data-cat" action= <?php echo $action; ?> method="post">
                <tr>
                    <td>Nombre Categoría: <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Categoría" name="name" id="name" value="<?php echo $name; ?>" required /></td>
                </tr>
                <tr>
                    <td>Descripción Categoría:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" value="<?php echo $desc; ?>" required /></td>
                </tr>
                <tr>
                    <td>Categoría Padre:  <span class="error">*</span></td>
                    <td><select name="parent_cat" id="parent_cat" style="width: 100%;">
                        <option value="">Sin Padre</option>
                        <?php
                            $offset=1;
                            $categories = $categoryController->viewListCategory($offset, $dirChangeVar);

                            if($categories!=0){
                                foreach($categories as $category){
                                    if($category['Categoría_ID'] == $parent_cat)
                                        echo "<option value='".$category['Categoría_ID']."' selected>".$category['Nombre']."</option>";
                                    else
                                        echo "<option value='".$category['Categoría_ID']."'>".$category['Nombre']."</option>";
                                }
                            }
                        ?>
                    </select></td>
                </tr>
                <tr>
                    <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="2"><input type="button" class="btn-log element-green-bg" id="btn-data-cat" value="Enviar" /></td></tr>
            </form>
        </table>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script>
        $("#closeFormBtn").click(function() {
            $("#formPopup").fadeOut();
        });

        $("#btn-data-cat").on("click",function() {
            var name = $("#name").val().trim();
            var desc = $("#desc").val().trim();

            if (name.length < 3 || name.length > 100) {
                $("#error").text("El campo Nombre debe tener entre 3 y 100 caracteres.");
                $("#name").focus();
                return;
            }

            if (desc.length < 3 || desc.length > 255) {
                $("#error").text("El campo Descripción debe tener al menos 3 caracteres.");
                $("#desc").focus();
                return;
            }

            var fieldValues = [name, desc, $("#parent_cat").val()];
            document.cookie = "data-cat=" + encodeURIComponent(JSON.stringify(fieldValues)) + "; path=/; max-age=" + (60);
            $("#form-data-cat").submit();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->
</body>
</html>