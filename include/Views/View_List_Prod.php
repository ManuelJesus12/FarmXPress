<div id="modal"></div>

<article class="col-12 list-prod form-log site-section rounded">
<?php $productCount=0;
///////////////////////////////////////////////////////////////////////
if(isset($productControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($productControl==0){
        echo "<h2>No hay productos registrados</h2><br>";
        echo "<a id='add-product' class='btn btn-shape element-green-bg'>Agregar Producto</a>";
    }else if($productControl==-1){
        echo "<h2>Error al cargar las productos</h2>";
    }else{
        if(isset($_GET["action"]) && $_GET["action"]=="insert")
            echo "<div id='alert-success' class='alert alert-success'>Producto agregado correctamente</div>";
        else if(isset($_GET["action"]) && $_GET["action"]=="update")
            echo "<div id='alert-success' class='alert alert-success'>Producto actualizado correctamente</div>";
        else
            echo "<div id='alert-success' class='alert alert-success'>Productos cargados correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//

        //*-----------------------------PRODUCT LIST------------------------------*//
        echo "<a id='add-product' class='btn btn-shape element-green-bg'>Agregar Producto</a>";
        echo "<div class='row card-deck col-12'>";
        foreach($productControl as $product){
            if($product['Imagen']!=null) $file="../assets/img/products/".$product['Imagen']; else $file="../assets/img/products/anon.png";

            include("_Indexes/Index_Category.php");
            if($product["Categoría_ID"]==null) 
                $category="Sin categoría";
            else
                $category = $categoryController->selectCategory($product["Categoría_ID"])[0]["Nombre"];

            echo "<div class='col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>";
                echo "<div class='card-header element-green-bg'>".$product["Nombre"]." - ".$product["Referencia"]."</div>";
                echo "<div class='row card-body'>";
                    echo "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='$file' style='width: 75%' /></div>";
                    echo "<div class='col-6'><h5 class='card-title'>".$product["Descripción"]."</h5>";
                        echo "<p class='card-text' style='color: limegreen;'>Precio Mensual: ".$product["Precio_Mensual"]."€</p>";
                        echo "<p class='card-text'>Categoría: ".$category."</p>";
                        
                        if($product["Estado"]==0)
                            echo "<p class='card-text' id='disabled-".$product["Producto_ID"]."'>Estado: Alquilado</p>";
                        else if($product["Estado"]==1)
                            echo "<p class='card-text' id='enabled-".$product["Producto_ID"]."'>Estado: Disponible</p>";
                    echo "</div>";
                    echo "<div class='col-12 card-buttons'>";
                        echo "<div class='col-6'><a href='#' id='update-".$product["Producto_ID"]."' class='btn btn-shape btn-product-modify'><i class='fa-solid fa-gear icon-gear border-5'></i> Modificar Producto</a></div>";
                        if($product["Estado"]==1)
                            echo "<div class='col-6'><a href='#' id='delete-".$product["Producto_ID"]."' class='btn btn-shape btn-product-delete'><i class='fa-solid fa-trash icon-trash border-5'></i> Eliminar Producto</a></div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";

            $productCount++; if($productCount==6) break;
        }
        echo "</div>";
        //*-----------------------------PRODUCT LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
            $class0=$class1=$class2="btn btn-log element-green-bg ";
            if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
            if(count($productControl)<=6) $class2=$class0."not-visible";

            echo "<div class='nav-buttons'>";
                echo "<div class='btn-group'>";
                    echo "<a class='$class1' href='principal.php?methodProd=select&page=".($_GET['page']-1)."'>Anterior</a>";
                echo "</div>";
                echo "<div class='btn-group'>";
                    echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
                echo "</div><div class='btn-group'>";
                    echo "<a class='$class2' href='principal.php?methodProd=select&page=".($_GET['page']+1)."'>Siguiente</a>";
                echo "</div>";
            echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<script>
///////////////////////////////////////////////////////////////////////
$(document).ready(function(){ 
    //*-----------------------------INSERT------------------------------*//
    $("#add-product").on("click", function() {
        $("#modal").load("Views/Form_Add_Prod.php?methodProd", function() { $("#formPopup").fadeIn(1000); });
    });
    //*-----------------------------INSERT------------------------------*//

    for(let $i=0;$i<$(".card").length;$i++){
        //*-----------------------------UPDATE------------------------------*//
        $(".card").eq($i).find("a").eq(0).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            $("#modal").load("Views/Form_Add_Prod.php?methodProd&id="+id, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------UPDATE------------------------------*//

        //*-----------------------------DELETE------------------------------*//
        $(".card").eq($i).find("a").eq(1).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            let $div = $(this).closest(".card"); 

            if(confirm("¿Está seguro de que desea eliminar este producto?")){
                $.ajax({
                    url: "principal.php?methodProd=delete",
                    type: "POST",
                    data: { deleteId: id },
                    success: function(response) {
                            $div.fadeOut(300);
                            window.location.reload();
                    },
                    error: function() { alert("Error inesperado."); }
                });
            }
        });
        //*-----------------------------DELETE------------------------------*//
    }
});
///////////////////////////////////////////////////////////////////////
</script>