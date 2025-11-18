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
    <div id="formPopup" class="popup" style="top: -130; font-size: 0.9em">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn" style='top: 140;'>X</button>
        <h2 style='margin-top: -30px'><?php echo $title ?></h2>
        <form id="form-data-prod" action= <?php echo $action; ?> method="post" enctype='multipart/form-data' class="needs-validation" novalidate>
            
            <?php if(isset($_GET["id"])) { ?>
                <input type="hidden" name="prodId" id="prodId" value="<?php echo $_GET["id"]; ?>" />
            <?php } ?>

            <div class="container-fluid">
                <div class="row gx-3">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre Producto: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de Producto" name="name" id="name" class="form-control" value="<?php echo $productData["Nombre"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-name"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="ref" class="form-label">Referencia Producto: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de Referencia: A1234" name="ref" id="ref" class="form-control" value="<?php echo $productData["Referencia"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-ref"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="desc" class="form-label">Descripción Producto: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="Ejemplo de descripción" name="desc" id="desc" class="form-control" value="<?php echo $productData["Descripción"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-desc"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="price" class="form-label">Precio Mensual: <span class="error">*</span></label>
                        <div class="input-group">
                            <input type="number" placeholder="100" name="price" id="price" class="form-control" value="<?php echo $productData["Precio_Mensual"]; ?>" required />
                        </div>
                        <div class="form-text text-danger" id="error-price"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="cat" class="form-label">Categoría: <span class="error">*</span></label>
                        <div class="input-group" style='margin-top: 10px'>
                            <select name="cat" id="cat" class="form-select">
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
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <div class="input-group">
                            <input type="file" name="imagen" id="imagen" class="form-control" />
                        </div>
                        <div class="form-text text-danger" id="error-imagen"></div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <div id="error">Los campos marcados con un * son obligatorios</div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <input type="button" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" id="btn-data-prod" value="Enviar" />
                    </div>
                </div>
            </div>
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