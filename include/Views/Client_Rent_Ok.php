<?php $file = ($rentControl['Imagen']!=null) ? $rentControl['Imagen'] : "anon.png"; ?>

<article class="container site-section catalog-bg rounded shadow-sm py-4">
    <div class="row gy-4 align-items-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Alquiler realizado correctamente</h2>
                <div class="d-flex gap-2">
                    <a href="principal.php?methodRent=select" class="btn btn-log element-green-bg btn-shape"><i class="fa-solid fa-arrow-left"></i> Mis alquileres</a>
                    <button id="pdf-create" onclick="pdfCreate()" class="btn btn-log element-green-bg btn-shape"><i class="fa-solid fa-file-pdf"></i> Generar Factura PDF</button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 text-center">
            <div class="card element-green-border h-100 d-flex align-items-center justify-content-center p-3">
                <img src="<?php echo "../assets/img/products/".$file; ?>" alt="<?php echo $rentControl['Nombre']; ?>" class="card-img-top card-image" />
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card element-green-border h-100">
                <div class="card-body">
                    <h3 class="card-header element-green-bg mb-3 lead"><?php echo $rentControl["Nombre"].' - '.$rentControl["Referencia"]; ?></h3>

                    <div class="row">
                        <div class="col-6 mb-2"><strong>Precio Total</strong></div>
                        <div class="col-6 mb-2 text-end" style="color:limegreen;"><strong><?php echo $rentControl["Precio_Total"]; ?> €</strong></div>

                        <div class="col-6 mb-2"><strong>Precio Mensual</strong></div>
                        <div class="col-6 mb-2 text-end"><?php echo $rentControl["Precio_Mensual"]; ?> €</div>

                        <div class="col-6 mb-2"><strong>Fecha de inicio</strong></div>
                        <div class="col-6 mb-2 text-end"><?php echo date("d-m-Y H:i:s", strtotime($rentControl["Fecha_Inicio"])); ?></div>

                        <div class="col-6 mb-2"><strong>Fecha de fin</strong></div>
                        <div class="col-6 mb-2 text-end"><?php echo date("d-m-Y H:i:s", strtotime($rentControl["Fecha_Fin"])); ?></div>
                    </div>

                    <hr>

                    <p class="mb-1"><strong>Proveedor:</strong> <?php echo $user['Nombre']; ?></p>
                    <p class="mb-0"><strong>Referencia interna:</strong> <?php echo $rentControl['Referencia']; ?></p>
                </div>
            </div>
        </div>
    </div>
</article>

<script src="<?php echo $basePath; ?>/assets/js/pdf24.js"></script>
<script src="<?php echo $basePath; ?>/assets/js/pdfCreate.js"></script>