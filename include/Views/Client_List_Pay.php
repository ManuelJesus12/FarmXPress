<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/principal.css">
    <title>Form Popup</title>
</head>
<body>

    <!-------------------------------LOGICA------------------------------->
    <?php
        $dirLocation=2;
        include("../_Indexes/Index_Interface.php");
        include("../_Indexes/Index_Pay.php");
        $payControl = $payController -> selectPay($_GET["rId"]);
    ?>
    <!-------------------------------LOGICA------------------------------->

<div id="formPopup" class="popup">
    <div class="popup-content" style='position:relative; top: -40;'>
        <button class="close-btn" id="closeFormBtn" style="position:fixed;">X</button>
        <h2>Mostrando Historial de Pagos</h2>
        <table id="boxContent" style="margin:auto" class="table table-striped">
            <thead><tr><th>Pago</th><th>Fecha</th><th>Cantidad Pagada</th><th>Meses Extendido</th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</body>

<!-------------------------------SCRIPT------------------------------->
<script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
<script>
    var payControl = <?php echo json_encode($payControl); ?>;
    var payCount= 1;

    new DataTable('#boxContent', {
            data: payControl,
            columns: [
                { data: null, render: function(data, type, row) { return payCount++; } },
                { data: 'Fecha_Hora', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                { data: 'Cantidad', render: function(data, type, row) { return data+"€"; } },
                { data: 'Meses_Extra', render: function(data, type, row) { return data+" meses"; } }
            ],
            lengthMenu: [3, 5, 7],
            scrollX: true
        });
</script>

<script>
    $("#boxContent_length").find("select").on("change", function() {
        const selectedValue = $(this).val();
        
        if(selectedValue == 3)      $(".popup-content").css("top", "-40");
        else if(selectedValue == 5) $(".popup-content").css("top", "-80");
        else if(selectedValue == 7) $(".popup-content").css("top", "-130");
    });
</script>
<!-------------------------------SCRIPT------------------------------->
</html>