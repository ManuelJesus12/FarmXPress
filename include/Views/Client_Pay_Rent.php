<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Popup</title>
    <link rel="stylesheet" href="../assets/css/formPopup.css">
</head>
<body>

    <!-------------------------------LOGIC------------------------------->
    <?php
    include("../funciones.php");
    $dirChangeVar=1; $field="Producto_ID";

    include("../_Indexes/Index_Product.php");
    include("../_Indexes/Index_Rent.php");
    include("../_Indexes/Index_Pay.php");
    $productControl=$productController->selectProduct($field, $_GET["pId"]);
    $rentControl=$rentController->rentModel->selectRent($_GET["pId"]);
    $mPrice=$productControl[0]["Precio_Mensual"];

    $debtMoney=$payController->selectDebtMoney($rentControl[0]["Alquiler_ID"]);
    if(is_array($debtMoney)) $debtMoney=$rentControl[0]["Precio_Total"]-$debtMoney[0]["Debt_Money"];
    else $debtMoney=$rentControl[0]["Precio_Total"];
    ?>
    <!-------------------------------LOGIC------------------------------->

<div id="formPopup" class="popup" style="top: -90;">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn" style="top: 100;">X</button>
        <h2>Realizando pago del alquiler del producto <?php echo $productControl[0]["Nombre"] ?></h2>
        <form id="form-data-pay" action="principal.php?methodPay=viewStripe" method="post">
            <input type="hidden" name="maxAmount" id="maxAmount" value="<?php echo $debtMoney; ?>" />
            
            <input type="hidden" name="rId" id="rId" value="<?php echo $_GET["rId"]; ?>" />
            <input type="hidden" name="mPrice" id="mPrice" value="<?php echo $mPrice; ?>" />
            <table style="margin:auto" class="table-form">
                <?php if ($debtMoney > 0) { ?>
                    <tr>
                        <td>Cantidad a pagar (Euros): </td>
                        <td><input type="number" name="amount" id="amount" value="1" max="<?php echo $debtMoney; ?>" /></td>
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

<script>
    $("#closeFormBtn").click(function() {
        $("#formPopup").fadeOut();
    });

    $("#amount").on("input", function() {
        var value = $(this).val();
        var maxAmount = parseInt($("#maxAmount").val());
        if (value > maxAmount) $(this).val(maxAmount);
        else if(value < 1 || isNan(value)) $(this).val(1);
    });
</script>

</body>
</html>