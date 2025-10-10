<div id="modal"></div>

<article class="col-12 list-user form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////
if(isset($userControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
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
        echo "<table class='table table-striped'><thead><tr><th>ID</th><th>E-Mail</th><th>CIF</th><th>Nombre</th>
            <th>Teléfono</th><th>Fecha Registro</th><th>Avatar</th><th>Tipo</th><th>Acciones</th></tr></thead>";
        echo "<tbody id='boxContent'></tbody></table>";
        //*-----------------------------USER LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
            $class0=$class1=$class2="btn btn-log element-green-bg ";
            $class1=$class0."not-visible";
            if(count($userControl)<=10) $class2=$class0."not-visible";

            echo "<div class='nav-buttons site-article'>";
                echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
                echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
                echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
            echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<!-------------------------------SCRIPT------------------------------->
<script src="../assets/js/content_paginate.js"></script>

<script>
    var userControl = <?php echo json_encode($userControl); ?>;
    content_paginate(userControl);
    
    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(user){
        let file = (user["Avatar"]!=null) ? user["Avatar"] : "anon.png";
        let btnId= (user["Estado"]==1) ? "enabled-" : "disabled-";
        let type = (user["Tipo"]=="C") ? "Cliente" : (user["Tipo"]=="P") ? "Proveedor" : "No Identificado";

        $("#boxContent").append(
            "<tr id='row-"+user["Usuario_ID"]+"'><td><a href='#' id='"+btnId+user["Usuario_ID"]+"' onclick='activeUser("+user["Usuario_ID"]+")'>"+user["Usuario_ID"]+"</a></td>"+
            "<td>"+user["Email"]+"</td><td>"+user["CIF"]+"</td><td>"+user["Nombre"]+"</td><td>"+user["Teléfono"]+"</td>"+
            "<td>"+user["Fecha_Registro"].split(" ")[0]+"</td><td><img style='width:50px' src='../assets/img/users/"+file+"' /></td>"+
            "<td>"+type+"</td><td> <a href='#' onclick='updateUser("+user["Usuario_ID"]+")'><i class='fa-solid fa-gear icon-gear border-5'></i></a>"+
            "<a href='#' onclick='deleteUser("+user["Usuario_ID"]+")'><i class='fa-solid fa-trash icon-trash border-5'></i></a></tr>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
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
    }
    ////////////////////////////BORRAR USUARIO////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->
