<div id="modal"></div>

<article class="col-12 list-sub form-log site-section rounded">
<?php include("_Indexes/Index_Perk.php");
///////////////////////////////////////////////////////////////////////
if(is_array($subControl)){
    foreach($subControl as &$sub){ $sub["PerkList"]=$perkController->viewListPerk($sub['Suscripción_ID']); }
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if(isset($_GET["action"]) && $_GET["action"]=="insert")
        echo "<div id='alert-success' class='col-10 alert alert-success'>Suscripción agregada correctamente</div>";
    else if(isset($_GET["action"]) && $_GET["action"]=="update")
        echo "<div id='alert-success' class='col-10 alert alert-success'>Suscripción actualizada correctamente</div>";
    else
        echo "<div id='alert-success' class='col-10 alert alert-success'>Suscripciones cargadas correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//

    //*-----------------------------SUB LIST------------------------------*//
    echo "<a id='add-sub' class='btn btn-log btn-shape element-green-bg'>Agregar Suscripción</a>";
    echo "<table id='boxContent' class='table table-striped'><thead><tr><th>Suscripción ID</th><th>Nombre</th><th>Precio Mensual</th><th>Duración Base</th><th>Acciones</th></tr></thead>";
    echo "<tbody></tbody></table>";
    //*-----------------------------SUB LIST------------------------------*//

}else if($subControl==0){
    echo "<h2>No hay suscripciones registradas</h2><br>";
    echo "<a id='add-sub' class='btn btn-log btn-shape element-green-bg'>Agregar Suscripción</a>";
}else if($subControl==-1)
    echo "<h2>Error al cargar las suscripciones</h2>";
///////////////////////////////////////////////////////////////////////
?></article>

<script>
///////////////////////////////////////////////////////////////////////
    var subControl = <?php echo json_encode($subControl); ?>;

    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#boxContent', {
            data: subControl,
            columns: [
                { data: 'Suscripción_ID' },
                { data: 'Nombre' },
                { data: 'Precio_Mensual', render: function(data, type, row) { return data+"€"; } },
                { data: 'Duración_Base', render: function(data, type, row) { return data+" meses"; } },
                { data: null, render: function(data, type, row) {
                    return "<a href='#' onclick='addPerk("+row['Suscripción_ID']+")'><i class='fa-solid fa-plus icon-plus border-5'></i></a>"+
                    "<a href='#' onclick='showPerk("+row['Suscripción_ID']+")' class='toggle-perks'><i class='fa-solid fa-eye icon-eye border-5'></i></a>"+
                    "<a href='#' onclick='updateSub("+row['Suscripción_ID']+")'><i class='fa-solid fa-gear icon-gear border-5'></i></a>"+
                    "<a href='#' onclick='deleteSub("+row['Suscripción_ID']+")'><i class='fa-solid fa-trash icon-trash border-5'></i></a>";
                    }
                }
            ], createdRow: function(row, data, dataIndex){ row.id = "sub-"+data['Suscripción_ID']; }
        });
    });
///////////////////////////////////////////////////////////////////////
</script>

<script>
    /////////////////////////////AÑADIR SUSCRIPCIÓN/////////////////////////////
    $("#add-sub").on("click", function() {
        $("#modal").load("Views/Form_Add_Sub.php?methodSub", function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    });
    /////////////////////////////AÑADIR SUSCRIPCIÓN/////////////////////////////

    /////////////////////////////ACTUALIZAR SUSCRIPCIÓN/////////////////////////////
    function updateSub(id){
        $("#modal").load("Views/Form_Add_Sub.php?methodSub&id="+id, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    /////////////////////////////ACTUALIZAR SUSCRIPCIÓN/////////////////////////////

    /////////////////////////////ELIMINAR SUSCRIPCIÓN/////////////////////////////
    function deleteSub(id){
        if(confirm("¿Está seguro de que desea eliminar la suscripción con ID: "+id+"?")){
            $.ajax({
                url: "principal.php?methodSub=delete",
                type: "POST",
                data: { deleteId: id },
                success: function(response) {
                    $("#sub-"+id).fadeOut(300);
                    window.location.reload();
                },
                error: function() { alert("Error inesperado."); }
            });
        }
        event.preventDefault();
    }
    /////////////////////////////ELIMINAR SUSCRIPCIÓN/////////////////////////////

    /////////////////////////////MOSTRAR VENTAJAS/////////////////////////////
    function showPerk(id){
        if($("#perkContent-"+id).length==0){
            let table="<div id='div-"+id+"'><table id='perkContent-"+id+"' class='table table-striped table-bordered mb-0'>";
            table+="<thead><tr><th>Ventaja ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr></thead>";
            table+="<tbody></tbody></table></div>";
            $("#sub-"+id).after(table);

            let perkControl = subControl.find(sub => sub.Suscripción_ID === id).PerkList;
            new DataTable('#perkContent-'+id, {
                data: perkControl,
                columns: [
                    { data: 'Ventaja_ID' },
                    { data: 'Nombre' },
                    { data: 'Descripción' },
                    { data: null, render: function(data, type, row) {
                        return "<a href='#' onclick='updatePerk("+row['Ventaja_ID']+")'><i class='fa-solid fa-gear icon-gear border-5'></i></a>"+
                        "<a href='#' onclick='deletePerk("+row['Ventaja_ID']+")'><i class='fa-solid fa-trash icon-trash border-5'></i></a>";
                        }
                    }
                ], createdRow: function(row, data, dataIndex){ row.id = "perk-"+data['Ventaja_ID']; }
            });
        }else $("#div-"+id).toggle(500);
        event.preventDefault();
    }
    /////////////////////////////MOSTRAR VENTAJAS/////////////////////////////

    /////////////////////////////AÑADIR VENTAJA/////////////////////////////
    function addPerk(id){
        $("#modal").load("Views/Form_Add_Perk.php?methodPerk&subId="+id, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    /////////////////////////////AÑADIR VENTAJA/////////////////////////////

    /////////////////////////////ACTUALIZAR VENTAJA/////////////////////////////
    function updatePerk(id){
        $("#modal").load("Views/Form_Add_Perk.php?methodPerk&id="+id, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    /////////////////////////////ACTUALIZAR VENTAJA/////////////////////////////

    /////////////////////////////ELIMINAR VENTAJA/////////////////////////////
    function deletePerk(id){
        if(confirm("¿Está seguro de que desea eliminar la ventaja con ID: "+id+"?")){
            $.ajax({
                url: "principal.php?methodPerk=delete",
                type: "POST",
                data: { deleteId: id },
                success: function(response) {
                    $("#perk"+id).fadeOut(300);
                    window.location.reload();
                },
                error: function() { alert("Error inesperado."); }
            });
        }
        event.preventDefault();
    }
    /////////////////////////////ELIMINAR VENTAJA/////////////////////////////
</script>