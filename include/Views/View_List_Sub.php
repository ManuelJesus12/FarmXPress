<div id="modal"></div>

<article class="col-12 list-sub form-log site-section rounded">
<?php include("_Indexes/Index_Perk.php"); $subCount=0;
///////////////////////////////////////////////////////////////////////
if(isset($subControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($subControl==0){
        echo "<h2>No hay suscripciones registradas</h2><br>";
        echo "<a id='add-sub' class='btn btn-log btn-shape element-green-bg'>Agregar Suscripción</a>";
    }else if($subControl==-1){
        echo "<h2>Error al cargar las suscripciones</h2>";
    }else{
        if(isset($_GET["action"]) && $_GET["action"]=="insert")
            echo "<div id='alert-success' class='col-10 alert alert-success'>Suscripción agregada correctamente</div>";
        else if(isset($_GET["action"]) && $_GET["action"]=="update")
            echo "<div id='alert-success' class='col-10 alert alert-success'>Suscripción actualizada correctamente</div>";
        else
            echo "<div id='alert-success' class='col-10 alert alert-success'>Suscripciones cargadas correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//

        //*-----------------------------SUB LIST------------------------------*//
        echo "<a id='add-sub' class='btn btn-log btn-shape element-green-bg'>Agregar Suscripción</a>";
        echo "<table class='table table-striped'><thead><tr><th>Suscripción ID</th><th>Nombre</th><th>Precio Mensual</th><th>Duración Base</th><th>Acciones</th></tr></thead><tbody>";
        foreach($subControl as $sub) {
            echo "<tr class='sub' id='".$sub['Suscripción_ID']."'><td>".$sub['Suscripción_ID']."</td>";
            echo "<td>".$sub['Nombre']."</td><td>".$sub['Precio_Mensual']." €</td><td>".$sub['Duración_Base']." meses</td>";
            echo "<td><a href='#' id='add-perk-".$sub['Suscripción_ID']."'><i class='fa-solid fa-plus icon-plus border-5'></i></a>
                    <a href='#' class='toggle-perks' id='show-".$sub['Suscripción_ID']."'><i class='fa-solid fa-eye icon-eye border-5'></i></a>
                    <a href='#' id='update-".$sub['Suscripción_ID']."'><i class='fa-solid fa-gear icon-gear border-5'></i></a>
                    <a href='#' id='delete-".$sub['Suscripción_ID']."'><i class='fa-solid fa-trash icon-trash border-5'></i></a></td></tr>";

            echo "<tr class='perk-row' id='perk-row-".$sub['Suscripción_ID']."' style='display: none;'><td colspan='5'>";
            $perkControl = $perkController->viewListPerk($sub['Suscripción_ID']);
            if($perkControl != 0 && $perkControl != -1) {
                echo "<table class='table table-bordered mb-0'><thead><tr><th>Ventaja ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr></thead><tbody>";
                foreach ($perkControl as $perk) {
                    echo "<tr class='perk' id='perk-".$perk['Ventaja_ID']."'><td>".$perk['Ventaja_ID']."</td><td>".$perk['Nombre']."</td><td>".$perk['Descripción']."</td>";
                    echo "<td><a href='#' id='update-".$perk['Ventaja_ID']."'><i class='fa-solid fa-gear icon-gear border-5'></i></a>
                        <a href='#' id='delete-".$perk['Ventaja_ID']."'><i class='fa-solid fa-trash icon-trash border-5'></i></a></td></tr>";
                }
                echo "</tbody></table>";
            }else
                echo "<div class='text-muted'>No hay ventajas registradas.</div>";

            echo "</td></tr>";

            $subCount++; if($subCount==10) break;
        }
        echo "</tbody></table>";
        //*-----------------------------SUB LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
        if(count($subControl)<=10) $class2=$class0."not-visible";

        echo "<div class='nav-buttons'>";
            echo "<div class='btn-group'>";
                echo "<a class='$class1' href='principal.php?methodSub=select&page=".($_GET['page']-1)."'>Anterior</a>";
            echo "</div>";
            echo "<div class='btn-group'>";
                echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
            echo "</div><div class='btn-group'>";
                echo "<a class='$class2' href='principal.php?methodSub=select&page=".($_GET['page']+1)."'>Siguiente</a>";
            echo "</div>";
        echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<script>
///////////////////////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-perks').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const subId = this.getAttribute('data-sub-id');
            const row = document.getElementById('perk-row-' + subId);
            if (row) row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        });
    });
});
///////////////////////////////////////////////////////////////////////
</script>

<script>
///////////////////////////////////////////////////////////////////////
$(document).ready(function(){ 
    //*-----------------------------INSERT SUB------------------------------*//
    $("#add-sub").on("click", function() {
        $("#modal").load("Views/Form_Add_Sub.php?methodSub", function() { $("#formPopup").fadeIn(1000); });
    });
    //*-----------------------------INSERT SUB------------------------------*//

    for(let $i=0;$i<$(".sub").length;$i++){
        //*-----------------------------SHOW PERKS------------------------------*//
        $(".sub").eq($i).find("a").eq(1).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            $("#perk-row-"+id).toggle(1000);
        });
        //*-----------------------------SHOW PERKS------------------------------*//

        //*-----------------------------INSERT PERK------------------------------*//
        $(".sub").eq($i).find("a").eq(0).on("click", function(){
            let id=($(this).attr("id")).split("-")[2];
            $("#modal").load("Views/Form_Add_Perk.php?methodPerk&subId="+id, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------INSERT PERK------------------------------*//

        //*-----------------------------UPDATE SUB------------------------------*//
        $(".sub").eq($i).find("a").eq(2).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            $("#modal").load("Views/Form_Add_Sub.php?methodSub&id="+id, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------UPDATE SUB------------------------------*//

        //*-----------------------------DELETE SUB------------------------------*//
        $(".sub").eq($i).find("a").eq(3).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            let $row = $(this).closest("tr"); 

            if(confirm("¿Está seguro de que desea eliminar la suscripción con ID: "+id+"?")){
                $.ajax({
                    url: "principal.php?methodSub=delete",
                    type: "POST",
                    data: { deleteId: id },
                    success: function(response) {
                        $row.fadeOut(300);
                        $("#sub-perk-"+id).fadeOut(300);
                        window.location.reload();
                    },
                    error: function() { alert("Error inesperado."); }
                });
            }
        });
        //*-----------------------------DELETE SUB------------------------------*//
    }

    for(let $i=0;$i<$(".perk").length;$i++){
        //*-----------------------------UPDATE PERK------------------------------*//
        $(".perk").eq($i).find("a").eq(0).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            $("#modal").load("Views/Form_Add_Perk.php?methodPerk&id="+id, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------UPDATE PERK------------------------------*//

        //*-----------------------------DELETE PERK------------------------------*//
        $(".perk").eq($i).find("a").eq(1).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            let $row = $(this).closest("tr"); 

            if(confirm("¿Está seguro de que desea eliminar la ventaja con ID: "+id+"?")){
                $.ajax({
                    url: "principal.php?methodPerk=delete",
                    type: "POST",
                    data: { deleteId: id },
                    success: function(response) {
                        $row.fadeOut(300);
                        window.location.reload();
                    },
                    error: function() { alert("Error inesperado."); }
                });
            }
        });
        //*-----------------------------DELETE PERK------------------------------*//
    }
});
///////////////////////////////////////////////////////////////////////
</script>