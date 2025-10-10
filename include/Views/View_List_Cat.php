<div id="modal"></div>

<article class="col-12 list-cat form-log site-section rounded">
<?php 
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
        echo "<table class='table table-striped'><thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Categoría Padre</th><th>Acciones</th></tr></thead>";
        echo "<tbody id='boxContent'></tbody></table>";
        //*-----------------------------CATEGORY LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        $class1=$class0."not-visible";
        if(count($categoryControl)<=10) $class2=$class0."not-visible";

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
    var categoryControl = <?php echo json_encode($categoryControl); ?>;
    content_paginate(categoryControl);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(user){
        let catPadre = (user['Cat_Padre'] != null) ? user['Cat_Padre'] : "Ninguna";
        
        $("#boxContent").append(
            "<tr id='row-"+user["Categoría_ID"]+"'><td>"+user['Categoría_ID']+"</td><td>"+user['Nombre']+"</td><td>"+user['Descripción']+"</td><td>"+catPadre+"</td>"+
            "<td> <a href='#' onclick='updateCategory("+user['Categoría_ID']+")'><i class='fa-solid fa-gear icon-gear border-5'></i></a>   "+
            "<a href='#' onclick='deleteCategory("+user['Categoría_ID']+")'><i class='fa-solid fa-trash icon-trash border-5'></i></a></td></tr>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>

<script>
    /////////////////////////////AÑADIR CATEGORIA/////////////////////////////
    $("#add-category").on("click", function() {
        $("#modal").load("Views/Form_Add_Cat.php?methodCat=viewAdd", function() { $("#formPopup").fadeIn(1000); });
    });
    /////////////////////////////AÑADIR CATEGORIA/////////////////////////////

    ////////////////////////////ACTUALIZAR CATEGORIA////////////////////////////
    function updateCategory(id){
        $("#modal").load("Views/Form_Add_Cat.php?methodCat=viewUpdate&id="+id, function() { $("#formPopup").fadeIn(1000); });
    }
    ////////////////////////////ACTUALIZAR CATEGORIA////////////////////////////

    ////////////////////////////ELIMINAR CATEGORIA////////////////////////////
    function deleteCategory(id){
        let row = $("#row-"+id);

        if(confirm("¿Está seguro de que desea eliminar la categoría con ID: "+id+"?")){
            $.ajax({
                url: "principal.php?methodCat=delete",
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
    ////////////////////////////ELIMINAR CATEGORIA////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->