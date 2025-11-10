<div id="modal"></div>

<article class="col-12 list-user form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////
if(isset($userControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if(isset($_GET["error"])) echo "<script>showFieldError('".$_GET["error"]."');</script>";
    
    if($userControl==0){
        echo "<h2>No hay usuarios registrados</h2><br>";
        echo "<a id='add-user' class='btn btn-log btn-shape element-green-bg'>Agregar Usuario</a>";
    }else if($userControl==-1){
        echo "<h2>Error al cargar los usuarios</h2>";
    }else{
        if(isset($_GET["action"]) && $_GET["action"]=="insert")
            echo "<div id='alert-success' class='col-10 alert alert-success'>Usuario agregado correctamente</div>";
        else if(isset($_GET["action"]) && $_GET["action"]=="update")
            echo "<div id='alert-success' class='col-10 alert alert-success'>Usuario actualizado correctamente</div>";
        else
            echo "<div id='alert-success' class='col-10 alert alert-success'>Usuarios cargados correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//

        //*-----------------------------USER LIST------------------------------*//
        echo "<a id='add-user' class='btn btn-log btn-shape element-green-bg'>Agregar Usuario</a>";
        echo "<table id='boxContent' style='font-size: 0.9em;' class='table table-striped'><thead><tr><th>ID</th><th>E-Mail</th><th>CIF</th><th>Nombre</th>
            <th>Teléfono</th><th>Provincia</th><th>Fecha_Registro</th><th>Tipo</th><th>Acciones</th></tr></thead>";
        echo "<tbody></tbody></table>";
        //*-----------------------------USER LIST------------------------------*//

    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<!-------------------------------SCRIPT------------------------------->
<script>
    var userControl = <?php echo json_encode($userControl); ?>;

    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#boxContent', {
            data: userControl,
            columns: [
                { data: 'Usuario_ID', render: function(data, type, row) {
                        var btnId = (row["Estado"]==1) ? "enabled-" : "disabled-";
                        return "<a href='#' id='"+btnId+data+"' onclick='activeUser("+data+")'>"+data+"</a>";
                    }
                },
                { data: 'Email' },
                { data: 'CIF' },
                { data: 'Nombre' },
                { data: 'Teléfono' },
                { data: 'Provincia' },
                { data: 'Fecha_Registro', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                { data: 'Tipo', render: function(data, type, row) {
                        if (data === "C") return "Cliente";
                        if (data === "P") return "Proveedor";
                        return "No Identificado";
                    }
                },
                { data: null, render: function(data, type, row) {
                        return "<a href='#' class='has-tooltip' data-tooltip='Actualizar Usuario' onclick='updateUser("+row["Usuario_ID"]+")'><i class='fa-solid fa-gear icon-gear border-5'></i></a>"+
                        "<a href='#' class='has-tooltip' data-tooltip='Eliminar Usuario' onclick='deleteUser("+row["Usuario_ID"]+")'><i class='fa-solid fa-trash icon-trash border-5'></i></a>";
                    }
                }
            ]
        });
    });
</script>

<script>
    /////////////////////////////AÑADIR USUARIO/////////////////////////////
    $("#add-user").on("click", function() {
        $("#modal").load("Views/Form_Add_User.php?methodUser=viewAdd", function() { $("#formPopup").fadeIn(1000); });
    });
    /////////////////////////////AÑADIR USUARIO/////////////////////////////

    ////////////////////////////ACTIVAR USUARIO////////////////////////////
    function activeUser(id){
        let isEnabled = $("#boxContent").find("#enabled-"+id).length > 0;
        let action = isEnabled ? "disabled" : "enabled";
        let status = isEnabled ? 0 : 1;

        if(confirm("¿Está seguro de que desea cambiar el estado del usuario con ID: "+id+"?")){
            $.ajax({
                url: "principal.php?methodUser=active",
                type: "POST",
                data: { userId: id, userBool: status },
                success: function(response) {
                    if(action=="disabled"){
                        $("#boxContent").find("#enabled-"+id).attr("id", "disabled-"+id);
                        showBoxActiveUser(0);
                    }else{
                        $("#boxContent").find("#disabled-"+id).attr("id", "enabled-"+id);
                        showBoxActiveUser(1);
                    }
                },
                error: function() { alert("Error inesperado."); }
            });
        }
    }
    ////////////////////////////ACTIVAR USUARIO////////////////////////////

    ////////////////////////////ACTUALIZAR USUARIO////////////////////////////
    function updateUser(id){
        $("#modal").load("Views/Form_Add_User.php?methodUser&id="+id, function() { $("#formPopup").fadeIn(1000); });
        event.preventDefault();
    }
    ////////////////////////////ACTUALIZAR USUARIO////////////////////////////

    ////////////////////////////BORRAR USUARIO////////////////////////////
    function deleteUser(id){
        let row = $("#row-"+id);

        if(confirm("¿Está seguro de que desea eliminar el usuario con ID: "+id+"?")){
            $.ajax({
                url: "principal.php?methodUser=delete",
                type: "POST",
                data: { deleteId: id },
                success: function(response) {
                        row.fadeOut(300);
                        window.location.reload();
                },
                error: function() { alert("Error inesperado."); }
            });
        }
        event.preventDefault();
    }
    ////////////////////////////BORRAR USUARIO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->
