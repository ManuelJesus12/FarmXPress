<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php 
///////////////////////////////////////////////////////////////////////
if(isset($_GET["success"])){ ?> <script> showBoxSuccessPay("<?php echo $_GET["success"]; ?>"); </script> <?php }
///////////////////////////////////////////////////////////////////////

if(is_array($rentControl)){ ?>
    <h2>Productos Alquilados</h2><br>
    <input type='text' id='inputSearch' onInput='filterProduct()' placeholder='Filtrar por Nombre o Referencia'></input>
    <div id='boxContent' class='row card-deck col-12'></div>

    <!--------------------------------------------NAV BUTTONS--------------------------------------------->
    <?php
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        $class1=$class0."not-visible";
        if(count($rentControl)<=5) $class2=$class0."not-visible";

        echo "<div class='nav-buttons site-article'>";
            echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
            echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
            echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
        echo "</div>";
    ?>
    <!--------------------------------------------NAV BUTTONS--------------------------------------------->

<?php }else{
    echo "<h2>No hay alquileres registrados</h2><br>";
    echo "<a href='principal.php?methodProd=select' class='element-green-bg btn-log'>Consultar Catálogo</a>";
}
?></article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var productControl = <?php echo json_encode($rentControl); ?>;
    content_paginate(productControl);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(rent){
        let file = (rent["Imagen"]!=null) ? rent["Imagen"] : "anon.png";
        let deuda = (rent["Deuda"]!=null) ? rent["Deuda"] : 0 ;
        let buttons = "";

        if(rent['Deuda']>0){
            buttons+="<a href='#' class='btn btn-shape btn-product-modify btn-pay' onclick='insertPay("+rent['RID']+", "+rent['PID']+", "+rent['Deuda']+")'><i class='fa-solid fa-credit-card icon-credit-card border-5'></i> Realizar Pago</a>";
            buttons+="<a href='#' class='btn btn-shape btn-product-modify btn-select' onclick='viewPay("+rent['RID']+")'><i class='fa-solid fa-credit-card icon-credit-card border-5'></i> Historial de Pagos</a>";
        }else{
            buttons+="<a href='#' class='btn triple-btn col-3 btn-product-extend btn-pay' onclick='insertPay("+rent['RID']+", "+rent['PID']+", "+rent['Deuda']+")'><i class='fa-solid fa-plus icon-plus border-5'></i> Extender</a>";
            buttons+="<a href='#' class='btn triple-btn col-3 btn-product-delete btn-delete' onclick='activeRent("+rent['RID']+", "+rent['PID']+", \""+rent['Nombre'].replace(/"/g, '\\"')+"\")'><i class='fa-solid fa-xmark icon-xmark border-5'></i> Liberar</a>";
            buttons+="<a href='#' class='btn triple-btn col-3 btn-product-modify btn-select' onclick='viewPay("+rent['RID']+")'><i class='fa-solid fa-credit-card icon-credit-card border-5'></i> Pagos</a>";
        }

        $("#boxContent").append(    
            "<div id='rent-"+rent["RID"]+"' class='rent col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>"+
                "<div class='card-header element-green-bg'><a class='element-green-bg text-decoration-underline' href='principal.php?methodProd=viewProduct&id="+rent['PID']+"'>"+rent["Nombre"]+" - "+rent["Referencia"]+"</a></div>"+
                "<div class='row card-body'>"+
                    "<div class='col-6'><img class='card-image img-fluid rounded shadow' src='../assets/img/products/"+file+"' style='width: 75%; height:auto' /></div>"+
                    "<div class='col-6'>"+
                        "<p class='card-text'>Precio Total: <span id='total-price' style='color:limegreen'>"+rent['Precio_Total']+"€</span></p>"+
                        "<p class='card-text'>Cantidad Pendiente: <span id='month-price' style='color:limegreen'>"+deuda+"€</span></p>"+
                        "<p class='card-text'>Fecha Inicio: <span id='start-date'>"+new Date(rent["Fecha_Inicio"]).toLocaleDateString()+"</span></p>"+
                        "<p class='card-text'>Fecha Fin: <span id='end-date'>"+new Date(rent["Fecha_Inicio"]).toLocaleDateString()+"</span></p>"+
                    "</div>"+
                "</div>"+
                "<div class='col-12 card-buttons'>"+buttons+"</div>"+
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>

<script>
    ////////////////////////////AÑADIR PAGO////////////////////////////
    function insertPay(rId, pId, deuda){
        $("#modal").load("Views/Client_Pay_Rent.php?methodRent&rId="+rId+"&pId="+pId+"&deuda="+deuda, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    ////////////////////////////AÑADIR PAGO////////////////////////////

    ////////////////////////////HISTORIAL PAGO////////////////////////////
    function viewPay(rId){
        $("#modal").load("Views/Client_List_Pay.php?methodPay&rId="+rId, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    ////////////////////////////HISTORIAL PAGO////////////////////////////

    ////////////////////////////DESACTIVAR ALQUILER////////////////////////////
    function activeRent(rId, pId, name){
        if(confirm("¿Está seguro de que desea terminar con el alquiler de este producto?")){
            $.ajax({
                url: "principal.php?methodRent=active",
                type: "POST",
                data: { rId: rId, pId: pId },
                success: function(response) {
                    showBoxActiveRent(name);
                    $("#rent-"+rId).fadeOut(300);
                    window.location.reload();
                },
            });
        }
        event.preventDefault();
    }
    ////////////////////////////DESACTIVAR ALQUILER////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->