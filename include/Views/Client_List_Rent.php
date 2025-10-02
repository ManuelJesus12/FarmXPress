<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php include("_Indexes/Index_Pay.php");
///////////////////////////////////////////////////////////////////////
if(isset($_GET["success"])){ ?> <script> showBoxSuccessPay("<?php echo $_GET["success"]; ?>"); </script> <?php }
///////////////////////////////////////////////////////////////////////

if(is_array($rentControl)){
    echo "<h2>Productos Alquilados</h2><br>";
    echo "<div class='row card-deck col-12'>";
    foreach($rentControl as $rent) { 
        //*-----------------------------DATA CONTROL------------------------------*//
        $file=($rent['Imagen']!=null) ? "../assets/img/products/".$rent['Imagen'] : $file="../assets/img/products/anon.png";
        $debtMoney=$payController->selectDebtMoney($rent["Alquiler_ID"]);
        if(is_array($debtMoney)) $debtMoney=$rent["Precio_Total"]-$debtMoney[0]["Debt_Money"];
        //*-----------------------------DATA CONTROL------------------------------*//
    ?>

        <div class='rent col-lg-5 col-md-5 col-sm-12 card card-prod element-green-border rounded'>
            <div class='card-header element-green-bg'><a class="element-green-bg text-decoration-underline" href="<?php echo "principal.php?methodProd=viewProduct&id=".$rent['Producto_ID']."&page=1"; ?>"><?php echo $rent["Nombre"]." - ".$rent["Referencia"]; ?></a></div>
            <div class='row card-body'>
                <div class='col-6'><img class="card-image img-fluid rounded shadow" src="<?php echo $file; ?>" style="width: 75%; height:auto" /></div>
                <div class='col-6'>
                    <p class='card-text'>Precio Total: <span id='total-price' style="color:limegreen"><?php echo $rent['Precio_Total']; ?>€</span></p>
                    <p class='card-text'>Cantidad Pendiente: <span id='month-price' style="color:limegreen"><?php echo $debtMoney; ?>€</span></p>
                    <p class='card-text'>Fecha Inicio: <span id='start-date'><?php echo date("d-m-Y", strtotime($rent["Fecha_Inicio"])); ?></span></p>
                    <p class='card-text'>Fecha Fin: <span id='end-date'><?php echo date("d-m-Y", strtotime($rent["Fecha_Fin"])); ?> </span></p>
                </div>
            </div>
            <div class='col-12 card-buttons'>
                <?php 
                    if($debtMoney>0){ ?>
                        <a href='#' class='btn btn-shape btn-product-modify btn-pay' id='update-<?php echo $rent['Alquiler_ID']."-".$rent['Producto_ID']; ?>'><i class='fa-solid fa-credit-card icon-credit-card border-5'></i> Realizar Pago</a>
                        <a href='#' class='btn btn-shape btn-product-modify btn-select' id='select-<?php echo $rent['Alquiler_ID']."-".$rent['Producto_ID']; ?>'><i class='fa-solid fa-credit-card icon-credit-card border-5'></i> Historial de Pagos </a>
                    <?php }else{ ?>
                        <a href='#' style="font-size:0.8em;" class='btn col-3 btn-product-extend btn-pay' id='update-<?php echo $rent['Alquiler_ID']."-".$rent['Producto_ID']; ?>'><i class='fa-solid fa-plus icon-plus border-5'></i> Extender</a>
                        <a href='#' style="font-size:0.8em;" class='btn col-3 btn-product-delete btn-delete' id='active-<?php echo $rent['Alquiler_ID']."-".$rent['Producto_ID']; ?>'><i class='fa-solid fa-xmark icon-xmark border-5'></i> Liberar</a>
                        <a href='#' style="font-size:0.8em;" class='btn col-3 btn-product-modify btn-select' id='select-<?php echo $rent['Alquiler_ID']."-".$rent['Producto_ID']; ?>'><i class='fa-solid fa-credit-card icon-credit-card border-5'></i> Pagos</a>
                <?php } ?>
            </div>
        </div>
    <?php }

    //*-----------------------------NAV BUTTONS------------------------------*//
    $class0=$class1=$class2="btn btn-log element-green-bg ";
    if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
    if(count($rentControl)<=10) $class2=$class0."not-visible";

    echo "<div class='nav-buttons'>";
        echo "<div class='btn-group'>";
            echo "<a class='$class1' href='principal.php?methodRent=select&page=".($_GET['page']-1)."'>Anterior</a>";
        echo "</div>";
        echo "<div class='btn-group'>";
            echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
        echo "</div><div class='btn-group'>";
            echo "<a class='$class2' href='principal.php?methodRent=select&page=".($_GET['page']+1)."'>Siguiente</a>";
        echo "</div>";
    echo "</div>";
    //*-----------------------------NAV BUTTONS------------------------------*//

}else{
    echo "<h2>No hay alquileres registrados</h2><br>";
    echo "<a href='principal.php?methodProd=select' class='element-green-bg btn-log'>Consultar Catálogo</a>";
}
?></div></article>

<script>
    for(let i=0; i<$(".rent").length; i++){
        //*-----------------------------UPDATE PAY------------------------------*//
        $(".rent").eq(i).find(".btn-pay").on("click", function(){
            let rId=($(this).attr("id")).split("-")[1];
            let pId=($(this).attr("id")).split("-")[2];
            $("#modal").load("Views/Client_Pay_Rent.php?methodRent=select&rId="+rId+"&pId="+pId, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------UPDATE PAY------------------------------*//

        //*-----------------------------PAY HISTORY------------------------------*//
        $(".rent").eq(i).find(".btn-select").on("click", function(){
            let rId=($(this).attr("id")).split("-")[1];
            $("#modal").load("Views/Client_List_Pay.php?methodPay&rId="+rId, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------PAY HISTORY------------------------------*//

        //*-----------------------------DEACTIVATE RENT------------------------------*//
        $(".rent").eq(i).find(".btn-delete").on("click", function(){
            let name=$(this).closest(".rent").find(".card-header").text();
            let rId=($(this).attr("id")).split("-")[1];
            let pId=($(this).attr("id")).split("-")[2];
            let row = $(this).closest(".rent"); 

            if(confirm("¿Está seguro de que desea terminar con el alquiler de este producto?")){
                $.ajax({
                    url: "principal.php?methodRent=active",
                    type: "POST",
                    data: { rId: rId, pId: pId },
                    success: function(response) {
                        showBoxActiveRent(name);
                        row.fadeOut(300);
                    },
                });
            }
        });
        //*-----------------------------DEACTIVATE RENT------------------------------*//
    }
</script>