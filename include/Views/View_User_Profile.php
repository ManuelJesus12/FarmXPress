<!--------------------------------------------LÓGICA--------------------------------------------->
<?php 
include("_Indexes/Index_User.php");
include("_Indexes/Index_Product.php");
$userControl = $userController -> selectUser($_GET["id"]);
$productControlP = $productController -> listProductP($_GET["id"]);

$file = ($userControl['Avatar']!=null) ? $userControl['Avatar'] : "anon.png";
$tipo = ($userControl['Tipo']=="C") ? "Cliente" : "Proveedor";
?>
<!--------------------------------------------LÓGICA--------------------------------------------->

<!--------------------------------------------FICHA DETALLES--------------------------------------------->
<article class="col-12 list-prod form-log site-section rounded">
    <h2 class='text-center' style='margin-bottom:15px'>Perfil de Usuario</h2>

    <div class="row justify-content-center align-items-center g-4 mb-5">
        <div class="col-lg-6 col-md-6 text-center mb-3 mb-md-0">
            <img class="img-fluid rounded shadow" style="max-width:350px; width:100%; object-fit:cover;" src="<?php echo "../assets/img/users/".$file; ?>" alt="Avatar del Usuario">
        </div>

        <div class="col-lg-5 col-md-6">
            <div class="card shadow element-green-border rounded-4">
                <div class="card-header element-green-bg text-white fw-bold fs-5">
                    <?php echo $userControl["Nombre"]." - ".$userControl["CIF"]; ?>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Contacto: </strong><?php echo $userControl["Email"]; ?></p>
                    <p class="mb-2"><strong>Localización: </strong> <?php echo $userControl["Provincia"].", ".$userControl["Comunidad"]; ?></p>
                    <p class="mb-2"><strong>Dirección: </strong><?php echo $userControl["Dirección"]; ?></p>
                    <p class="mb-2"><strong>Teléfono: </strong> <?php echo $userControl["Teléfono"]; ?></p>
                    <p class="mb-2"><strong>Tipo de Usuario: </strong> <?php echo $tipo; ?></p>
                </div>
            </div>
        </div>
    </div>
<!--------------------------------------------FICHA DETALLES--------------------------------------------->


<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->
    <h2>Productos del Usuario</h2>
    <div class='row d-flex justify-content-evenly mb-3 mt-3 pt-3' style='border-top:1px solid #ddd;'>
        <?php if(is_array($productControlP)){ 
            echo "<div id='boxContent' class='row card-deck col-12 mb-3'></div>";

            //--------------------------------------------NAV BUTTONS---------------------------------------------//
            $class0=$class1=$class2="btn btn-log element-green-bg ";
            $class1=$class0."not-visible";
            if(count($productControlP)<=5) $class2=$class0."not-visible";

            echo "<div class='nav-buttons site-article'>";
                echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
                echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
                echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
            echo "</div>";
            //--------------------------------------------NAV BUTTONS---------------------------------------------//
        }else echo "<h4 class='text-danger'>Este usuario aún no ha añadido ningún producto.</h4>"; ?>
    </div>
<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->
</article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var productControlP = <?php echo json_encode($productControlP); ?>;
    var sessionUser   = <?php echo json_encode($_SESSION['usuario']) ?? null; ?>;
    content_paginate(productControlP);
    
    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(prod){
        let file = (prod["Imagen"]!=null) ? prod["Imagen"] : "anon.png";
        let buttons = estado = "";

        if(prod["Estado"]==false)
            estado+="<p class='card-text prod-status' id='disabled-"+prod["Producto_ID"]+"'>Alquilado</p>";
        else
            estado+="<p class='card-text prod-status' id='enabled-"+prod["Producto_ID"]+"'>Disponible</p>";

        if(sessionUser!=null)
            buttons+="<div class='col-6'><a href='principal.php?methodProd=viewProduct&id="+prod["Producto_ID"]+"' class='btn btn-shape btn-log element-green-bg'><i class='fa-solid fa-eye border-5'></i> Ver Más</a></div>";
        else
            buttons+="<div class='col-6'><a href='principal.php?methodUser=viewLogin' class='btn btn-shape btn-log element-green-bg'>Iniciar Sesión</a></div>";
        
        $("#boxContent").append(   
            "<div class='col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>"+
                "<div class='card-header element-green-bg'>"+prod["Nombre"]+" - "+prod["Referencia"]+"</div>"+
                    "<div class='row card-body'>"+
                        "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='../assets/img/products/"+file+"' style='width: 75%;' /></div>"+
                        "<div class='col-6'>"+
                            "<p class='card-text'>Categoría: "+prod['CAT']+"</p>"+
                            "<p class='card-text'>Localización: "+prod["Provincia"]+"</p>"+
                            "<p class='card-text' style='color: limegreen;'>"+prod["Precio_Mensual"]+"€ / mes</p>"+
                            estado+
                        "</div>"+
                    "</div>"+
                "<div class='col-12 card-buttons'>"+buttons+"</div>"+
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->