<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////
if(is_array($productControl)){ 
    foreach($productControl as &$prod) $prod['isFav'] = $this->selectFav($prod['PID']); ?>

    <!-------------------------------PRODUCT LIST-------------------------------->
    <h2>Productos en seguimiento</h2><br>
    <input type='text' id='inputSearch' onInput='filterProduct()' placeholder='Filtrar por Nombre o Referencia'></input>
    <div id='boxContent' class='row card-deck'></div>
    <!-------------------------------PRODUCT LIST-------------------------------->
    <!--------------------------------------------NAV BUTTONS--------------------------------------------->
    <?php
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        $class1=$class0."not-visible";
        if(count($productControl)<=8) $class2=$class0."not-visible";

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
    var sessionUser = <?php echo json_encode($_SESSION["User"]["Nombre"]); ?>;
    content_paginate(productControl, 8);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(prod){
        let file = (prod["Imagen"]!=null) ? prod["Imagen"] : "anon.png";
        let estado = fav = cat = "";

        cat = (prod["CAT"]!=null) ? prod["CAT"] : "Sin Categoría";
        if(sessionUser!=null && sessionUser!="ADMINISTRADOR"){
            if(prod["isFav"]==0)
                fav+="<a href='#' id='add-"+prod["PID"]+"' onclick=\"toggleFav("+prod["PID"]+", 'add')\"><i id='fav-star-"+prod["PID"]+"' class='fa-regular fa-star icon-star border-5' style='color:orange !important'></i></a>";
            else
                fav+="<a href='#' id='del-"+prod["PID"]+"' onclick=\"toggleFav("+prod["PID"]+", 'del')\"><i id='fav-star-"+prod["PID"]+"' class='fas fa-star icon-star border-5' style='color:orange !important'></i></a>";
        }

        const disponible = prod["Estado"] ? 
            `<span class="badge bg-success">Disponible</span>` :
            `<span class="badge bg-danger">Alquilado</span>`;

        $("#boxContent").append(
            "<div id='prod-"+prod["RID"]+"' class='col-12 col-md-6 col-lg-4'>"+
                "<div class='card h-100 element-green-border'>"+
                    "<div class='card-header element-green-bg'><a class='element-green-bg text-decoration-underline' href='principal.php?methodProd=viewProduct&id="+prod['PID']+"'>"+prod["Nombre"]+" - "+prod["Referencia"]+"</a></div>"+fav+
                        "<div class='card-body d-flex flex-column' style='color: white !important; text-shadow: black 1px 0 5px, black 0 1px 5px, black 1px 0 5px, black 1px 0 5px !important; '>"+
                            "<img src='../assets/img/products/"+file+"' class='card-img-top mb-3' alt='"+prod["Nombre"]+"></img>"+
                            "<p class='card-text mb-1'>Categoría: "+cat+"</p>"+
                            "<p class='card-text mb-1'>Localización: "+prod['PROV']+"</p>"+
                            "<div class='mt-auto d-flex justify-content-between align-items-center'>"+
                                "<div>"+disponible+"</div>"+
                                "<div class='text-end'><span class='h5' style='color: limegreen;'>"+prod['Precio_Mensual']+"€/mes</div>"+
                            "</div>"+
                            "<div class='card-footer bg-transparent border-top-0'><div class='d-flex gap-2'>"+
                                "<div class='col-6'><a href='principal.php?methodProd=viewProduct&id="+prod["PID"]+"' class='btn btn-sm btn-log element-green-bg btn-shape w-100'><i class='fa-solid fa-eye border-5'></i> Acceder</a></div>"+
                                "<div class='col-6'><a href='principal.php?methodUser=viewProfile&id="+prod["UID"]+"' class='btn btn-sm btn-log element-green-bg btn-shape w-100'><i class='fa-solid fa-user border-5'></i> Proveedor</a></div>"+
                            "</div></div>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->
