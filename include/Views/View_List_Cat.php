<div id="modal"></div>

<article class="col-12 list-cat form-log site-section rounded">
<?php $catCount=0;
///////////////////////////////////////////////////////////////////////
if(isset($categoryControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($categoryControl==0){
        echo "<h2>No hay categorías registradas</h2><br>";
        echo "<a id='add-category' class='btn btn-log btn-shape element-green-bg'>Agregar Categoría</a>";
    }else if($categoryControl==-1){
        echo "<h2>Error al cargar las categorías</h2>";
    }else{
        if(isset($_GET["action"]) && $_GET["action"]=="insert")
            echo "<div id='alert-success' class='col-10 alert alert-success'>Categoría agregada correctamente</div>";
        else if(isset($_GET["action"]) && $_GET["action"]=="update")
            echo "<div id='alert-success' class='col-10 alert alert-success'>Categoría actualizada correctamente</div>";
        else
            echo "<div id='alert-success' class='col-10 alert alert-success'>Categorías cargadas correctamente</div>";
    //*-----------------------------NOTIFICATIONS------------------------------*//

        //*-----------------------------CATEGORY LIST------------------------------*//
        echo "<a id='add-category' class='btn btn-log btn-shape element-green-bg'>Agregar Categoría</a>";
        echo "<table class='table table-striped'><thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Categoría Padre</th><th>Acciones</th></tr></thead><tbody>";
        foreach($categoryControl as $category){
            echo "<tr><td>".$category['Categoría_ID']."</td><td>".$category['Nombre']."</td><td>".$category['Descripción']."</td>";
            echo "<td id='cat-padre-".$category['Cat_Padre_ID']."'>".$category['Cat_Padre']."</td>";
            echo "<td> <a href='#' id='update-".$category['Categoría_ID']."'><i class='fa-solid fa-gear icon-gear border-5'></i></a>   ";
            echo "<a href='#' id='delete-".$category['Categoría_ID']."'><i class='fa-solid fa-trash icon-trash border-5'></i></a></tr>";
            $catCount++; if($catCount==10) break;
        }
        echo "</tbody></table>";
        //*-----------------------------CATEGORY LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
            $class0=$class1=$class2="btn btn-log element-green-bg ";
            if(!(isset($_GET['page']) && $_GET['page']>1)) $class1=$class0."not-visible";
            if(count($categoryControl)<=10) $class2=$class0."not-visible";

            echo "<div class='nav-buttons col-12'>";
                echo "<div class='btn-group'>";
                    echo "<a class='$class1' href='principal.php?methodCat=select&page=".($_GET['page']-1)."'>Anterior</a>";
                echo "</div>";
                echo "<div class='btn-group'>";
                    echo "<a class='$class0' href='#'>".$_GET["page"]."</a>";
                echo "</div><div class='btn-group'>";
                    echo "<a class='$class2' href='principal.php?methodCat=select&page=".($_GET['page']+1)."'>Siguiente</a>";
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
    $("#add-category").on("click", function() {
        $("#modal").load("Views/Form_Add_Cat.php?methodCat=viewAdd", function() { $("#formPopup").fadeIn(1000); });
    });
    //*-----------------------------INSERT------------------------------*//

    for(let $i=1;$i<$("tr").length;$i++){
        //*-----------------------------UPDATE------------------------------*//
        $("tr").eq($i).find("a").eq(0).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            $("#modal").load("Views/Form_Add_Cat.php?methodCat=viewUpdate&id="+id, function() { $("#formPopup").fadeIn(1000); });
        });
        //*-----------------------------UPDATE------------------------------*//

        //*-----------------------------DELETE------------------------------*//
        $("tr").eq($i).find("a").eq(1).on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            let $row = $(this).closest("tr"); 

            if(confirm("¿Está seguro de que desea eliminar la categoría con ID: "+id+"?")){
                $.ajax({
                    url: "principal.php?methodCat=delete",
                    type: "POST",
                    data: { deleteId: id },
                    success: function(response) {
                            $row.fadeOut(300);
                            $("body").find("#cat-padre-"+id).text("");
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