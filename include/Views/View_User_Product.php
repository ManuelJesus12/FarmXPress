<!--------------------------------------------LÓGICA--------------------------------------------->
<?php 
include("_Indexes/Index_Review.php"); 
include("_Indexes/Index_Category.php"); 
include("_Indexes/Index_Rent.php"); 

$file = ($product['Imagen']!=null) ? $product['Imagen'] : "anon.png";
$reviewControl = $reviewController -> viewListReview($product["Producto_ID"]); //Reseñas de otros usuarios
$categoryP = $categoryController   -> selectCategory($product["Categoría_ID"])['Nombre'] ?? "Sin Categoría"; //Categorías

if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="ADMINISTRADOR"){
    $reviewUser    = $reviewController -> selectReview($product["Producto_ID"]); //Ha escrito una reseña el usuario?
    $rentControl   = $rentController   -> selectRent($product["Producto_ID"]); //Ha sido alquilado el producto?
}else  $reviewUser = $rentControl = 0;
setcookie("data-rev", 0, time() - 3600, "/");
?>
<!--------------------------------------------LÓGICA--------------------------------------------->

<!--------------------------------------------FICHA DETALLES--------------------------------------------->
<?php if(isset($_GET["success"])){ ?> <script> showboxContent("<?php echo $_GET["success"]; ?>"); </script> <?php } ?>

<article class="col-12 list-prod form-log site-section rounded">
    <h2 class='text-center' style='margin-bottom:15px'>Detalles del Producto</h2>

    <div class="row justify-content-center align-items-center g-4 mb-5">
        <div class="col-lg-6 col-md-6 text-center mb-3 mb-md-0">
            <img class="img-fluid rounded shadow" style="max-width:350px; width:100%; object-fit:cover;" src="<?php echo "../assets/img/products/".$file; ?>" alt="Imagen del producto">
        </div>

        <div class="col-lg-5 col-md-6">
            <div class="card shadow element-green-border rounded-4">
                <div class="card-header element-green-bg text-white fw-bold fs-5">
                    <?php echo $product["Nombre"]." - ".$product["Referencia"]; ?>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Precio Mensual:</strong><br><span style="color:limegreen; font-size: 1.2em"> <?php echo $product["Precio_Mensual"]; ?>€</span></p>
                    <p class="mb-2"><strong>Descripción:</strong> <?php echo $product["Descripción"]; ?></p>
                    <p class="mb-3"><strong>Categoría:</strong> <?php echo $categoryP; ?></p>
                    <form action="principal.php?methodRent=viewStripe" method="post">
                        <input type="hidden" name="pId" value='<?php echo $product["Producto_ID"]; ?>'>
                        <input type="hidden" name="price" value='<?php echo $product["Precio_Mensual"]; ?>'>
                        <?php if($product["Estado"]==1 && $_SESSION["usuario"]!="ADMINISTRADOR" && isset($_COOKIE["UserType"]) && $_COOKIE["UserType"]=="C") { ?>
                            <div class="mb-2">
                                <strong>Duración del alquiler:</strong>
                                <select name="month" class="form-select d-inline-block w-auto ms-2 me-1" style="width:80px;">
                                    <option value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="6">6</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                </select>
                                <span>meses</span>
                            </div>
                            <p class="card-text prod-status text-success fw-semibold mb-2" id='enabled-<?php echo $product["Producto_ID"]; ?>'>
                                <i class="fa fa-check-circle me-1"></i>Estado: Disponible
                            </p>
                            <button type="submit" class="col-6 btn btn-log btn-shape element-green-bg text-center py-2 mb-0">Alquilar</button>
                        <?php }else if($product["Estado"]==0 && $_SESSION["usuario"]!="ADMINISTRADOR"){ ?>
                            <p class="card-text prod-status text-danger fw-semibold mb-2" id='disabled-<?php echo $product["Producto_ID"]; ?>'>
                                <i class="fa fa-times-circle me-1"></i>Estado: Alquilado
                            </p>
                            <div class="col-6 btn btn-shape btn-log btn-danger text-center py-2 mb-0">Producto no disponible</div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--------------------------------------------FICHA DETALLES--------------------------------------------->

<!--------------------------------------------ESCRIBIR RESEÑA--------------------------------------------->
    <?php if(!is_array($reviewUser) && is_array($rentControl) && $_SESSION["usuario"]!="ADMINISTRADOR"){ ?>
    <div class='col-6 rounded text-center mb-5' style='margin:auto;'>
        <h2>Escribir una reseña</h2>
        <form action='principal.php?methodRev=insert' method='post'>
            <input type="hidden" name="pId" id="pId" value='<?php echo $product["Producto_ID"]; ?>' readonly></input>
            <strong>Calificación: </strong>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-1"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-2"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-3"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-4"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-5"></i></a>
            
            <textarea placeholder="Tu mensaje..." class='form-control' id='res' name='res' rows='3' required></textarea>
            <input type="submit" value="Enviar" class="btn btn-log element-green-bg mt-2">
        </form>
    </div>
    <?php } ?>
<!--------------------------------------------ESCRIBIR RESEÑA--------------------------------------------->

<!--------------------------------------------LISTA RESEÑAS--------------------------------------------->
    <h2>Reseñas de otros usuarios</h2>
    <div class='row d-flex justify-content-evenly mb-3 mt-3 pt-3' style='border-top:1px solid #ddd;'>
        <?php if(is_array($reviewControl) && count($reviewControl)>0){ ?>
            <div id='boxContent' class='col-lg-6 mb-3'></div>
            <div class='col-lg-3'>
                Ordenar reseñas por:
                <input type="radio" id="newest" name="orderRev" value="newest" checked>
                <label for="newest">Más recientes</label><br>
                <input type="radio" id="oldest" name="orderRev" value="oldest">
                <label for="oldest">Más antiguas</label><br>
                <input type="radio" id="highest" name="orderRev" value="highest">
                <label for="highest">Mejor valoradas</label><br>
            </div>
        <?php }else echo "<h4 class='text-danger'>Aún no hay reseñas para este producto</h4>"; ?>
    </div>
<!--------------------------------------------LISTA RESEÑAS--------------------------------------------->

<!--------------------------------------------NAV BUTTONS--------------------------------------------->
<?php
    $class0=$class1=$class2="btn btn-log element-green-bg ";
    $class1=$class0."not-visible";
    if(count($reviewControl)<=5) $class2=$class0."not-visible";

    echo "<div class='nav-buttons site-article'>";
        echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
        echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
        echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
    echo "</div>";
?>
<!--------------------------------------------NAV BUTTONS--------------------------------------------->
</article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var reviewControl = <?php echo json_encode($reviewControl); ?>;
    var sessionUser   = <?php echo json_encode($_SESSION['usuario']) ?? null; ?>;
    content_paginate(reviewControl);
    
    ////////////////////////////ORDENAMIENTO////////////////////////////
    $("input[name='orderRev']").on("change", function(){
        event.preventDefault();

        let order = $("input[name='orderRev']:checked").val();
        if(order=="newest") reviewControl.sort((a,b) => new Date(b["Fecha_Hora"]) - new Date(a["Fecha_Hora"]));
        if(order=="oldest") reviewControl.sort((a,b) => new Date(a["Fecha_Hora"]) - new Date(b["Fecha_Hora"]));
        if(order=="highest") reviewControl.sort((a,b) => b["Calificación"] - a["Calificación"]);

        $("#boxContent").empty();
        for(let i=0; i<5; i++){
            if(reviewControl[i]!=undefined)
                createContent(reviewControl[i]);
            else break;

            if(reviewControl[i+1]==undefined) $("#btn-next").addClass("not-visible");
            else $("#btn-next").removeClass("not-visible");
        }
        $("#btn-page").text(1);
    });
    ////////////////////////////ORDENAMIENTO////////////////////////////

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(review){
        let file = (review["Imagen"]!=null) ? review["Imagen"] : "anon.png";
        let starsHtml = "";
        for(let i=1; i<=5; i++){
            let classStar = (i<=review['Calificación']) ? 'fas' : 'fa-regular';
            starsHtml += "<i class='fa-star icon-rev "+classStar+"'></i>";
        }

        let deleteBtn = "";
        if(review['Nombre']==sessionUser || sessionUser=='ADMINISTRADOR')
            deleteBtn = "<a href='#' onclick='deleteReview("+review['Reseña_ID']+")' class='btn btn-danger btn-delete mt-2'>Eliminar</a>";

        $("#boxContent").append(
            "<div id='rev-"+review["Reseña_ID"]+"' class='review card col-lg-12 col-md-5 col-sm-10 mb-3'>"+
                "<div class='card-body'>"+
                    "<div class='d-flex align-items-start mb-2'>"+
                        "<img class='img-fluid card-image me-3 review-image' src='../assets/img/users/"+file+"' alt='Imagen del usuario'>"+
                        "<div><p class='card-title mb-1'>Escrito por: <span style='color:limegreen'>"+review['Nombre']+"</span> el día <span style='color:limegreen'>"+new Date(review["Fecha_Hora"]).toLocaleDateString()+"</span></p>"+
                            "<div class='mb-1 text-start'> Calificación:"+
                                starsHtml +
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<p class='card-text text-start'>"+review['Comentario']+"</p>"+
                    deleteBtn +
                "</div>"+
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>

<script>
    ////////////////////////////ELIMINAR RESEÑA////////////////////////////
    function deleteReview(id) {
        event.preventDefault()
        
        if(confirm("¿Estás seguro de que quieres eliminar esta reseña?")) {
            $.ajax({
                type: "POST",
                url: "principal.php?methodRev=delete",
                data: {id: id},
                success: function(response) {
                    showboxContent(-1);
                    $("#rev-"+id).remove();
                    window.location.reload();
                }
            });
        }
    }
    ////////////////////////////ELIMINAR RESEÑA////////////////////////////
</script>

<script>
    //////////////////////////////CALIFICACION////////////////////////////////
    $(".icon-star-rev").on("click", function() {
        event.preventDefault()

        var id = $(this).attr("id").split("-")[1];
        var stars = $(".icon-star-rev");
        for (var i = 1; i <= id; i++) {
            $(stars[i - 1]).removeClass("fa-regular").addClass("fas");
        }
        for (var i = parseInt(id) + 1; i <= stars.length; i++) {
            $(stars[i - 1]).removeClass("fas").addClass("fa-regular");
        }

        document.cookie = "data-rev=" + id + "; path=/";
    });
    //////////////////////////////CALIFICACION////////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->