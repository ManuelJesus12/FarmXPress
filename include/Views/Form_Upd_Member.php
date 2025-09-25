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
        $dirChangeVar=1;
        include("../funciones.php");
        include("../_Indexes/Index_Member.php");
        $member = $memberController->selectMember();
    ?>
    <!-------------------------------LOGIC------------------------------->

    <!-------------------------------FORM------------------------------->
    <div id="formPopup" class="popup">
    <div class="popup-content">
        <button class="close-btn" id="closeFormBtn">X</button>
        <h2>Extender Suscripción</h2>

        <form action="principal.php?methodMember=update" method="post">
            <table class="table-form" style="margin:auto">
                <tr>
                    <td>Meses a extender:</td>
                    <td><select id="months" name="months" style="width: 100%;">
                        <option value="1" selected>1 meses</option>
                        <option value="3">3 meses</option>
                        <option value="6">6 meses</option>
                        <option value="12">12 meses</option>
                        <option value="24">24 meses</option>
                    </select></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" class="btn-log element-green-bg" value="Aceptar" /></td>
                </tr>
            </table>
        </form>
    </div></div>
    <!-------------------------------FORM------------------------------->

    <!-------------------------------SCRIPT------------------------------->
    <script>
        $("#closeFormBtn").click(function(){
            $("#formPopup").fadeOut();
        });
    </script>
    <!-------------------------------SCRIPT------------------------------->

</body>
</html>