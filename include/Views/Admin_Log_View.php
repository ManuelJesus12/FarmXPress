<article class="col-12 list-log form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////
if(is_array($logControl)){
    if($_GET["type"]=="visit"){
        echo "<div id='alert-success' class='col-10 alert alert-success'>Información sobre Visitas cargada correctamente</div>";
        echo "<a class='btn btn-log btn-shape element-green-bg' id='store'>Imprimir Informe</a>";
        echo "<table id='boxContent' class='table table-striped'><thead><tr><th>Usuario ID</th><th>Nombre</th><th>CIF</th><th>Fecha</th><th>Ruta</th></tr></thead>";
        echo "<tbody></tbody></table><br>";

    }else if($_GET["type"]=="rent"){
        echo "<div id='alert-success' class='alert alert-success'>Información sobre el tráfico cargada correctamente</div>";
        echo "<a class='btn btn-log btn-shape element-green-bg' id='store'>Imprimir Informe</a>";
        echo "<table id='boxContent' class='table table-striped'><thead><tr><th>Usuario ID</th><th>Nombre Usuario</th><th>CIF</th><th>Nombre Producto</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Precio Total</th><th>Estado</th></tr></thead><tbody>";
        echo "<tbody></tbody></table><br>";
    }
}else if($logControl==0){
    echo "<h2>No hay datos que mostrar</h2><br>";
}else if($logControl==-1)
    echo "<h2>Error al cargar las categorias</h2>";
///////////////////////////////////////////////////////////////////////
?></article>

<script>
    ////////////////////////////PAGINACIÓN////////////////////////////
    var logControl = <?php echo json_encode($logControl); ?>;
    var tipo = "<?php echo $_GET['type']; ?>";

    if(tipo=="visit"){
        new DataTable('#boxContent', {
            data: logControl,
            columns: [
                { data: 'UID' },
                { data: 'Nombre' },
                { data: 'CIF' },
                { data: 'Fecha_Hora', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                { data: 'Ruta' }
            ],
            scrollX: true
        });
    }else{
        new DataTable('#boxContent', {
            data: logControl,
            columns: [
                { data: 'UID' },
                { data: 'UNOM' },
                { data: 'CIF' },
                { data: 'PID' },
                { data: 'Fecha_Inicio', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                { data: 'Fecha_Fin', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                { data: 'Precio_Total' },
                { data: 'Estado', render: function(data, type, row) { 
                    var estado = (data==1) ? "Activo" : "Finalizado"; 
                    return estado; 
                } }
            ],
            scrollX: true
        });
    }
    ////////////////////////////PAGINACIÓN////////////////////////////

    ////////////////////////////GUARDAR LOG////////////////////////////
    $("#store").on("click", function(){
        $.ajax({
            type: "POST",
            url: "principal.php?methodAdmin=store",
            data: {
                type: "<?php echo $_GET['type']; ?>",
                sql: <?php echo json_encode($logControl); ?>,
            },
            success: function(data) {
                alert("Fichero creado con éxito.");
            },
            error: function(xhr, status, error) {
                console.error("Error sending print request:", error);
            }
        });
    });
    ////////////////////////////GUARDAR LOG////////////////////////////

</script>