<!--------------------------------------------LÓGICA--------------------------------------------->
<?php 
include("_Indexes/Index_Review.php"); 
include("_Indexes/Index_Rent.php"); 

$cat  = $product["CAT"] ?? "Sin Categoría";
$file = ($product['Imagen']!=null) ? $product['Imagen'] : "anon.png";
setcookie("data-rev", 0, time() - 3600, "/");

$reviewControl = $reviewController -> viewListReview($product["Producto_ID"]); //Reseñas de otros usuarios
if(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){
    $reviewUser    = $reviewController -> selectReview($product["Producto_ID"]); //Ha escrito una reseña el usuario?
    $rentControl   = $rentController   -> selectRent($product["Producto_ID"]); //Ha sido alquilado el producto?
}else $reviewUser  = $rentControl = 0;
?>
<!--------------------------------------------FICHA DETALLES + RESEÑAS--------------------------------------------->
<article class="container site-section catalog-bg rounded p-4">
    <h2 class="text-center mb-4">Detalles del Producto</h2>

    <div class="row g-4">
        <!-- Main content: reviews -->
        <section class="col-lg-6">
            <!-- Write a review -->
            <?php if(!is_array($reviewUser) && is_array($rentControl) && $_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){ ?>
                <div style="margin-top: -60px;">
                    <div class="fw-bold mt-1">Escribir una reseña</div>
                    <div class="card-body">
                        <form id="form-data-review" action="principal.php?methodRev=insert" method="post">
                            <input type="hidden" name="pId" id="pId" value="<?php echo $product["Producto_ID"]; ?>" readonly>
                            <div class="mb-2">
                                <strong>Calificación:</strong>
                                <div class="ms-2 d-inline-block">
                                    <a href="#" class="me-1"><i class="fa-regular fa-star icon-star-rev" id="star-1"></i></a>
                                    <a href="#" class="me-1"><i class="fa-regular fa-star icon-star-rev" id="star-2"></i></a>
                                    <a href="#" class="me-1"><i class="fa-regular fa-star icon-star-rev" id="star-3"></i></a>
                                    <a href="#" class="me-1"><i class="fa-regular fa-star icon-star-rev" id="star-4"></i></a>
                                    <a href="#"><i class="fa-regular fa-star icon-star-rev" id="star-5"></i></a>
                                </div>
                            </div>

                            <div class="mb-2">
                                <textarea class="form-control" name="review" id="review" rows="3" placeholder="Tu mensaje..." required></textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <input type="button" id="btn-data-review" class="btn btn-log element-green-bg" value="Enviar">
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <!-- Reviews list header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Reseñas de otros usuarios</h5>
                <div class="d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="newest" name="orderRev" value="newest" checked>
                        <label class="form-check-label small" for="newest">Más recientes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="oldest" name="orderRev" value="oldest">
                        <label class="form-check-label small" for="oldest">Más antiguas</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="highest" name="orderRev" value="highest">
                        <label class="form-check-label small" for="highest">Mejor valoradas</label>
                    </div>
                </div>
            </div>

            <!-- Reviews container -->
            <div class="row">
                <div id="boxContent" class="col-12"></div>
            </div>

            <!-- Pagination nav -->
            <?php if(is_array($reviewControl) && count($reviewControl)>0){ 
                $class0=$class1=$class2="btn btn-log element-green-bg ";
                $class1=$class0."not-visible";
                if(count($reviewControl)<=5) $class2=$class0."not-visible"; ?>
                <div class="nav-buttons mt-3">
                    <div class="btn-group"><a class="<?php echo $class1; ?>" id="btn-prev" href="#">Anterior</a></div>
                    <div class="btn-group"><a class="<?php echo $class0; ?>" id="btn-page" href="#">1</a></div>
                    <div class="btn-group"><a class="<?php echo $class2; ?>" id="btn-next" href="#">Siguiente</a></div>
                </div>
            <?php } else { echo "<h5 class='text-danger'>Aún no hay reseñas para este producto</h5>"; } ?>
        </section>

        <!-- Sticky aside: image + action -->
        <aside class="col-lg-6 sticky-aside">
            <div class="card element-green-border mb-4">
                <h4 class="fw-bold mb-1 card-header element-green-bg"><?php echo $product["Nombre"]." - ".$product["Referencia"]; ?></h4>
                <div class="card-body text-center">
                    <img class="img-fluid rounded shadow mb-3 card-image" style="max-height:320px; object-fit:cover;" src="<?php echo "../assets/img/products/".$file; ?>" alt="Imagen del producto">
                    <p class="mb-2 text-muted small"><?php echo $cat; ?></p>
                    <p class="mb-1"><strong>Precio Mensual:</strong> <span style="color:limegreen; font-size:1.2em"><?php echo $product["Precio_Mensual"]; ?>€</span></p>

                    <form action="principal.php?methodRent=viewStripe" method="post" class="mt-3">
                        <input type="hidden" name="pId" value='<?php echo $product["Producto_ID"]; ?>'>
                        <input type="hidden" name="price" value='<?php echo $product["Precio_Mensual"]; ?>'>

                        <?php if($product["Estado"]==1){ 
                            if($_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){ ?>
                                <div class="mb-2 d-flex justify-content-center align-items-center">
                                    <label class="me-2 mb-0"><strong>Duración:</strong></label>
                                    <select name="month" class="form-select d-inline-block w-auto">
                                        <option value="1">1 meses</option>
                                        <option value="3">3 meses</option>
                                        <option value="6">6 meses</option>
                                        <option value="12">12 meses</option>
                                        <option value="24">24 meses</option>
                                    </select>
                                </div>
                            <?php } ?>

                            <p class="prod-status mb-2" id="enabled-<?php echo $product["Producto_ID"]; ?>">
                                <i class="fa fa-check-circle me-1"></i>Disponible</p>

                            <?php if($_SESSION["User"]["Nombre"]!=="ADMINISTRADOR"){
                                if($_SESSION["User"]["Tipo"]=="C" && $_SESSION["User"]["Estado"]==1){ ?>
                                <button type="submit" class="btn btn-log btn-shape element-green-bg w-100">Alquilar</button>
                            <?php }else{ ?>
                                <div class="btn btn-shape btn-log btn-danger w-100">Verifica tu cuenta primero</div>
                            <?php }} ?>

                        <?php }else{ ?>
                            <p class="prod-status text-danger mb-2" id="disabled-<?php echo $product["Producto_ID"]; ?>">
                                <i class="fa fa-times-circle me-1"></i>Alquilado</p>
                            <div class="btn btn-shape btn-log btn-danger w-100">Producto no disponible</div>
                        <?php } ?>
                    </form>
                </div>
            </div>

            <div class="card p-3">
                <div class="card-body small text-muted">
                    <h6 class="fw-bold">Descripción</h6>
                    <p class="mb-0"><?php echo $product["Descripcion"]; ?></p>
                </div>
            </div>
        </aside>

    </div>
</article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var reviewControl = <?php echo json_encode($reviewControl); ?>;
    var sessionUser   = <?php echo json_encode($_SESSION["User"]["Nombre"]); ?>;
    content_paginate(reviewControl, 5);
    
    ////////////////////////////ORDENAMIENTO////////////////////////////
    $("input[name='orderRev']").on("change", function(event){
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
            "<div id='rev-"+review["Reseña_ID"]+"' class='review card mb-3'>"+
                "<div class='card-body'>"+
                    "<div class='d-flex align-items-start mb-2'>"+
                        "<img class='img-fluid review-image me-3' src='../assets/img/users/"+file+"' alt='Imagen del usuario'>"+
                        "<div><p class='card-title mb-1'>Escrito por: <span style='color:limegreen'><a href='principal.php?methodUser=viewProfile&id="+review['Usuario_ID']+"' class='text-decoration-underline'>"+review['Nombre']+"</a></span> <small class='text-muted'>el "+ new Date(review['Fecha_Hora']).toLocaleDateString() +"</small></p>"+
                            "<div class='mb-1 text-start'> Calificación: "+
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
    $(".icon-star-rev").on("click", function(event) {
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