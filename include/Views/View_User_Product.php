<!--------------------------------------------LÓGICA--------------------------------------------->
<?php 
include("_Indexes/Index_Review.php"); 
include("_Indexes/Index_Rent.php"); 

$cat  = $product["CAT"] ?? "Sin Categoría";
$file = ($product['Imagen']!=null) ? $product['Imagen'] : "anon.png";
setcookie("data-rev", 0, time() - 3600, "/");

$reviewControl = $reviewController -> viewListReview($product["Producto_ID"]); //Reseñas de otros usuarios
if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="ADMINISTRADOR"){
    $reviewUser    = $reviewController -> selectReview($product["Producto_ID"]); //Ha escrito una reseña el usuario?
    $rentControl   = $rentController   -> selectRent($product["Producto_ID"]); //Ha sido alquilado el producto?
}else $reviewUser  = $rentControl = 0;
?>
<!--------------------------------------------LÓGICA--------------------------------------------->

<!--------------------------------------------FICHA DETALLES--------------------------------------------->
<?php if(isset($_GET["success"])){ ?> <script> showBoxActionRev("<?php echo $_GET["success"]; ?>"); </script> <?php } ?>

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
                    <p class="mb-3"><strong>Categoría:</strong> <?php echo $cat; ?></p>
                    <form action="principal.php?methodRent=viewStripe" method="post">
                        <input type="hidden" name="pId" value='<?php echo $product["Producto_ID"]; ?>'>
                        <input type="hidden" name="price" value='<?php echo $product["Precio_Mensual"]; ?>'>

                        <?php if($product["Estado"]==1){
                            if($_SESSION["usuario"]!="ADMINISTRADOR"){
                                echo "<div class='mb-2'>";
                                    echo "<strong>Duración del alquiler:</strong>";
                                    echo "<select name='month' class='form-select d-inline-block w-auto ms-2 me-1' style='width:80px;'>";
                                        echo "<option value='1'>1</option>";
                                        echo "<option value='3'>3</option>";
                                        echo "<option value='6'>6</option>";
                                        echo "<option value='12'>12</option>";
                                        echo "<option value='24'>24</option>";
                                    echo "</select><span>meses</span>";
                                echo "</div>";
                            }

                            echo "<p class='card-text prod-status text-success fw-semibold mb-2' id='enabled-".$product["Producto_ID"]."'>";
                                echo "<i class='fa fa-check-circle me-1'></i>Estado: Disponible</p>";

                            if(isset($_COOKIE["UserType"]) && isset($_COOKIE["UserStatus"]) && $_COOKIE["UserType"]=="C" && $_COOKIE["UserStatus"]==1)
                                echo "<button type='submit' class='col-6 btn btn-log btn-shape element-green-bg text-center py-2 mb-0'>Alquilar</button>";
                            else
                                echo "<div class='col-6 btn btn-shape btn-log btn-danger text-center py-2 mb-0'>Verifica tu cuenta primero</div>";

                        }else{
                            echo "<p class='card-text prod-status text-danger fw-semibold mb-2' id='disabled-".$product["Producto_ID"]."'>";
                                echo "<i class='fa fa-times-circle me-1'></i>Estado: Alquilado</p>";
                            echo "<div class='col-6 btn btn-shape btn-log btn-danger text-center py-2 mb-0'>Producto no disponible</div>";
                        } ?>

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
        <form id='form-data-review' action='principal.php?methodRev=insert' method='post'>
            <input type="hidden" name="pId" id="pId" value='<?php echo $product["Producto_ID"]; ?>' readonly></input>
            <strong>Calificación: </strong>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-1"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-2"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-3"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-4"></i></a>
            <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-5"></i></a>
            
            <textarea class='form-control' name='review' id='review' rows='3' placeholder="Tu mensaje..." required></textarea>
            <input type="button" id="btn-data-review" class="btn btn-log element-green-bg mt-2" value="Enviar">
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
            
        <?php }else echo "<h4 class='text-danger'>Aún no hay reseñas para este producto</h4>"; ?>
    </div>
<!--------------------------------------------LISTA RESEÑAS--------------------------------------------->
</article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var reviewControl = <?php echo json_encode($reviewControl); ?>;
    var sessionUser   = <?php echo json_encode($_SESSION['usuario']) ?? null; ?>;
    content_paginate(reviewControl);
    
    ////////////////////////////ORDENAMIENTO////////////////////////////
    $("input[name='orderRev']").on("change", function(){
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
        event.preventDefault();
    });
    ////////////////////////////ORDENAMIENTO////////////////////////////

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(review){
        let file = (review["Imagen"]!=null) ? review["Imagen"] : "anon.png";
        let starsHtml = deleteBtn = "";
        
        if(review['Nombre']==sessionUser || sessionUser=='ADMINISTRADOR')
            deleteBtn = "<a href='#' onclick='deleteReview("+review['Reseña_ID']+")' class='btn btn-danger btn-delete mt-2'>Eliminar</a>";
        for(let i=1; i<=5; i++){
            let classStar = (i<=review['Calificación']) ? 'fas' : 'fa-regular';
            starsHtml += "<i class='fa-star icon-rev "+classStar+"'></i>";
        }
        
        $("#boxContent").append(
            "<div id='rev-"+review["Reseña_ID"]+"' class='review card col-lg-12 col-md-5 col-sm-10 mb-3'>"+
                "<div class='card-body'>"+
                    "<div class='d-flex align-items-start mb-2'>"+
                        "<img class='img-fluid card-image me-3 review-image' src='../assets/img/users/"+file+"' alt='Imagen del usuario'>"+
                        "<div><p class='card-title mb-1'>Escrito por: <span style='color:limegreen'>"+review['Nombre']+"</span> el día <span style='color:limegreen'>"+new Date(review["Fecha_Hora"]).toLocaleDateString()+"</span></p>"+
                            "<div class='mb-1 text-start'> Calificación:"+
                                starsHtml+
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
        if(confirm("¿Estás seguro de que quieres eliminar esta reseña?")) {
            $.ajax({
                type: "POST",
                url: "principal.php?methodRev=delete",
                data: {id: id},
                success: function(response) {
                    $("#rev-"+id).remove();
                    window.location.reload();
                }
            });
        }
        event.preventDefault();
    }
    ////////////////////////////ELIMINAR RESEÑA////////////////////////////
</script>

<script>
    //////////////////////////////CONTROL ESCRITURA RESEÑA////////////////////////////////
    $("#btn-data-review").on("click", function(){
        let review = $("#review").val().trim();
        if (review.length < 5 || review.length > 255) {
            $("#review").attr("placeholder","La reseña debe tener entre 5 y 255 caracteres");
            $("#review").addClass("input-error");
            $("#review").focus();
            return;
        }
        $("#form-data-review").submit();
    });
    //////////////////////////////CONTROL ESCRITURA RESEÑA////////////////////////////////

    //////////////////////////////CONTROL CALIFICACIÓN////////////////////////////////
    $(".icon-star-rev").on("click", function() {
        var id = $(this).attr("id").split("-")[1];
        var stars = $(".icon-star-rev");
        for (var i = 1; i <= id; i++)
            $(stars[i - 1]).removeClass("fa-regular").addClass("fas");
        for (var i = parseInt(id) + 1; i <= stars.length; i++) 
            $(stars[i - 1]).removeClass("fas").addClass("fa-regular");

        document.cookie = "data-rev=" + id + "; path=/";
        event.preventDefault();
    });
    //////////////////////////////CONTROL CALIFICACIÓN////////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->