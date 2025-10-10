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
            <thead><tr><th>Pago</th><th>Fecha</th><th>Cantidad Pagada</th><th>Meses Extendido</th></tr></thead>
            <tbody id="boxContent"></tbody></table>

            <?php 
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
<script src="../assets/js/content_paginate.js"></script>

<script>
    var payList = <?php echo json_encode($payControl); ?>;
    content_paginate(payList);
    
    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(pay, i=5){
        $("#boxContent").append("<tr><td>"+(i+1)+"</td><td>"+new Date(pay["Fecha_Hora"]).toLocaleDateString()+"</td><td>"+pay["Cantidad"]+"€</td><td>"+pay["Meses_Extra"]+" meses</td></tr>");
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->
</html>