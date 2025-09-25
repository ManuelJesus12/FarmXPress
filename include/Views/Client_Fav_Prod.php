<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php $productCount=0;
include("_Indexes/Index_Category.php");
///////////////////////////////////////////////////////////////////////
if(isset($productControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($productControl==0){
        echo "<h2>No hay productos en seguimiento</h2><br>";
        echo "<a href='principal.php?methodProd=select' class='btn btn-log element-green-bg'>Consultar Catálogo</a>";
    }else if($productControl==-1){
        echo "<h2>Error al cargar las productos</h2>";
    }else{
        echo "<h2>Productos Seguidos</h2>";
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
                if($this->selectFav($product["Producto_ID"])==0)
                    echo "<a href='#' id='add-".$product["Producto_ID"]."'><i class='fa-regular fa-star icon-star border-5' style='color:orange !important'></i></a>";
                else
                    echo "<a href='#' id='del-".$product["Producto_ID"]."'><i class='fas fa-star icon-star border-5' style='color:orange !important'></i></a>";

                echo "<div class='card-header element-green-bg'>".$product["Nombre"]." - ".$product["Referencia"]."</div>";
                echo "<div class='row card-body'>";
                    echo "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='$file' style='width: 75%;' /></div>";
                    echo "<div class='col-6'>";
                        echo "<p class='card-text'>Categoría: ".$category."</p>";
                        echo "<p class='card-text' style='color: limegreen;'>".$product["Precio_Mensual"]."€ / mes</p>";
                        echo "<p class='card-text'>".$category."</p>";
                        if($product["Estado"]==0)
                            echo "<p class='card-text prod-status' id='disabled-".$product["Producto_ID"]."'>Estado: Alquilado</p>";
                        else if($product["Estado"]==1)
                            echo "<p class='card-text prod-status' id='enabled-".$product["Producto_ID"]."'>Estado: Disponible</p>";
                    echo "</div>";
                echo "</div>";

                echo "<div class='col-12 card-buttons'>";
                    echo "<a href='principal.php?methodProd=viewProduct&id=".$product["Producto_ID"]."' class='btn btn-shape btn-log element-green-bg'>Ver Más</a>";
                echo "</div>";
            echo "</div>";
            //*-----------------------------PRODUCT CARD------------------------------*//

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
                echo "<a class='$class1' href='principal.php?methodFav=select&page=".($_GET['page']-1)."'>Anterior</a>";
            echo "</div>";
            echo "<div class='btn-group'>";
                echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
            echo "</div><div class='btn-group'>";
                echo "<a class='$class2' href='principal.php?methodFav=select&page=".($_GET['page']+1)."'>Siguiente</a>";
            echo "</div>";
        echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<!-------------------------------SCRIPT------------------------------->
    <script src="../assets/js/popup_box_create.js"></script>
    <script src="../assets/js/prod_user_fav.js"></script>
<!-------------------------------SCRIPT------------------------------->