<article class="col-8 list-cat form-log site-section rounded">
<!--------------------------------------------LOGICA--------------------------------------------->
<?php 
$methods = explode('-', $_GET['methodAdmin']);
if(in_array("newLog", $methods)){ 

    include("_Indexes/Index_User.php"); $offset=0;
    $users = $userController->viewListUser($offset);
?>
<!--------------------------------------------LOGICA--------------------------------------------->

<!--------------------------------------------SECCION--------------------------------------------->
    <h1>Visualización de Información</h1>
    <h5>Elija un usuario concreto y/o fechas de inicio y de fin, o deje los campos vacíos para no filtrar la información</h5>
    <table style="margin:auto;">
    <form action="#" method="post" id=log-form>
        <tr>
            <td style="text-align:start">Usuario:</td>
            <td><select name="searchUser" id="searchUser" style="width: 100%;">
                <option value="">---</option>
                <?php
                    if($users!=0)
                        foreach($users as $user) echo "<option value='".$user['Usuario_ID']."'>".$user['Nombre']."</option>";
                ?>
            </select></td>
        </tr>
        <tr>
        <td style="text-align:start">Fecha Inicio:</td>
            <td><input type="date" name="startDate" id="startDate" /></td>
        </tr>
        <tr>
            <td style="text-align:start">Fecha Fin:</td>
            <td><input type="date" name="endDate" id="endDate" /></td>
        </tr>
    </form>
    </table><br>

    <a href="principal.php?methodAdmin=select&type=visit" class="btn-log element-green-bg" id="log-visit" >Ver Historial Visitas</a>   
    <a href="principal.php?methodAdmin=select&type=rent"  class="btn-log element-green-bg" id="log-rent"  >Ver Historial Alquileres</a><br>
<!--------------------------------------------SECCION--------------------------------------------->

<!--------------------------------------------SECCION--------------------------------------------->
<?php }else if(in_array("viewLog", $methods)){ ?>
    <h2>Seleccione fecha del Log a visualizar</h2>
    <form action="principal.php?methodAdmin=select&type=read" method="post">
        <select name="log" class="col-lg-6 col-mb-12">
            <?php
                $files = array_diff(scandir("../logs", SCANDIR_SORT_DESCENDING), array(".",".."));
                for($i=0;$i<count($files);$i++)
                    echo "<option value='".$files[$i]."'> ".$files[$i]."</option>";
            ?>
        </select> 
        <input type="submit" class="col-lg-6 col-mb-12 btn-log element-green-bg" value="Visualizar" />
    </form>
<?php } ?>
<!--------------------------------------------SECCION--------------------------------------------->
</article>

<script>
$("#log-visit").on("click",function(){
    $("#log-form").attr("action","principal.php?methodAdmin=select&type=visit");
    document.cookie = "search-log=" + encodeURIComponent(JSON.stringify([$("#searchUser").val(), $("#startDate").val(), $("#endDate").val()])) + "; path=/; max-age=" + (60);
    $("#log-form").submit();
})

$("#log-rent").on("click",function(){
    $("#log-form").attr("action","principal.php?methodAdmin=select&type=rent");
    document.cookie = "search-log=" + encodeURIComponent(JSON.stringify([$("#searchUser").val(), $("#startDate").val(), $("#endDate").val()])) + "; path=/; max-age=" + (60);
    $("#log-form").submit();
})
</script>