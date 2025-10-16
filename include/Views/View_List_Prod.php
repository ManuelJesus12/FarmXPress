<div id="modal"></div>

<article class="col-12 list-prod form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////

if(is_array($productControl)){
    echo "<h2>Tus Productos</h2>";
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if(isset($_GET["action"]) && $_GET["action"]=="insert")
        echo "<div id='alert-success' class='alert alert-success'>Producto agregado correctamente</div>";
    else if(isset($_GET["action"]) && $_GET["action"]=="update")
        echo "<div id='alert-success' class='alert alert-success'>Producto actualizado correctamente</div>";
    else
        echo "<div id='alert-success' class='alert alert-success'>Productos cargados correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//
    //*-----------------------------PRODUCT LIST------------------------------*//
    echo "<a id='add-product' class='btn btn-shape element-green-bg'>Agregar Producto</a>";
    echo "Buscar producto por Nombre o Referencia: <input type='text' id='inputSearch' placeholder='Buscar por Nombre o Referencia'></input>";
    echo "<div id='boxContent' class='row card-deck col-12'></div>";
    //*-----------------------------PRODUCT LIST------------------------------*//

    //--------------------------------------------NAV BUTTONS--------------------------------------------//
    $class0=$class1=$class2="btn btn-log element-green-bg ";
    $class1=$class0."not-visible";
    if(count($productControl)<=5) $class2=$class0."not-visible";

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
    content_paginate(productControl);

    ////////////////////////////FILTRAR PRODUCTOS////////////////////////////
    $("#inputSearch").on("keyup", function(){
        let page = 1; let offset = (page-1)*5;
        let value = $(this).val().toLowerCase();
        
        let filteredProducts = productControl.filter(prod => 
            (prod["Nombre"].toLowerCase().includes(value) || 
            prod["Referencia"].toLowerCase().includes(value)) );
        
        $("#boxContent").empty();
        for(let i=offset; i<offset+5; i++){
            if(filteredProducts[i]!=undefined)
                createContent(filteredProducts[i]);
            else break;
        }
        if(filteredProducts[offset+5]==undefined) $("#btn-next").addClass("not-visible");
        else $("#btn-next").removeClass("not-visible");
        
        if(page==1) $("#btn-prev").addClass("not-visible");
        else $("#btn-prev").removeClass("not-visible");

        $("#btn-page").text(page);
        event.preventDefault();
    })
    ////////////////////////////FILTRAR PRODUCTOS////////////////////////////

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(prod){
        let file = (prod["Imagen"]!=null) ? prod["Imagen"] : "anon.png";
        let estado = ""; let buttons = "<div class='col-6'><a href='#' onclick='updateProduct("+prod["Producto_ID"]+")' class='btn btn-shape btn-product-modify'><i class='fa-solid fa-gear icon-gear border-5'></i> Modificar Producto</a></div>";

        if(prod["Estado"]==false)
            estado+="<p class='card-text prod-status' id='disabled-"+prod["Producto_ID"]+"'>Alquilado</p>";
        else{
            estado+="<p class='card-text prod-status' id='enabled-"+prod["Producto_ID"]+"'>Disponible</p>";
            buttons+="<div class='col-6'><a href='#' onclick='deleteProduct("+prod["Producto_ID"]+")' class='btn btn-shape btn-product-delete'><i class='fa-solid fa-trash icon-trash border-5'></i> Eliminar Producto</a></div>";
        }

        $("#boxContent").append(    
            "<div id='product"+prod['Producto_ID']+"' class='col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>"+
                "<div class='card-header element-green-bg'><a class='element-green-bg text-decoration-underline' href='principal.php?methodProd=viewProduct&id="+prod['Producto_ID']+"'>"+prod["Nombre"]+" - "+prod["Referencia"]+"</a></div>"+
                "<div class='row card-body'>"+
                    "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='../assets/img/products/"+file+"' style='width: 75%; height:auto' /></div>"+
                    "<div class='col-6'>"+
                        "<h5 class='card-title'>"+prod["Descripción"]+"</h5>"+
                        "<p class='card-text'>Categoría: <span>"+prod['CAT']+"</span></p>"+
                        "<p class='card-text'>Precio Mensual: <span>"+prod['Precio_Mensual']+"€</span></p>"+
                        estado+
                        "</div>"+
                    "<div class='col-12 card-buttons'>"+buttons+"</div>"+
                "</div>"+
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