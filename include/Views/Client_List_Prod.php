<!--------------------------------------------LOGICA--------------------------------------------->
<?php
include("_Indexes/Index_Category.php");
include("_Indexes/Index_Fav.php");

$offset=$opt=1; $productCount=0;
$categoryControl = $categoryController->viewListCategory($offset, $opt);

$minPrice=$maxPrice=$category="";
if(isset($_GET["minPrice"]) && $_GET["minPrice"]!="") $minPrice=$_GET["minPrice"];
if(isset($_GET["maxPrice"]) && $_GET["maxPrice"]!="") $maxPrice=$_GET["maxPrice"];
if(isset($_GET["category"]) && $_GET["category"]!="") $category=$_GET["category"];

if(isset($_GET["error"]))
    echo "<script>showBoxProduct(".$_GET["error"].");</script>";
?>
<!--------------------------------------------LOGICA--------------------------------------------->

<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->
<article class="row col-12 form-log site-section rounded">
    <!--------------------------------------------FILTRO--------------------------------------------->
    <div class="filter-prod col-lg-2 col-md-2 col-sm-2">
        <h2>Filtrar</h2>
        <div class="form-group">
            <form id="filter-form" action="principal.php" method="GET" >
                <input type="hidden" name="methodProd" value="select">
                <input type="hidden" name="page" value="1">

                <label for="category">Categoría: </label>
                <select class="form-control" id="category" name="category">
                    <option value="">Todas</option>
                    <?php
                        foreach($categoryControl as $cat){
                            if($cat["Categoría_ID"]==$category) $selected="selected"; else $selected="";
                            echo "<option value='".$cat["Categoría_ID"]."' $selected>".$cat["Nombre"]."</option>";
                        }
                    ?>
                </select><br>

                <label for="minPrice">Precio Mínimo: </label>
                <input type="number" class="form-control" id="minPrice" name="minPrice" min="0" value="<?php echo $minPrice; ?>" ><br>
                
                <label for="maxPrice">Precio Máximo: </label>
                <input type="number" class="form-control" id="maxPrice" name="maxPrice" min="0" value="<?php echo $maxPrice; ?>"><br>
                
                <input type="submit" class="btn element-green-bg btn-log" value="Filtrar" />
            </form>
        </div>
    </div>
    <!--------------------------------------------FILTRO--------------------------------------------->

    <!--------------------------------------------VISTA--------------------------------------------->
    <div class="list-prod col-lg-10 col-md-9 col-sm-9">
<?php
///////////////////////////////////////////////////////////////////////
if(isset($productControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($productControl==0){
        echo "<h2>No hay productos que mostrar</h2><br>";
    }else if($productControl==-1){
        echo "<h2>Error al cargar las productos</h2>";
    }else{
        echo "<h2>Catálogo de Productos</h2>";
    //*-----------------------------NOTIFICATIONS------------------------------*//

        //*-----------------------------PRODUCT LIST------------------------------*//
        echo "<div class='row card-deck col-12'>";
        foreach($productControl as $product){
            //*-----------------------------DATA CONTROL------------------------------*//
            if($product['Imagen']!=null) $file="../assets/img/products/".$product['Imagen']; else $file="../assets/img/products/anon.png";

            if($product["Categoría_ID"]==null) $category="Sin categoría";
            else $category = $categoryController->selectCategory($product["Categoría_ID"])[0]["Nombre"];
            //*-----------------------------DATA CONTROL------------------------------*//

            //*-----------------------------PRODUCT CARD------------------------------*//
            echo "<div class='col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>";
                if($_SESSION["usuario"]!="ADMINISTRADOR"){    
                    if($favController->selectFav($product["Producto_ID"])==0)
                        echo "<a href='#' id='add-".$product["Producto_ID"]."'><i class='fa-regular fa-star icon-star border-5' style='color:orange !important'></i></a>";
                    else
                        echo "<a href='#' id='del-".$product["Producto_ID"]."'><i class='fas fa-star icon-star border-5' style='color:orange !important'></i></a>";
                }

                echo "<div class='card-header element-green-bg'>".$product["Nombre"]." - ".$product["Referencia"]."</div>";
                echo "<div class='row card-body'>";
                    echo "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='$file' style='width: 75%;' /></div>";
                    echo "<div class='col-6'>";
                        echo "<p class='card-text'>Categoría: ".$category."</p>";
                        echo "<p class='card-text' style='color: limegreen;'>".$product["Precio_Mensual"]."€ / mes</p>";
                        if($product["Estado"]==0)
                            echo "<p class='card-text prod-status' id='disabled-".$product["Producto_ID"]."'>Alquilado</p>";
                        else if($product["Estado"]==1)
                            echo "<p class='card-text prod-status' id='enabled-".$product["Producto_ID"]."'>Disponible</p>";
                    echo "</div>";
                echo "</div>";

                echo "<div class='col-12 card-buttons'>";
                    if($_SESSION["usuario"]=="ADMINISTRADOR" && $product["Estado"]==1){
                        echo "<div class='col-5'><a href='principal.php?methodProd=viewProduct&id=".$product["Producto_ID"]."' class='btn btn-shape btn-log element-green-bg' style='padding:5px 15px 7px 15px;'><i class='fa-solid fa-eye border-5'></i> Ver Más</a></div>";
                        echo "<div class='col-5'><a href='#' id='delete-".$product["Producto_ID"]."' class='btn btn-shape btn-product-delete btn-delete'><i class='fa-solid fa-trash icon-trash border-5'></i> Eliminar</a></div>";
                    }else{
                        echo "<div class='col-6'><a href='principal.php?methodProd=viewProduct&id=".$product["Producto_ID"]."' class='btn btn-shape btn-log element-green-bg'><i class='fa-solid fa-eye border-5'></i> Ver Más</a></div>";
                    }
                echo "</div>";
            echo "</div>";
            //*-----------------------------PRODUCT CARD------------------------------*//

            $productCount++; if($productCount==6) break;
        }
        echo "</div>";
        //*-----------------------------PRODUCT LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
        $queryString = "";
        if(isset($_GET['category']) && $_GET['category']!="")
            $queryString.="&category=".$_GET['category'];
        if(isset($_GET['minPrice']) && $_GET['minPrice']!="")
            $queryString.="&minPrice=".$_GET['minPrice'];
        if(isset($_GET['maxPrice']) && $_GET['maxPrice']!="")
            $queryString.="&maxPrice=".$_GET['maxPrice'];

        $class0=$class1=$class2="btn btn-log element-green-bg ";
        if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
        if(count($productControl)<=6) $class2=$class0."not-visible";

        echo "<div class='nav-buttons'>";
            echo "<div class='btn-group'>";
                echo "<a class='$class1' href='principal.php?methodProd=select&page=".($_GET['page']-1).$queryString."'>Anterior</a>";
            echo "</div>";
            echo "<div class='btn-group'>";
                echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
            echo "</div><div class='btn-group'>";
                echo "<a class='$class2' href='principal.php?methodProd=select&page=".($_GET['page']+1).$queryString."'>Siguiente</a>";
            echo "</div>";
        echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></div></div></article>
<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->

<!-------------------------------SCRIPT------------------------------->
    <?php if($_SESSION["usuario"]!="ADMINISTRADOR"){ ?> <script src="../assets/js/prod_user_fav.js"></script> <?php } ?>
    <script src="../assets/js/popup_box_create.js"></script>
    <script>
        for(let $i=0;$i<$(".card").length;$i++){
            //*-----------------------------DELETE------------------------------*//
            $(".card").eq($i).find(".btn-delete").on("click", function(){
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
    </script>
<!-------------------------------SCRIPT------------------------------->