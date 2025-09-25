<?php if($rentControl[0]['Imagen']!=null) $file=$rentControl[0]['Imagen']; else $file="anon.png"; ?>
<article class="col-12 list-cat form-log site-section rounded elemeng-green-bg">
    <h2>Alquiler realizado correctamente</h2>
    <div class='row d-flex justify-content-evenly align-items-center'>
        <div class="col-lg-2"></div>
        <div class="col-lg-3 col-md-12 col-sm-12 mb-3">
            <img class='img-fluid rounded shadow card-image element-green-border' src="<?php echo "../assets/img/products/".$file; ?>" alt='Imagen del producto'>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 card card-prod card-body element-green-border rounded" style='height:auto;' id="rent-details" >
            <h3 class='card-header element-green-bg lead' style='margin-bottom:30px'>Detalles del alquiler: <?php echo $rentControl[0]["Nombre"]. " - ".$rentControl[0]["Referencia"]; ?> </h3>
            <p><strong>Precio Total: </strong><span style="color:limegreen"><?php echo $rentControl[0]["Precio_Total"]; ?> €</span></p>
            <p><strong>Precio Mensual: </strong><?php echo $rentControl[0]["Precio_Mensual"]; ?> €</p>
            <p><strong>Fecha de inicio: </strong><?php echo date("d-m-Y H:i:s", strtotime($rentControl[0]["Fecha_Inicio"])); ?> </p>
            <p><strong>Fecha de fin: </strong><?php echo date("d-m-Y H:i:s", strtotime($rentControl[0]["Fecha_Fin"])); ?> </p>
        </div>
        <div class="col-lg-2"></div>
    </div>
<br>
<a href="#" class="btn btn-shape btn-log element-green-bg" id="pdf-create" onclick="pdfCreate()" style="width:80%" >Generar Factura PDF</a>
</article>

<script src="../assets/js/pdf24.js"></script>
<script src="../assets/js/pdfCreate.js"></script>