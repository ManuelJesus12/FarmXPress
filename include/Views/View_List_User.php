<div id="modal"></div>

<article class="col-12 list-user form-log site-section rounded">
<?php $userCount=0;
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
        echo "<table class='table table-striped'><thead><tr><th>ID</th><th>E-Mail</th><th>CIF</th><th>Nombre</th><th>Teléfono</th><th>Fecha Registro</th><th>Avatar</th><th>Tipo</th><th>Acciones</th></tr></thead><tbody>";
        foreach($userControl as $user){
            if($user['Avatar']!=null) $file=$user['Avatar']; else $file="anon.png";

            if($user['Estado']==1)
                echo "<td><a href='#' id='enabled-".$user['Usuario_ID']."'>".$user["Usuario_ID"]."</a></td>";
            else
                echo "<td><a href='#' id='disabled-".$user['Usuario_ID']."'>".$user["Usuario_ID"]."</a></td>";

            echo "<td>".$user['Email']."</td><td>".$user['CIF']."</td><td>".$user['Nombre']."</td><td>".$user['Teléfono']."</td><td>".explode(" ",$user['Fecha_Registro'])[0]."</td><td><img style='width:50px' src='../assets/img/users/$file' /></td>";
            if($user['Tipo']=="C")
                echo "<td>Cliente</td>";
            else if($user['Tipo']=="P")
                echo "<td>Proveedor</td>";
            else
                echo "<td>-</td>";

            echo "<td> <a href='#' id='update-".$user['Usuario_ID']."'><i class='fa-solid fa-gear icon-gear border-5'></i></a>   ";
            echo "<a href='#' id='delete-".$user['Usuario_ID']."'><i class='fa-solid fa-trash icon-trash border-5'></i></a></tr>";
            $userCount++; if($userCount==10) break;
        }
        echo "</tbody></table>";
        //*-----------------------------USER LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
            $class0=$class1=$class2="btn btn-log element-green-bg ";
            if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
            if(count($userControl)<=10) $class2=$class0."not-visible";

            echo "<div class='nav-buttons'>";
                echo "<div class='btn-group'>";
                    echo "<a class='$class1' href='principal.php?methodUser=select&page=".($_GET['page']-1)."'>Anterior</a>";
                echo "</div>";
                echo "<div class='btn-group'>";
                    echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
                echo "</div><div class='btn-group'>";
                    echo "<a class='$class2' href='principal.php?methodUser=select&page=".($_GET['page']+1)."'>Siguiente</a>";
                echo "</div>";
            echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<script>
///////////////////////////////////////////////////////////////////////
$(document).ready(function(){ 
    //*-----------------------------INSERT------------------------------*//
    $("#add-user").on("click", function() {
        $("#modal").load("Views/Form_Add_User.php?methodUser=viewAdd", function() { $("#formPopup").fadeIn(1000); });
    });
    //*-----------------------------INSERT------------------------------*//

    for(let $i=1;$i<$("tr").length;$i++){
        //*-----------------------------ENABLE/DISABLE------------------------------*//
        $("tr").eq($i).find("a").eq(0).on("click", function(){
            let action=($(this).attr("id")).split("-")[0];
            let id=($(this).attr("id")).split("-")[1];
            
            let active=0;
            if(action=="disabled") active=1;

            if(confirm("¿Está seguro de que desea cambiar el estado del usuario con ID: "+id+"?")){
                $.ajax({
                    url: "principal.php?methodUser=active",
                    type: "POST",
                    data: { userId: id, userBool: active },
                    success: function(response) {
                        let element="Usuario";
                        if(action=="disabled"){
                            $("body").find("#disabled-"+id).attr("id", "enabled-"+id);
                            showBoxActiveUser(1);
                        }else{
                            $("body").find("#enabled-"+id).attr("id", "disabled-"+id);
                            showBoxActiveUser(0);
                        }
                    },
                    error: function() { alert("Error inesperado."); }
                });
            }
        });
        //*-----------------------------ENABLE/DISABLE------------------------------*//

        //*-----------------------------UPDATE------------------------------*//
        $("tr").eq($i).find("a").eq(1).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            $("#modal").load("Views/Form_Add_User.php?methodUser&id="+id, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------UPDATE------------------------------*//

        //*-----------------------------DELETE------------------------------*//
        $("tr").eq($i).find("a").eq(2).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            let $row = $(this).closest("tr"); 

            if(confirm("¿Está seguro de que desea eliminar el usuario con ID: "+id+"?")){
                $.ajax({
                    url: "principal.php?methodUser=delete",
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
        //*-----------------------------DELETE------------------------------*//
    }
});
///////////////////////////////////////////////////////////////////////
</script>