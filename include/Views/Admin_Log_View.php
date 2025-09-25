<article class="col-12 list-log form-log site-section rounded">
<?php
///////////////////////////////////////////////////////////////////////
if(isset($logControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($logControl==0){
        echo "<h2>No hay datos que mostrar</h2><br>";
    }else if($logControl==-1){
        echo "<h2>Error al cargar las categorias</h2>";
    //*-----------------------------NOTIFICATIONS------------------------------*//
    }else{
        if($_GET["type"]=="visit"){
            echo "<div id='alert-success' class='col-10 alert alert-success'>Información sobre Visitas cargada correctamente</div>";
            echo "<a class='btn btn-log btn-shape element-green-bg' id='store'>Imprimir Informe</a>";

            echo "<table class='table table-striped'><thead><tr><th>Usuario ID</th><th>Nombre</th><th>CIF</th><th>Fecha y Hora</th><th>Ruta</th></tr></thead><tbody>";
            foreach($logControl as $log)
                echo "<tr><td>".$log['UID']."</td><td>".$log['Nombre']."</td><td>".$log['CIF']."</td><td>".$log['Fecha_Hora']."</td><td>".$log['Ruta']."</td></tr>";
            echo "</tbody></table><br>";

        }else if($_GET["type"]=="rent"){
            echo "<div id='alert-success' class='alert alert-success'>Información sobre el tráfico cargada correctamente</div>";
            echo "<a class='btn btn-log btn-shape element-green-bg' id='store'>Imprimir Informe</a>";
            
            echo "<table class='table table-striped'><thead><tr><th>Usuario ID</th><th>Nombre Usuario</th><th>CIF</th><th>Alquiler ID</th><th>Nombre Producto</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Precio Total</th><th>Estado</th></tr></thead><tbody>";
            foreach($logControl as $log){
                echo "<tr><td>".$log['UID']."</td><td>".$log['UNOM']."</td><td>".$log['CIF']."</td><td>".$log['Alquiler_ID']."</td><td>".$log['PID']."</td>";
                echo "<td>".$log['Fecha_Inicio']."</td><td>".$log['Fecha_Fin']."</td><td>".$log['Precio_Total']."</td>";
                if($log['Estado']==1) echo "<td>Activo</td>"; else if($log['Estado']==0) echo "<td>Finalizado</td>";
                echo "</tr>";
            }
            echo "</tbody></table><br>";
        }
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<script>
///////////////////////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////////////////////
</script>