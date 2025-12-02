<div id="modal"></div>

<?php
include("_Indexes/Index_Perk.php");
include("_Indexes/Index_Member.php");
$member = $memberController->selectMember();

if(isset($_GET['action']) && $_GET['action']!=null)
    echo "<script>showBoxSuccessMember(".$_GET['action'].");</script>";
?>

<section class="container site-section">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="section-title">Suscripciones disponibles</h2>
        </div>

        <?php if(is_array($subControl)){
            foreach($subControl as &$sub){ $sub["PerkList"] = $perkController->viewListPerk($sub['Suscripcion_ID']); }

            if(is_array($member)){
                echo "<div id='alert-success' class='col-12 col-lg-6 alert alert-success d-flex align-items-center justify-content-between'>";
                echo "<div>Tu suscripción termina el <b>".date("d-m-Y", strtotime($member["Fecha_Fin"]))."</b></div>";
                echo "<div><a id='update-member' class='btn btn-log element-green-bg'>Extender Suscripción</a></div>";
                echo "</div>";
            }

            // Card container for subscriptions
            echo "<div id='boxContent' class='row g-3 mt-3 d-flex justify-content-evenly'></div>";

            // Navigation buttons
            $baseBtn = 'btn btn-log element-green-bg';
            $prevClass = $baseBtn; $nextClass = $baseBtn; $pageClass = $baseBtn;
            $prevHide = (count($subControl) <= 8) ? 'not-visible' : '';
            $nextHide = (count($subControl) <= 8) ? 'not-visible' : '';

            echo "<div class='col-12 mt-4 nav-buttons d-flex justify-content-center'>";
                echo "<div class='btn-group me-2'><a class='$baseBtn $prevHide' id='btn-prev' href='#'>Anterior</a></div>";
                echo "<div class='btn-group me-2'><a class='$baseBtn' id='btn-page' href='#'>1</a></div>";
                echo "<div class='btn-group'><a class='$baseBtn $nextHide' id='btn-next' href='#'>Siguiente</a></div>";
            echo "</div>";

        } else if($subControl==0) {
            echo "<div class='col-12'><h4>Aún no hay suscripciones</h4></div>";
        } else if($subControl==-1) {
            echo "<div class='col-12'><h4>Error al cargar las suscripciones</h4></div>";
        }
        ?>
    </div>
</section>

<script src="../assets/js/content_paginate.js"></script>
<script>
    var subControl = <?php echo json_encode($subControl); ?>;
    var member = <?php echo json_encode($member); ?>;
    content_paginate(subControl, 8);

    // Build card markup for each subscription and insert into #boxContent
    function createContent(sub){
        let perkList = '';
        if(sub['PerkList']!=null && sub['PerkList'].length>0){
            perkList += '<ul class="text-start">';
            for(let i=0;i<sub['PerkList'].length;i++)
                perkList += '<li><b>' + sub['PerkList'][i]['Nombre'] + '</b>: ' + sub['PerkList'][i]['Descripcion'] + '</li>';
            perkList += '</ul>';
        } else {
            perkList += '<p class="text-start">No incluye beneficios adicionales</p>';
        }

        let actionBtn = '';
        if(member && member['Estado']==1)
            actionBtn = '<span class="btn btn-danger">Ya posees una suscripción activa</span>';
        else
            actionBtn = '<a href="#" class="btn btn-log element-green-bg" onclick="buySub(' + sub['Suscripcion_ID'] + ', ' + sub['Precio_Mensual'] + ')">Comprar</a>';

        const card = `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 card-prod element-green-border-2">
                    <div class="card-header element-green-bg text-white fw-bold">${sub['Nombre']}</div>
                    <div class="card-body">
                        ${perkList}
                        <p class="card-text">Duración: <strong>${sub['Duracion_Base']} meses</strong></p>
                        <p class="card-text">Precio: <strong>${sub['Precio_Mensual']}€</strong></p>
                        <div>${actionBtn}</div>
                    </div>
                </div>
            </div>
        `;

        $("#boxContent").append(card);
    }

    // Update-member modal loader
    $(document).on('click', '#update-member', function() {
        $("#modal").load("Views/Form_Upd_Member.php?methodMember=viewAdd", function() { $("#formPopup").fadeIn(300); });
    });

    // Buy subscription: save cookie and redirect to Stripe view
    function buySub(id, price){
        document.cookie = "data-member=" + JSON.stringify({ sId: id, price: price }) + "; path=/; max-age=" + (86400 * 30);
        window.location.href = "/FARMXPRESS/include/principal.php?methodMember=viewStripe";
    }
</script>