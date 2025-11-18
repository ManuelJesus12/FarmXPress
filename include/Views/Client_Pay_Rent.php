<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Popup</title>
    <link rel="stylesheet" href="../assets/css/principal.css">
</head>
<body>

    <!-------------------------------LOGICA------------------------------->
    <?php
        $dirLocation=2;
        include("../_Indexes/Index_Interface.php");
        include("../_Indexes/Index_Product.php");
        include("../_Indexes/Index_Rent.php");

        $productControl=$productController->selectProduct($_GET["pId"]); 
        $rentControl=$rentController->rentModel->selectRent($_GET["pId"]);
        $mPrice=$productControl["Precio_Mensual"];
    ?>
    <!-------------------------------LOGICA------------------------------->

<div id="formPopup" class="popup" style="top: -90;">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn" style="top: 100;">X</button>
        <h2>Realizando pago del alquiler del producto <?php echo $productControl["Nombre"] ?></h2>
        <form id="form-data-pay" action="principal.php?methodPay=viewStripe" method="post">
            <input type="hidden" name="maxAmount" id="maxAmount" value="<?php echo $_GET["deuda"]; ?>" />
            
            <input type="hidden" name="rId" id="rId" value="<?php echo $_GET["rId"]; ?>" />
            <input type="hidden" name="mPrice" id="mPrice" value="<?php echo $mPrice; ?>" />
            <table style="margin:auto" class="table-form">
                <?php if ($_GET["deuda"] > 0) { ?>
                    <tr>
                        <td>Cantidad a pagar (Euros): </td>
                        <td><input type="number" name="amount" id="amount" value="1" max="<?php echo $_GET["deuda"]; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Extender Alquiler (Opcional): </td>
                        <td style="text-align: right;">
                            <select name="month" style="width: 100%;">
                                <option value="" selected>-</option>
                                <option value="1">1 meses</option>
                                <option value="3">3 meses</option>
                                <option value="6">6 meses</option>
                                <option value="12">12 meses</option>
                                <option value="24">24 meses</option>
                        </select></td>
                    </tr>
                <?php }else{ ?>
                    <tr>
                        <td>Extender Duración: </td>
                        <td style="text-align: right;">
                            <select name="month" style="width: 100%;">
                                <option value="1">1 meses</option>
                                <option value="3">3 meses</option>
                                <option value="6">6 meses</option>
                                <option value="12">12 meses</option>
                                <option value="24">24 meses</option>
                        </select></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan=2><input type="submit" class="btn btn-shape element-green-bg" value="Pagar Alquiler"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>

<!-------------------------------SCRIPT------------------------------->
<script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>
<script>
    $("#amount").on("input", function() {
        var value = $(this).val();
        var maxAmount = parseInt($("#maxAmount").val());
        if (value > maxAmount) $(this).val(maxAmount);
        else if(value < 1 || isNan(value)) $(this).val(1);
    });
</script>
<!-------------------------------SCRIPT------------------------------->
</html>