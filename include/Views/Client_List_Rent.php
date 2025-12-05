<div id="modal"></div>

<article class="col-12 list-prod form-log site-section rounded">
<?php 
///////////////////////////////////////////////////////////////////////
if(isset($_GET["success"])){ ?> <script> showBoxSuccessPay("<?php echo $_GET["success"]; ?>"); </script> <?php }
///////////////////////////////////////////////////////////////////////

if(is_array($rentControl)){ ?>
    <h2>Productos Alquilados</h2><br>
    <input type='text' id='inputSearch' onInput='filterProduct(8)' placeholder='Filtrar por Nombre o Referencia'></input>
    <div id='boxContent' class='row card-deck'></div>

    <!--------------------------------------------NAV BUTTONS--------------------------------------------->
    <?php
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        $class1=$class0."not-visible";
        if(count($rentControl)<=8) $class2=$class0."not-visible";

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
    content_paginate(productControl, 8);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(rent){
        let file = (rent["Imagen"]!=null) ? rent["Imagen"] : "anon.png";
        let deuda = (rent["Deuda"]!=null) ? rent["Deuda"] : 0 ;
        let buttons = "";

        if(rent['Deuda']>0){
            buttons += "<div class='col-12 d-flex gap-2 flex-wrap'>" +
                "<a href='#' class='btn btn-sm btn-product-modify btn-shape flex-fill' onclick='insertPay("+rent['RID']+", "+rent['PID']+", "+rent['Deuda']+")'><i class='fa-solid fa-credit-card border-5'></i> Realizar Pago</a>" +
                "<a href='#' class='btn btn-sm element-green-bg btn-shape flex-fill' onclick='viewPay("+rent['RID']+")'><i class='fa-solid fa-credit-card border-5'></i> Pagos</a>" +
            "</div>";
        }else{
            buttons += "<div class='col-12 d-flex gap-2 flex-wrap'>" +
                "<a href='#' class='btn btn-sm btn-product-extend btn-shape flex-fill' onclick='insertPay("+rent['RID']+", "+rent['PID']+", "+rent['Deuda']+")'><i class='fa-solid fa-plus border-5'></i> Extender</a>" +
                "<a href='#' class='btn btn-sm btn-product-delete btn-shape flex-fill' onclick='activeRent("+rent['RID']+", "+rent['PID']+", \""+String(rent['Nombre']).replace(/\\"/g, '\\"').replace(/"/g, '\\"')+"\")'><i class='fa-solid fa-xmark border-5'></i> Liberar</a>" +
                "<a href='#' class='btn btn-sm element-green-bg btn-shape flex-fill' onclick='viewPay("+rent['RID']+")'><i class='fa-solid fa-credit-card border-5'></i> Pagos</a>" +
            "</div>";
        }

        $("#boxContent").append(
            "<div id='rent-"+rent["RID"]+"' class='col-12 col-md-6 col-lg-4'>" +
                "<div class='card h-100 element-green-border'>" +
                    "<div class='card-header element-green-bg'><a class='element-green-bg text-decoration-underline' href='principal.php?methodProd=viewProduct&id="+rent['PID']+"'>"+rent["Nombre"]+" - "+rent["Referencia"]+"</a></div>" +
                    "<div class='card-body d-flex flex-column'>" +
                        "<img src='../assets/img/products/"+file+"' class='card-img-top mb-3' alt='"+rent["Nombre"]+"'/>" +
                        "<p class='card-text mb-1'>Precio Total: <strong style='color:limegreen'>"+rent['Precio_Total']+"€</strong></p>" +
                        "<p class='card-text mb-1'>Cantidad Pendiente: <strong style='color:limegreen'>"+deuda+"€</strong></p>" +
                        "<p class='card-text mb-1'>Fecha Inicio: <span>"+(rent["Fecha_Inicio"] ? new Date(rent["Fecha_Inicio"]).toLocaleDateString() : '-')+"</span></p>" +
                        "<p class='card-text mb-1'>Fecha Fin: <span>"+(rent["Fecha_Fin"] ? new Date(rent["Fecha_Fin"]).toLocaleDateString() : '-')+"</span></p>" +
                        "<div class='mt-auto'>" + buttons + "</div>" +
                    "</div>" +
                "</div>" +
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