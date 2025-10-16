<!--------------------------------------------LOGICA--------------------------------------------->
<?php
include("_Indexes/Index_Category.php");
include("_Indexes/Index_Fav.php");
$offset=$opt=1; $productCount=0;
$categoryControl = $categoryController->viewListCategory($offset, $opt);

if(isset($_COOKIE["search-options"])){
    $search=json_decode($_COOKIE["search-options"], true);
    $category=$search["category"] ?? "";
    $minPrice=$search["minPrice"] ?? "";
    $maxPrice=$search["maxPrice"] ?? "";
}
if(isset($_GET["error"])) echo "<script>showBoxProduct(".$_GET["error"].");</script>";
?>
<!--------------------------------------------LOGICA--------------------------------------------->

<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->
<article class="row col-12 form-log site-section rounded">
    <!--------------------------------------------FILTRO--------------------------------------------->
    <div class="filter-prod col-lg-2 col-md-2 col-sm-2">
        <h2>Filtrar</h2>
        <div class="form-group">
            <form id="filter-form" action="#" method="POST">
                <label for="category">Categoría: </label>
                <select class="form-control" id="category" name="category">
                    <option value="">Todas</option>
                    <?php
                        foreach($categoryControl as $cat){
                            $selected = ($cat["Categoría_ID"]==$category) ? "selected" : "";
                            echo "<option value='".$cat["Categoría_ID"]."' $selected>".$cat["Nombre"]."</option>";
                        }
                    ?>
                </select><br>

                <label for="minPrice">Precio Mínimo: </label>
                <input type="number" class="form-control" id="minPrice" name="minPrice" min="0" value="<?php echo $minPrice; ?>" ><br>
                
                <label for="maxPrice">Precio Máximo: </label>
                <input type="number" class="form-control" id="maxPrice" name="maxPrice" min="0" value="<?php echo $maxPrice; ?>"><br>
                
                <label for="region">Comunidad Autónoma: </label>
                <select name="region" id="region" class="form-control">
                    <option value="">Seleccione</option>
                </select>
                
                <label for="province">Provincia: </label>
                <select name="province" id="province" class="form-control" disabled>
                    <option value="">Seleccione</option>
                </select>
                
                <input type="button" id="btn-filter-form" class="btn element-green-bg btn-log" value="Filtrar" style="margin-top: 30px;" />
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
            $file = ($product['Imagen']!=null) ? "../assets/img/products/".$product['Imagen'] : "../assets/img/products/anon.png";
            $category = ($product["CAT"] != null) ? $product["CAT"] : "Sin Categoría";
            $estado = ($product["Estado"]==false) ? "disabled-".$product["Producto_ID"] : "enabled-".$product["Producto_ID"];
            //*-----------------------------DATA CONTROL------------------------------*//

            //*-----------------------------PRODUCT CARD------------------------------*//
            echo "<div class='col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>";

                if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="ADMINISTRADOR"){    
                    if($favController->selectFav($product["Producto_ID"])==0)
                        echo "<a href='#' id='add-".$product["Producto_ID"]."' onclick=\"toggleFav(".$product["Producto_ID"].", 'add')\"><i id='fav-star-".$product["Producto_ID"]."' class='fa-regular fa-star icon-star border-5' style='color:orange !important'></i></a>";
                    else
                        echo "<a href='#' id='del-".$product["Producto_ID"]."' onclick=\"toggleFav(".$product["Producto_ID"].", 'del')\"><i id='fav-star-".$product["Producto_ID"]."' class='fas fa-star icon-star border-5' style='color:orange !important'></i></a>";
                }

                echo "<div class='card-header element-green-bg'>".$product["Nombre"]." - ".$product["Referencia"]."</div>";
                echo "<div class='row card-body'>";
                    echo "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='$file' style='width: 75%;' /></div>";
                    echo "<div class='col-6'>";
                        echo "<p class='card-text'>Categoría: ".$category."</p>";
                        echo "<p class='card-text'>Localización: ".$product["PROV"]."</p>";
                        echo "<p class='card-text' style='color: limegreen;'>".$product["Precio_Mensual"]."€ / mes</p>";
                        if($product["Estado"]==false)
                            echo "<p class='card-text prod-status' id='disabled-".$product["Producto_ID"]."'>Alquilado</p>";
                        else
                            echo "<p class='card-text prod-status' id='enabled-".$product["Producto_ID"]."'>Disponible</p>";
                    echo "</div>";
                echo "</div>";

                echo "<div class='col-12 card-buttons'>";
                    if(isset($_SESSION["usuario"])){
                        echo "<div class='col-6'><a href='principal.php?methodProd=viewProduct&id=".$product["Producto_ID"]."' class='btn btn-shape btn-log element-green-bg'><i class='fa-solid fa-eye border-5'></i> Ver Más</a></div>";
                        echo "<div class='col-6'><a href='principal.php?methodUser=viewProfile&id=".$product["Usuario_ID"]."' class='btn btn-shape btn-log element-green-bg'><i class='fa-solid fa-eye border-5'></i> Perfil Proveedor</a></div>";
                    }else
                        echo "<div class='col-6'><a href='principal.php?methodUser=viewLogin' class='btn btn-shape btn-log element-green-bg'>Iniciar Sesión</a></div>";
                echo "</div>";
            echo "</div>";
            //*-----------------------------PRODUCT CARD------------------------------*//

            if($productCount==10) break; else $productCount++;
        }
        echo "</div>";
        //*-----------------------------PRODUCT LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
        if(count($productControl)<=10) $class2=$class0."not-visible";

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
?></div></div></article>
<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->

<!-------------------------------SCRIPT------------------------------->
    <script src="../assets/js/provinces_load.js"></script>
    <script src="../assets/js/popup_box_create.js"></script>
    
    <?php if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="ADMINISTRADOR"){ ?> 
        <script src="../assets/js/prod_user_fav.js"></script> 
    <?php } ?>

    <script>
        $('#btn-filter-form').on('click', function() {            
            var search = { category: $('#category').val(), minPrice: $('#minPrice').val(), maxPrice: $('#maxPrice').val(), region: $('#region').val() ?? "", province: $('#province').val() ?? "" };
            document.cookie = "search-options=" + JSON.stringify(search) + "; path=/; max-age=" + (86400 * 30);
            localStorage.setItem('search-options', JSON.stringify(search));
            $('#filter-form').submit();

            event.preventDefault();
        });
    </script>
<!-------------------------------SCRIPT------------------------------->