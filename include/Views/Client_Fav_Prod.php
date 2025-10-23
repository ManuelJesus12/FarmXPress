<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////
if(is_array($productControl)){ 
    foreach($productControl as &$prod) $prod['isFav'] = $this->selectFav($prod['PID']); ?>

    <!-------------------------------PRODUCT LIST-------------------------------->
    <h2>Productos en seguimiento</h2><br>
    <input type='text' id='inputSearch' onInput='filterProduct()' placeholder='Filtrar por Nombre o Referencia'></input>
    <div id='boxContent' class='row card-deck col-12'></div>
    <!-------------------------------PRODUCT LIST-------------------------------->
    <!--------------------------------------------NAV BUTTONS--------------------------------------------->
    <?php
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        $class1=$class0."not-visible";
        if(count($productControl)<=5) $class2=$class0."not-visible";

        echo "<div class='nav-buttons site-article'>";
            echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
            echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
            echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
        echo "</div>";
    //--------------------------------------------NAV BUTTONS--------------------------------------------->

}else if($productControl==0){
    echo "<h2>No hay productos en seguimiento</h2><br>";
    echo "<a href='principal.php?methodProd=select' class='btn btn-log element-green-bg'>Consultar Catálogo</a>";
}else if($productControl==-1)
    echo "<h2>Error al cargar las productos</h2>";
///////////////////////////////////////////////////////////////////////
?></article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/popup_box_create.js"></script>
<script src="../assets/js/prod_user_fav.js"></script>
<script src="../assets/js/content_paginate.js"></script>

<script>
    var productControl = <?php echo json_encode($productControl); ?>;
    var sessionUser = <?php echo json_encode($_SESSION["usuario"]); ?>;
    content_paginate(productControl);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(prod){
        let file = (prod["Imagen"]!=null) ? prod["Imagen"] : "anon.png";
        let estado = fav = "";

        if(sessionUser!=null && sessionUser!="ADMINISTRADOR"){
            if(prod["isFav"]==0)
                fav+="<a href='#' id='add-"+prod["PID"]+"' onclick=\"toggleFav("+prod["PID"]+", 'add')\"><i id='fav-star-"+prod["PID"]+"' class='fa-regular fa-star icon-star border-5' style='color:orange !important'></i></a>";
            else
                fav+="<a href='#' id='del-"+prod["PID"]+"' onclick=\"toggleFav("+prod["PID"]+", 'del')\"><i id='fav-star-"+prod["PID"]+"' class='fas fa-star icon-star border-5' style='color:orange !important'></i></a>";
        }

        if(prod["Estado"]==false)
            estado+="<p class='card-text prod-status' id='disabled-"+prod["PID"]+"'>Alquilado</p>";
        else
            estado+="<p class='card-text prod-status' id='enabled-"+prod["PID"]+"'>Disponible</p>";

        $("#boxContent").append(    
            "<div id='prod-"+prod["RID"]+"' class='col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>"+fav+
                "<div class='card-header element-green-bg'><a class='element-green-bg text-decoration-underline' href='principal.php?methodProd=viewProduct&id="+prod['PID']+"'>"+prod["Nombre"]+" - "+prod["Referencia"]+"</a></div>"+
                "<div class='row card-body'>"+
                    "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='../assets/img/products/"+file+"' style='width: 75%; height:auto' /></div>"+
                    "<div class='col-6'>"+
                        "<p class='card-text'>Categoría: <span id='total-price' >"+prod['CAT']+"</span></p>"+
                        "<p class='card-text'>Localización: <span id='total-price' >"+prod['PROV']+"</span></p>"+
                        "<p class='card-text'>Precio Mensual: <span id='total-price' style='color:limegreen'>"+prod['Precio_Mensual']+"€</span></p>"+
                        estado+
                    "</div>"+
                "</div>"+
                "<div class='col-12 card-buttons'>"+
                    "<div class='col-6'><a href='principal.php?methodProd=viewProduct&id="+prod["PID"]+"' class='btn btn-shape btn-log element-green-bg'><i class='fa-solid fa-eye border-5'></i> Ver Más</a></div>"+
                    "<div class='col-6'><a href='principal.php?methodUser=viewProfile&id="+prod["UID"]+"' class='btn btn-shape btn-log element-green-bg'><i class='fa-solid fa-eye border-5'></i> Perfil Proveedor</a></div>"+
                "</div>"+
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->
