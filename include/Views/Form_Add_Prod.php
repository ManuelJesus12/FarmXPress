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
        include("../_Indexes/Index_Product.php");
        $productData=['Producto_ID'=>'', 'Nombre'=>'', 'Descripción'=>'', 'Referencia'=>'', 'Precio_Mensual'=>'', 'Categoría_ID'=>''];

        if(isset($_GET["id"])){
            $productData=$productController->selectProduct($_GET["id"]);
            $action="principal.php?methodProd=update&prod=".$_GET["id"];
            $title="Actualizar Producto";
        }else{
            $action="principal.php?methodProd=insert";
            $title="Añadir Producto";
        }
    ?>
    <!-------------------------------LOGIC------------------------------->

    <!-------------------------------FORM------------------------------->
    <div id="formPopup" class="popup">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn">X</button>
        <h2><?php echo $title ?></h2>
        <form id="form-data-prod" action= <?php echo $action; ?> method="post" enctype='multipart/form-data'>
            <table class="table-form" style="margin:auto">
                <?php if(isset($_GET["id"])){ ?>
                    <tr>
                        <td colspan="3"><input type="hidden" name="prodId" id="prodId" value="<?php echo $_GET["id"]; ?>" /></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Nombre Producto:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Producto" name="name" id="name" value="<?php echo $productData["Nombre"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Referencia Producto:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Referencia: A1234" name="ref" id="ref" value="<?php echo $productData["Referencia"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Descripción Producto:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" value="<?php echo $productData["Descripción"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Precio Mensual:  <span class="error">*</span></td>
                    <td><input type="number" placeholder="100" name="price" id="price" value="<?php echo $productData["Precio_Mensual"]; ?>" required /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Categoría:  <span class="error">*</span></td>
                    <td><select name="cat" id="cat" style="width: 100%;">
                        <option value="">Sin Categoría</option>
                        <?php
                            $offset=1;
                            $categoryControl = $categoryController->viewListCategory($offset);

                            if($categoryControl!=0){
                                foreach($categoryControl as $category){
                                        $selected = ($category['Categoría_ID'] == $productData["Categoría_ID"]) ? 'selected' : '';
                                        echo "<option value='".$category['Categoría_ID']."' $selected>".$category['Nombre']."</option>";
                                    }
                            }
                        ?>
                    </select></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td>Imagen: </td>
                    <td><input type="file" name="imagen" id="imagen" /></td>
                    <td><a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría'><i class='fa-solid fa-question icon-plus border-5'></i></a></td>
                </tr>
                <tr>
                    <td colspan="3" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="3"><input type="button" class="btn-log element-green-bg" id="btn-data-prod" value="Enviar" /></td></tr>
            </table>
        </form>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script src="../assets/js/form_field_validation.js"></script>
    <script src="../assets/js/form_prod_validation.js"></script>
    <script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
    <!-------------------------------SCRIPT------------------------------->
</body>

</html>