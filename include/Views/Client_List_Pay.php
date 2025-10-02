<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Popup</title>
    <link rel="stylesheet" href="../assets/css/formPopup.css">
</head>
<body>

    <!-------------------------------LOGICA------------------------------->
    <?php
        $dirChangeVar=1; $i=1;
        include("../funciones.php");
        include("../_Indexes/Index_Pay.php");
        $payControl = $payController -> selectPay($_GET["rId"]);
    ?>
    <!-------------------------------LOGICA------------------------------->

<div id="formPopup" class="popup" style="top: -90;">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn" style="top: 100;">X</button>
        <h2>Mostrando Historial de Pagos</h2>
        <table style="margin:auto" class="table table-striped">
            <thead><tr><th>Pago</th><th>Fecha</th><th>Cantidad Pagada</th><th>Meses Extendido</th></tr></thead><tbody>
            <?php 
                if(is_array($payControl)){
                    foreach($payControl as $pay){ 
                        echo "<tr><td>$i</td>";
                        echo "<td>".date('d-m-Y', strtotime($pay["Fecha_Hora"]))."</td>";
                        echo "<td>".$pay["Cantidad"]."€</td>";
                        echo "<td>".$pay["Meses_Extra"]." meses</td></tr>";

                        if($i==5) break; else $i++;
                    }
                }else
                    echo "<tr><td colspan='4'>No hay pagos realizados.</td></tr>";
                echo "</tbody></table>";

                //*-----------------------------NAV BUTTONS------------------------------*//
                $class0=$class1=$class2="btn btn-log element-green-bg ";
                $class1=$class0."not-visible";
                if(count($payControl)<=5) $class2=$class0."not-visible";

                echo "<div class='nav-buttons site-article'>";
                    echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
                    echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
                    echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
                echo "</div>";
                //*-----------------------------NAV BUTTONS------------------------------*//

            ?>
    </div>
</div>
</body>

<!-------------------------------SCRIPT------------------------------->
<script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>

<!--FUNCIÓN PAGINACIÓN HISTORIAL DE PAGOS-->
<script>
    var payList = <?php echo json_encode($payControl); ?>;
    
    /////////////////////////////BOTÓN DERECHO/////////////////////////////
    $("#btn-next").on("click", function(){
        $("#formPopup table tbody").empty();
        let page = parseInt($("#btn-page").text())+1;
        let offset = (page-1)*5;

        for(let i=offset; i<offset+5; i++){
            if(payList[i]!=undefined)
                $("#formPopup table tbody").append("<tr><td>"+(i+1)+"</td><td>"+new Date(payList[i]["Fecha_Hora"]).toLocaleDateString()+"</td><td>"+payList[i]["Cantidad"]+"€</td><td>"+payList[i]["Meses_Extra"]+" meses</td></tr>");
            else break;
            if(payList[i+1]==undefined) $("#btn-next").addClass("not-visible");
            else $("#btn-next").removeClass("not-visible");
        }
        $("#btn-prev").removeClass("not-visible");
        $("#btn-page").text(page);
    });
    /////////////////////////////BOTÓN DERECHO/////////////////////////////

    ////////////////////////////BOTÓN IZQUIERDO////////////////////////////
    $("#btn-prev").on("click", function(){
        $("#formPopup table tbody").empty();
        let page = parseInt($("#btn-page").text())-1;
        let offset = (page-1)*5;

        for(let i=offset; i<offset+5; i++){
            if(payList[i]!=undefined)
                $("#formPopup table tbody").append("<tr><td>"+(i+1)+"</td><td>"+new Date(payList[i]["Fecha_Hora"]).toLocaleDateString()+"</td><td>"+payList[i]["Cantidad"]+"€</td><td>"+payList[i]["Meses_Extra"]+" meses</td></tr>");
            else break;
        }

        if(page==1) $("#btn-prev").addClass("not-visible");
        else $("#btn-prev").removeClass("not-visible");
        $("#btn-next").removeClass("not-visible");
        $("#btn-page").text(page);
    });
    ////////////////////////////BOTÓN IZQUIERDO////////////////////////////
</script>
<!--FUNCIÓN PAGINACIÓN HISTORIAL DE PAGOS-->
<!-------------------------------SCRIPT------------------------------->
</html>