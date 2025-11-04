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
        echo "<table id='boxContent' class='table table-striped'><thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Categoría Padre</th><th>Acciones</th></tr></thead>";
        echo "<tbody ></tbody></table>";
        //*-----------------------------CATEGORY LIST------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<!-------------------------------SCRIPT------------------------------->
<script>
    var categoryControl = <?php echo json_encode($categoryControl); ?>;
    
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#boxContent', {
            data: categoryControl,
            columns: [
                { data: 'Categoría_ID' },
                { data: 'Nombre' },
                { data: 'Descripción' },
                { data: 'Cat_Padre', render: function(data, type, row){ return data ? data : 'Ninguna'; }},
                { data: null, render: function(data, type, row) {
                        return "<a href='#' class='has-tooltip' data-tooltip='Actualizar Categoría' onclick='updateCategory("+row["Categoría_ID"]+")'><i class='fa-solid fa-gear icon-gear border-5'></i></a>" +
                        "<a href='#' class='has-tooltip' data-tooltip='Eliminar Categoría' onclick='deleteCategory("+row["Categoría_ID"]+")'><i class='fa-solid fa-trash icon-trash border-5'></i></a>";
                    }
                }
            ]
        });
    });
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
        if(confirm("¿Está seguro de que desea eliminar la categoría con ID: "+id+"?")){
            $.ajax({
                url: "principal.php?methodCat=delete",
                type: "POST",
                data: { deleteId: id },
                success: function(response) {
                        $("#row-"+id).fadeOut(300);
                        window.location.reload();
                },
                error: function() { alert("Error inesperado."); }
            });
        }
    }
    ////////////////////////////ELIMINAR CATEGORIA////////////////////////////
</script>
<!-------------------------------SCRIPT------------------------------->