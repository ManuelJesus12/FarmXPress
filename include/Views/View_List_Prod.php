<div id="modal"></div>

<article class="col-12 list-prod form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////

if(is_array($productControl)){
    echo "<h2>Tus Productos</h2>";
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if(isset($_GET["error"])) echo "<script>showFieldError('".$_GET["error"]."');</script>";
    
    if(isset($_GET["action"]) && $_GET["action"]=="insert")
        echo "<div id='alert-success' class='alert alert-success'>Producto agregado correctamente</div>";
    else if(isset($_GET["action"]) && $_GET["action"]=="update")
        echo "<div id='alert-success' class='alert alert-success'>Producto actualizado correctamente</div>";
    else
        echo "<div id='alert-success' class='alert alert-success'>Productos cargados correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//
    //*-----------------------------PRODUCT LIST------------------------------*//
    echo "<a id='add-product' class='btn btn-shape element-green-bg mb-3'>Agregar Producto</a>";
    echo "<input type='text' id='inputSearch' onInput='filterProduct()' placeholder='Filtrar por Nombre o Referencia'></input>";
    echo "<div id='boxContent' class='row card-deck col-12'></div>";
    //*-----------------------------PRODUCT LIST------------------------------*//

    //--------------------------------------------NAV BUTTONS--------------------------------------------//
    $class0=$class1=$class2="btn btn-log element-green-bg ";
    $class1=$class0."not-visible";
    if(count($productControl)<=8) $class2=$class0."not-visible";

    echo "<div class='nav-buttons site-article'>";
        echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
        echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
        echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
    echo "</div>";
    //--------------------------------------------NAV BUTTONS--------------------------------------------//

}else if($productControl==0){
    echo "<h2>No hay productos registrados</h2><br>";
    echo "<a id='add-product' class='btn btn-shape element-green-bg'>Agregar Producto</a>";
}else if($productControl==-1)
    echo "<h2>Error al cargar las productos</h2>";
///////////////////////////////////////////////////////////////////////
?></article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var productControl = <?php echo json_encode($productControl); ?>;
    content_paginate(productControl, 8);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(prod){
        let file = (prod["Imagen"]!=null) ? prod["Imagen"] : "anon.png";
        let cat  = (prod["CAT"]!=null) ? prod["CAT"] : "Ninguna";
        let buttons=estado = "";

        if(prod["Estado"]==false){
            estado+="<span class='badge bg-danger status-type'>Alquilado</span>";
            buttons+= "<div class='col-6'><a href='#' onclick='updateProduct("+prod["Producto_ID"]+")' class='btn btn-sm btn-product-modify btn-shape w-33'><i class='fa-solid fa-gear icon-gear border-5'></i> Modificar</a></div>";
            buttons+= "<div class='col-6'><a href='#' onclick='viewData("+prod["Producto_ID"]+")' class='btn btn-sm btn-product-modify btn-shape w-33'><i class='fa-solid fa-gear icon-gear border-5'></i> Datos Producto</a></div>";
        }else{
            estado+="<span class='badge bg-success status-type'>Disponible</span>";
            buttons+="<div class='col-4'><a href='#' onclick='updateProduct("+prod["Producto_ID"]+")' class='btn btn-sm btn-product-modify btn-shape w-33'><i class='fa-solid fa-gear icon-gear border-5'></i> Modificar</a></div>";
            buttons+="<div class='col-4'><a href='#' onclick='viewData("+prod["Producto_ID"]+")' class='btn btn-sm btn-product-modify btn-shape w-33'><i class='fa-solid fa-gear icon-gear border-5'></i> Datos Producto</a></div>";
            buttons+="<div class='col-4'><a href='#' onclick='deleteProduct("+prod["Producto_ID"]+")' class='btn btn-sm btn-product-delete btn-shape w-33'><i class='fa-solid fa-trash icon-trash border-5'></i> Eliminar</a></div>";
        }

        $("#boxContent").append(    
            "<div id='product-"+prod['Producto_ID']+"' class='col-12 col-md-6 col-lg-4'>"+
                "<div class='card h-100 element-green-border'>" +
                    "<div class='card-header element-green-bg'>"+prod["Nombre"]+" - "+prod["Referencia"]+"</div>"+
                    "<div class='card-body d-flex flex-column'>" +
                        "<img src='../assets/img/products/"+file+"' class='card-img-top mb-3' alt='"+prod["Nombre"]+"'/>" +
                        "<p class='card-text mb-1'>Descripción: <strong>"+prod['Descripcion']+"</strong></p>" +
                        "<p class='card-text mb-1'>Categoría: <strong>"+cat+"</strong></p>" +
                        "<p class='card-text mb-1'>Precio Mensual: <strong>"+prod['Precio_Mensual']+"€</strong></p>" +
                        estado +
                        "<div class='mt-auto row'>" + buttons + "</div>" +
                    "</div>" +
                "</div>" +
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>

<script>
    ////////////////////////////AÑADIR PRODUCTO////////////////////////////
    $("#add-product").on("click", function() {
        $("#modal").load("Views/Form_Add_Prod.php?methodProd", function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    });
    ////////////////////////////AÑADIR PRODUCTO////////////////////////////

    ////////////////////////////VER DATOS PRODUCTO////////////////////////////
    function viewData(id) {
        $("#modal").load("Views/View_Product_Stats.php?methodProd&id="+id, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    ////////////////////////////VER DATOS PRODUCTO////////////////////////////

    ////////////////////////////ACTUALIZAR PRODUCTO////////////////////////////
    function updateProduct(pId){
        $("#modal").load("Views/Form_Add_Prod.php?methodProd&id="+pId, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    ////////////////////////////ACTUALIZAR PRODUCTO////////////////////////////

    ////////////////////////////ELIMINAR PRODUCTO////////////////////////////
    function deleteProduct(pId){
        if(confirm("¿Está seguro de que desea eliminar este producto?")){
            $.ajax({
                url: "principal.php?methodProd=delete",
                type: "POST",
                data: { deleteId: pId },
                success: function(response) {
                    $("#product-"+pId).fadeOut(300);
                    window.location.reload();
                },
                error: function() { alert("Error inesperado."); }
            });
        }
        event.preventDefault();
    }
    ////////////////////////////ELIMINAR PRODUCTO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->