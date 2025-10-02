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
        $name=$desc=$ref=$price=$parent_cat="";
        
        $dirChangeVar=1;
        include("../funciones.php");
        include("../_Indexes/Index_Product.php");
        include("../_Indexes/Index_Category.php");

        if(isset($_GET["id"])){
            $action="principal.php?methodProd=update&prod=".$_GET["id"];
            $title="Actualizar Producto";

            $field="Producto_ID";
            $productData=$productController->selectProduct($field, $_GET["id"]);
            $name=$productData[0]['Nombre'];
            $desc=$productData[0]['Descripción'];
            $ref=$productData[0]['Referencia'];
            $price=$productData[0]['Precio_Mensual'];
            $parent_cat=$productData[0]['Categoría_ID'];
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
        <table class="table-form" style="margin:auto">
            <form id="form-data-prod" action= <?php echo $action; ?> method="post" enctype='multipart/form-data'>
                <?php if(isset($_GET["id"])){ ?>
                    <tr>
                        <td colspan="2"><input type="hidden" name="prodId" id="prodId" value="<?php echo $_GET["id"]; ?>" /></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Nombre Producto:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Producto" name="name" id="name" value="<?php echo $name; ?>" required /></td>
                </tr>
                <tr>
                    <td>Referencia Producto:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de Referencia: A1234" name="ref" id="ref" value="<?php echo $ref; ?>" required /></td>
                </tr>
                <tr>
                    <td>Descripción Producto:  <span class="error">*</span></td>
                    <td><input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" value="<?php echo $desc; ?>" required /></td>
                </tr>
                <tr>
                    <td>Precio Mensual:  <span class="error">*</span></td>
                    <td><input type="number" placeholder="100" name="price" id="price" value="<?php echo $price; ?>" required /></td>
                </tr>
                <tr>
                    <td>Categoría:  <span class="error">*</span></td>
                    <td><select name="cat" id="cat" style="width: 100%;">
                        <option value="">Sin Categoría</option>
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
                    <td>Imagen: </td>
                    <td><input type="file" name="imagen" id="imagen" /></td>
                </tr>
                <tr>
                    <td colspan="2" id="error">Los campos marcados con un * son obligatorios</td>
                </tr>
                <tr><td colspan="2"><input type="button" class="btn-log element-green-bg" id="btn-data-prod" value="Enviar" /></td></tr>
            </form>
        </table>
    </div>
    </div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
    <script src="../assets/js/form_field_validation.js"></script>
    <script src="../assets/js/form_prod_validation.js"></script>
    <!-------------------------------SCRIPT------------------------------->
</body>

</html>