<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/principal.css">
    <title>Form Popup</title>
</head>
<body>

    <!-------------------------------LOGICA------------------------------->
    <?php
        $dirLocation=2;
        include("../_Indexes/Index_Interface.php");
        include("../_Indexes/Index_Rent.php");
        $rentData = $rentController -> listRentDataByProduct($_GET['id']);
        $rentStats = $rentController -> listRentStatsByProduct($_GET['id']);
    ?>
    <!-------------------------------LOGICA------------------------------->

<div id="formPopup" class="popup" style="top: -130;">
    <div class="popup-content" style="width: 80%;">
        <button class="close-btn" id="closeFormBtn" style="top: 140;">X</button>
        <?php if(is_array($rentData)){ ?>
            <h2>Mostrando Estadísticas del Producto <?php echo $rentStats['PNOM']; ?></h2>
            <p><strong>Ganancias Totales:</strong> <?php echo $rentStats['TOTAL_EARNINGS']; ?>€</p>
            <p><strong>Calificación Promedio:</strong> 
                <?php 
                    for($i=0;$i<(int)$rentStats['AVG_RATE'];$i++)
                        echo "<i class='fas fa-star icon-star-rev'></i>";
                    if($rentStats['AVG_RATE'] - (int)$rentStats['AVG_RATE'] >= 0.5){
                        echo "<i class='fas fa-star-half-alt icon-star-rev'></i>";
                        $rentStats['AVG_RATE']++;
                    }
                    for($i=(int)$rentStats['AVG_RATE'];$i<5;$i++)
                        echo "<i class='fa-regular fa-star icon-star-rev'></i>";
                ?></p>
            <p id='lastP'><a href="#" class='btn btn-shape btn-log element-green-bg' onclick="showRentDataTable()">Lista de Usuarios que han alquilado este producto</a></p>
        <?php }else echo "<h3>No hay estadísticas disponibles para este producto.</h3>"; ?>
    </div>
</div>
</body>

<!-------------------------------SCRIPT------------------------------->
<script> $("#closeFormBtn").click(function() { $("#formPopup").fadeOut(); }); </script>

<script>
    var rentData  = <?php echo json_encode($rentData); ?>;

    function showRentDataTable(){
        if($("#div-data-table").length==0){
            let table="<div id='div-data-table'><table id='data-table' class='table table-striped table-bordered mb-0'>";
            table+="<thead><tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Provincia</th></th><th>Avatar</th>"+
            "<th>Fecha Inicio</th><th>Fecha Fin</th><th>Ingresos</th><th>Estado Alquiler</th></thead>";
            table+="<tbody></tbody></table></div>";
            $("#lastP").after(table);

            new DataTable('#data-table', {
                data: rentData,
                columns: [
                    { data: 'Nombre' },
                    { data: 'Email' },
                    { data: 'Teléfono' },
                    { data: 'Provincia' },
                    { data: 'Avatar', render: function(data, type, row) { 
                        let path=(data!=null) ? data : "anon.png";
                        return "<img src='../assets/img/users/"+path+"' style='width:50px'></img>"; 
                    } },
                    { data: 'Fecha_Inicio', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                    { data: 'Fecha_Fin', render: function(data, type, row) { return new Date(data).toLocaleDateString(); } },
                    { data: 'Precio_Total', render: function(data, type, row) { return data+"€"; } },
                    { data: 'STATRENT', render: function(data, type, row) { 
                        let status = (data==1) ? "Activo" : "Finalizado";
                        return status; 
                    } },
                ],
                lengthMenu: [3, 5, 7],
                scrollY: 400
            });
        }else $("#div-data-table").toggle(500);
        event.preventDefault();
    }
</script>
<!-------------------------------SCRIPT------------------------------->
</html>