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

<!--------------------------------------------LISTA PRODUCTOS (IMPROVED)--------------------------------------------->
<article class="container-fluid site-section">
    <div class="row">
        <!-- FILTER / SIDEBAR -->
        <aside class="col-lg-3 col-md-4 mb-4 sticky-aside">
            <div class="card form-log h-100">
                <div class="card-body">
                    <h5 class="card-title">Filtrar Productos</h5>
                    <form id="filter-form" action="#" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Todas</option>
                                <?php
                                    foreach($categoryControl as $cat){
                                        $selected = ($cat["Categoría_ID"]==$category) ? "selected" : "";
                                        echo "<option value='".$cat["Categoría_ID"]."' $selected>".$cat["Nombre"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rango de Precio (€)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="minPrice" name="minPrice" min="0" placeholder="Mín" value="<?php echo $minPrice; ?>">
                                <span class="input-group-text">-</span>
                                <input type="number" class="form-control" id="maxPrice" name="maxPrice" min="0" placeholder="Máx" value="<?php echo $maxPrice; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Comunidad Autónoma</label>
                            <select name="region" id="region" class="form-control">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="province" class="form-label">Provincia</label>
                            <select name="province" id="province" class="form-control" disabled>
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <input type="button" id="btn-filter-form" class="btn element-green-bg btn-log" value="Aplicar filtros" />
                            <input type="button" id="btn-filter-clear" class="btn btn-danger btn-log text-white" value="Restablecer" />
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        <!-- PRODUCT LIST -->
        <main class="col-lg-9 col-md-8">
            <div class="form-log p-3">
            <?php
            ///////////////////////////////////////////////////////////////////////
            if(isset($productControl)){
                //*-----------------------------NOTIFICATIONS------------------------------*//
                if($productControl==0){
                    echo "<div class='alert alert-warning'>No hay productos que mostrar</div>";
                }else if($productControl==-1){
                    echo "<div class='alert alert-danger'>Error al cargar los productos</div>";
                }else{
                    echo "<h3 class='section-title'>Catálogo de Productos</h3>";
                //*-----------------------------NOTIFICATIONS------------------------------*//

                    //*-----------------------------PRODUCT LIST------------------------------*//
                    echo "<div class='row g-3'>";
                    foreach($productControl as $product){
                        //*-----------------------------DATA CONTROL------------------------------*//
                        $file = ($product['Imagen']!=null) ? "../assets/img/products/".$product['Imagen'] : "../assets/img/products/anon.png";
                        $category = ($product["CAT"] != null) ? $product["CAT"] : "Sin Categoría";
                        $estado = ($product["PEST"]==false) ? "<span class='badge bg-danger'>Alquilado</span>" : "<span class='badge bg-success'>Disponible</span>";
                        //*-----------------------------DATA CONTROL------------------------------*//

                        //*-----------------------------PRODUCT CARD------------------------------*//
                        echo "<div class='col-12 col-md-6 col-lg-4'>";
                            echo "<div class='card h-100 element-green-border'>";

                                // favorite star (keeps same ids used in JS)
                                if(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){
                                    if($favController->selectFav($product["Producto_ID"])==0)
                                        echo "<a href='#' id='add-".$product["Producto_ID"]."' onclick=\"toggleFav(".$product["Producto_ID"].", 'add')\" class='has-tooltip' data-tooltip='Agregar a favoritos'><i id='fav-star-".$product["Producto_ID"]."' class='fa-regular fa-star icon-star border-5'></i></a>";
                                    else
                                        echo "<a href='#' id='del-".$product["Producto_ID"]."' onclick=\"toggleFav(".$product["Producto_ID"].", 'del')\" class='has-tooltip' data-tooltip='Quitar de favoritos'><i id='fav-star-".$product["Producto_ID"]."' class='fas fa-star icon-star border-5'></i></a>";
                                }

                                echo "<div class='card-header element-green-bg'>".$product["PNOM"]." - ".$product["Referencia"]."</div>";
                                echo "<div class='card-body d-flex flex-column'>";
                                    echo "<img src='$file' class='card-img-top' alt='Imagen producto' style='margin-bottom:10px'>";
                                    echo "<p class='card-text mb-1'>Localización: <strong>{$product['PROV']}</strong></p>";
                                    echo "<p class='card-text mb-1'>Categoría: <strong>{$product['CAT']}</strong></p>";
                                    echo "<div class='mt-auto d-flex justify-content-between align-items-center'>";
                                        echo "<div>{$estado}</div>";
                                        echo "<div class='text-end'><span class='h5' style='color: limegreen;'>{$product['Precio_Mensual']}€/mes</div>";
                                    echo "</div>";
                                echo "</div>";

                                echo "<div class='card-footer bg-transparent border-top-0'>";
                                    echo "<div class='d-flex gap-2'>";
                                        if(isset($_SESSION["User"])){
                                            echo "<a href='principal.php?methodProd=viewProduct&id=".$product["Producto_ID"]."' class='btn btn-sm element-green-bg btn-shape w-50'><i class='fa-solid fa-eye margin-5'></i> Acceder</a>";
                                            echo "<a href='principal.php?methodUser=viewProfile&id=".$product["UID"]."'  class='btn btn-sm element-green-bg btn-shape w-50'><i class='fa-solid fa-user margin-5'></i> Proveedor</a>";
                                        }else{
                                            echo "<a href='principal.php?methodUser=viewLogin' class='btn btn-sm element-green-bg btn-shape w-100'>Iniciar Sesión</a>";
                                        }
                                    echo "</div>";
                                echo "</div>";

                            echo "</div>";
                        echo "</div>";
                        //*-----------------------------PRODUCT CARD------------------------------*//

                        if($productCount==8) break; else $productCount++;
                    }
                    echo "</div>";
                    //*-----------------------------PRODUCT LIST------------------------------*//

                    //*-----------------------------NAV BUTTONS------------------------------*//
                    $class0=$class1=$class2="btn btn-log element-green-bg ";
                    if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
                    if(count($productControl)<=10) $class2=$class0."not-visible";

                    echo "<div class='nav-buttons mt-4'>";
                        echo "<div class='btn-group'>";
                            echo "<a class='$class1' href='principal.php?methodProd=select&page=".((int)($_GET['page'] ?? 1)-1)."'>Anterior</a>";
                        echo "</div>";
                        echo "<div class='btn-group'>";
                            echo "<a class='$class0' href='#'>".((int)($_GET["page"] ?? 1))."</a>";
                        echo "</div><div class='btn-group'>";
                            echo "<a class='$class2' href='principal.php?methodProd=select&page=".((int)($_GET['page'] ?? 1)+1)."'>Siguiente</a>";
                        echo "</div>";
                    echo "</div>";
                    //*-----------------------------NAV BUTTONS------------------------------*//
                }
            }
            ///////////////////////////////////////////////////////////////////////
            ?>
            </div>
        </main>
    </div>
</article>
<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->

<!-------------------------------SCRIPT------------------------------->
    <script>
        const currentRegion  =<?php echo (isset($search["region"])) ? "'".$search["region"]."'" : "null"; ?>;
        const currentProvince=<?php echo (isset($search["province"])) ? "'".$search["province"]."'" : "null"; ?>;
    </script>
    <script src="../assets/js/provinces_load.js"></script>
    <script src="../assets/js/popup_box_create.js"></script>
    <script src="../assets/js/prod_user_fav.js"></script>

    <script>
        $('#btn-filter-form').on('click', function(event) {            
            var search = { category: $('#category').val(), minPrice: $('#minPrice').val(), maxPrice: $('#maxPrice').val(), region: $('#region').val() ?? "", province: $('#province').val() ?? "" };
            document.cookie = "search-options=" + JSON.stringify(search) + "; path=/; max-age=" + (86400 * 30);
            localStorage.setItem('search-options', JSON.stringify(search));
            $('#filter-form').submit();

            event.preventDefault();
        });

        $('#btn-filter-clear').on('click', function(event) {
            document.cookie = "search-options=; path=/; max-age=0";
            $('#filter-form').submit();

            event.preventDefault();
        });
    </script>
<!-------------------------------SCRIPT------------------------------->