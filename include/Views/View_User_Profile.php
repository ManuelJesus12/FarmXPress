<!--------------------------------------------LÓGICA--------------------------------------------->
<?php 
include("_Indexes/Index_User.php");
include("_Indexes/Index_Product.php");

$userControl = $userController->selectUser($_GET["id"]);
$productControlP = $productController->listProductP($_GET["id"]);

$file = ($userControl['Avatar'] != null) ? $userControl['Avatar'] : "anon.png";
$tipo = ($userControl['Tipo'] == "C") ? "Cliente" : "Proveedor";
?>
<!--------------------------------------------LÓGICA--------------------------------------------->

<!--------------------------------------------FICHA DETALLES--------------------------------------------->
<article class="container site-section catalog-bg rounded shadow-sm py-4">
    <div class="row g-4 align-items-center">
        <div class="col-12 col-md-4 text-center">
            <img src="<?php echo "../assets/img/users/".$file; ?>" alt="Avatar del Usuario" class="img-fluid rounded-circle shadow" style="max-width:220px; width:100%; object-fit:cover;">
            <div class="mt-3">
                <span class="badge bg-success"><?php echo $tipo ?></span>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="card element-green-border">
                <div class="card-body">
                    <h3 class="card-title mb-1"><?php echo $userControl["Nombre"].' <small class="text-muted"> - '.$userControl["CIF"].'</small>'; ?></h3>
                    <p class="mb-2"><strong>Contacto:</strong> <?php echo $userControl["Email"]; ?></p>
                    <p class="mb-2"><strong>Localización:</strong> <?php echo $userControl["Provincia"].', '.$userControl["Comunidad"]; ?></p>
                    <p class="mb-2"><strong>Dirección:</strong> <?php echo $userControl["Direccion"]; ?></p>
                    <p class="mb-2"><strong>Teléfono:</strong> <?php echo $userControl["Telefono"]; ?></p>
                </div>
            </div>
        </div>
    </div>

<!--------------------------------------------FICHA DETALLES--------------------------------------------->
<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->
    <div class="mt-4">
        <h4 class="mb-3">Productos del Usuario</h4>

        <?php if(is_array($productControlP) && count($productControlP) > 0): ?>
            <div id="boxContent" class="row g-3 form-log justify-content-evenly"></div>

            <!--------------------------------------------NAV BUTTONS--------------------------------------------->
            <?php
                $class0=$class1=$class2="btn btn-log element-green-bg ";
                $class1=$class0."not-visible";
                if(count($productControlP)<=8) $class2=$class0."not-visible";

                echo "<div class='nav-buttons site-article'>";
                    echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
                    echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
                    echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
                echo "</div>";
            ?>
            <!--------------------------------------------NAV BUTTONS--------------------------------------------->
        <?php else: ?>
            <div class="alert alert-warning">Este usuario aún no ha añadido ningún producto.</div>
        <?php endif; ?>
    </div>
</article>

<!--------------------------------------------LISTA PRODUCTOS--------------------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var productControlP = <?php echo json_encode($productControlP); ?>;
    var sessionUser = <?php echo json_encode(isset($_SESSION['User']) ? $_SESSION["User"]["Nombre"] : null); ?>;
    content_paginate(productControlP, 8);

    // Create product card using Bootstrap and site's CSS
    function createContent(prod){
        let file = (prod["Imagen"]!=null) ? prod["Imagen"] : "anon.png";
        let cat  = (prod["CAT"]!=null)  ? prod["CAT"] : "Sin Categoría";
        const disponible = prod["Estado"] ? 
            `<span class="badge bg-success">Disponible</span>` :
            `<span class="badge bg-danger">Alquilado</span>`;

        const price = `<div class="h5 text-success mb-2">${prod["Precio_Mensual"]}€ <small class="text-muted">/ mes</small></div>`;

        const actionBtn = (sessionUser != null)
            ? `<a href="principal.php?methodProd=viewProduct&id=${prod["Producto_ID"]}" class="btn btn-sm btn-log element-green-bg btn-shape w-100"><i class="fa-solid fa-eye"></i> Acceder</a>`
            : `<a href="principal.php?methodUser=viewLogin" class="btn btn-sm btn-log element-green-bg w-100">Iniciar Sesión</a>`;

        $("#boxContent").append(
            "<div class='col-12 col-md-6 col-lg-3'>"+
                "<div class='card h-100 element-green-border'>"+
                    "<div class='card-header element-green-bg'>"+prod["Nombre"]+" - "+prod["Referencia"]+"</div>"+
                        "<div class='card-body d-flex flex-column' style='color: white !important; text-shadow: black 1px 0 5px, black 0 1px 5px, black 1px 0 5px, black 1px 0 5px !important; '>"+
                            "<img src='../assets/img/products/"+file+"' class='card-img-top card-image' style='margin-bottom:10px' alt='"+prod["Nombre"]+"></img>"+
                            "<p class='card-text mb-1'>Categoría: "+cat+"</p>"+
                            "<div class='mt-auto d-flex justify-content-between align-items-center'>"+
                                "<div>"+disponible+"</div>"+
                                "<div class='text-end'><span class='h5' style='color: limegreen;'>"+prod['Precio_Mensual']+"€/mes</div>"+
                            "</div>"+
                            "<div class='card-footer bg-transparent border-top-0'><div class='d-flex gap-2'>"+
                                actionBtn+
                            "</div></div>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
            "</div>");
        }
</script>