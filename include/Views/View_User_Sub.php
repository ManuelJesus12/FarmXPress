<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php
include("_Indexes/Index_Perk.php");
include("_Indexes/Index_Member.php");
$member=$memberController->selectMember();

if(isset($_GET['action']) && $_GET['action']!=null)
    echo "<script>showBoxSuccessMember(".$_GET['action'].");</script>";
///////////////////////////////////////////////////////////////////////
if(is_array($subControl)){
        foreach($subControl as &$sub){ $sub["PerkList"]=$perkController->viewListPerk($sub['Suscripción_ID']); }

        echo "<h2>Suscripciones disponibles</h2><br>";
        if(is_array($member)){
            echo "<div id='alert-success' class='col-lg-6 col-md-12 col-sm-12 alert alert-success'>Tu suscripción termina el ".date("d-m-Y", strtotime($member["Fecha_Fin"]))." ";
            echo "<br><a id='update-member' class='btn btn-log btn-shape element-green-bg' style='margin-left: 15px;'>Extender Suscripción</a></div>";
        }

        //*-----------------------------SUB LIST------------------------------*//
        echo "<div id='boxContent' class='row card-deck col-12'></div>";
        //*-----------------------------SUB LIST------------------------------*//

        //--------------------------------------------NAV BUTTONS--------------------------------------------->
        $class0=$class1=$class2="btn btn-log element-green-bg ";
        $class1=$class0."not-visible";
        if(count($subControl)<=8) $class2=$class0."not-visible";

        echo "<div class='nav-buttons site-article'>";
            echo "<div class='btn-group'><a class='$class1' id='btn-prev' href='#'>Anterior</a></div>";
            echo "<div class='btn-group'><a class='$class0' id='btn-page' href='#'>1</a></div>";
            echo "<div class='btn-group'><a class='$class2' id='btn-next' href='#'>Siguiente</a></div>";
        echo "</div>";
        //--------------------------------------------NAV BUTTONS--------------------------------------------->
}else if($subControl==0)
    echo "<h2>Aún no hay suscripciones</h2><br>";
else if($subControl==-1)
    echo "<h2>Error al cargar las suscripciones</h2>";
///////////////////////////////////////////////////////////////////////
?></article>

<script src="../assets/js/content_paginate.js"></script>
<script>
    var subControl = <?php echo json_encode($subControl); ?>;
    var member = <?php echo json_encode($member); ?>;
    content_paginate(subControl, 8);

    ////////////////////////////CONTENIDO////////////////////////////
    function createContent(sub){
        let perkList = state = "";
        if(sub['PerkList']!=null && sub['PerkList'].length>0){
            perkList+="<ul>";
            for(let i=0;i<sub['PerkList'].length;i++)
                perkList+="<li><b>"+sub['PerkList'][i]['Nombre']+"</b>: "+sub['PerkList'][i]['Descripción']+"</li>";
            perkList+="</ul><br>";
        }else
            perkList+="<p>No incluye beneficios adicionales</p><br>";

        if(member['Estado']==1)
            state+="<p class='btn btn-danger'>Ya posees una suscripción activa</p> ";
        else
            state+="<a href='#' class='btn btn-log element-green-bg' onclick='buySub("+sub['Suscripción_ID']+", "+sub['Precio_Mensual']+")'>Comprar</a> ";
        
        $("#boxContent").append(
            "<div class='col-lg-3 col-md-3 col-sm-12 card card-prod element-green-border-2 rounded'>"+
                "<div class='card-header element-green-bg'>"+sub["Nombre"]+"</div>"+
                "<div class='card-body'>"+
                    perkList+
                    "<p class='card-text'>Duración: "+sub['Duración_Base']+" meses</p>"+
                    "<p class='card-text'>Precio: "+sub['Precio_Mensual']+"€</p>"+
                    state+
                "</div>"+
            "</div>"
        );
    }
    ////////////////////////////CONTENIDO////////////////////////////
</script>

<script>
    ////////////////////////////ACTUALIZAR MEMBRESÍA////////////////////////////
    $("#update-member").on("click", function() {
        $("#modal").load("Views/Form_Upd_Member.php?methodMember=viewAdd", function() { $("#formPopup").fadeIn(1000); });
    });
    ////////////////////////////ACTUALIZAR MEMBRESÍA////////////////////////////

    ////////////////////////////COMPRAR MEMBRESÍA////////////////////////////
    function buySub(id, price){
        document.cookie = "data-member=" + JSON.stringify({
            sId: id,
            price: price
        }) + "; path=/; max-age=" + (86400 * 30);

        window.location.href = "/FARMXPRESS/include/principal.php?methodMember=viewStripe";
    }
    ////////////////////////////COMPRAR MEMBRESÍA////////////////////////////
</script>