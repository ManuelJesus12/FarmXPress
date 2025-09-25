<div id="modal"></div>

<article class="col-10 list-prod form-log site-section rounded">
<?php
include("_Indexes/Index_Perk.php");
include("_Indexes/Index_Member.php");
$member=$memberController->selectMember(); $subCount=0;

if(isset($_GET['action']) && $_GET['action']!=null)
    echo "<script>showBoxSuccessMember(".$_GET['action'].");</script>";
///////////////////////////////////////////////////////////////////////
if(isset($subControl)){
    //*-----------------------------NOTIFICATIONS------------------------------*//
    if($subControl==0){
        echo "<h2>Aún no hay suscripciones</h2><br>";
    }else if($subControl==-1){
        echo "<h2>Error al cargar las suscripciones</h2>";
    }else{
    //*-----------------------------NOTIFICATIONS------------------------------*//

        echo "<h2>Suscripciones disponibles</h2><br>";
        if(is_array($member)){
            echo "<div id='alert-success' class='col-lg-6 col-md-12 col-sm-12 alert alert-success'>Tu suscripción termina el ".date("d-m-Y", strtotime($member[0]["Fecha_Fin"]))." ";
            echo "<br><a id='update-member' class='btn btn-log btn-shape element-green-bg' style='margin-left: 15px;'>Extender Suscripción</a></div>";
        }

        //*-----------------------------SUB LIST------------------------------*//
        echo "<div class='row card-deck col-12'>";
        foreach($subControl as $sub) {
            echo "<div class='col-lg-3 col-md-3 col-sm-12 card card-prod element-green-border-2 rounded'>";
                echo "<div class='card-header element-green-bg'>".$sub["Nombre"]."</div>";
                echo "<div class='card-body'>";
                $perkControl = $perkController->viewListPerk($sub['Suscripción_ID']);
                if ($perkControl != 0 && $perkControl != -1) {
                    echo "<p<ul>";
                    foreach ($perkControl as $perk) 
                        echo "<li><b>".$perk['Nombre']."</b>: ".$perk['Descripción']."</li>";
                    echo "</ul><br>";
                }

                    echo "<p class='card-text'>Duración: ".$sub['Duración_Base']." meses</p>";
                    echo "<p class='card-text'>Precio: ".$sub['Precio_Mensual']."€</p>";

                if(is_array($member) && $member[0]["Estado"]==1)
                    echo "<p class='btn btn-danger'>Ya posees una suscripción activa</p> ";
                else
                    echo "<a href='#' id='sub-".$sub['Suscripción_ID']."-".$sub['Precio_Mensual']."' class='btn btn-log element-green-bg'>Comprar</a> ";
                
                echo "</div>";
            echo "</div>";
        
            $subCount++; if($subCount==10) break;
        }
        echo "</div>";
        //*-----------------------------SUB LIST------------------------------*//

        //*-----------------------------NAV BUTTONS------------------------------*//
            echo "<div class='nav-buttons'>";
                echo "<div class='btn-group'>";
                    if(isset($_GET['page']) && $_GET['page']>1)
                        echo "<a class='btn btn-log element-green-bg' href='principal.php?methodSub=select&page=".($_GET['page']-1)."'>Anterior</a>";
                echo "</div>";
                echo "<div class='btn-group'>";
                        echo "<a class='btn btn-log element-green-bg' href='#'>".$_GET["page"]."</a>";
                echo "</div><div class='btn-group'>";
                    if(count($subControl)>10)
                        echo "<a class='btn btn-log element-green-bg' href='principal.php?methodSub=select&page=".($_GET['page']+1)."'>Siguiente</a>";
                echo "</div>";
            echo "</div>";
        //*-----------------------------NAV BUTTONS------------------------------*//
    }
}
///////////////////////////////////////////////////////////////////////
?></article>

<script>
    $("#update-member").on("click", function() {
        $("#modal").load("Views/Form_Upd_Member.php?methodMember=viewAdd", function() { $("#formPopup").fadeIn(1000); });
    });

    for(let $i=0;$i<$(".card").length;$i++){
        //*-----------------------------PAYMENT DATA------------------------------*//
        $(".card").eq($i).find(".btn-log").on("click", function(){
            let id=($(this).attr("id")).split("-")[1];
            let price=($(this).attr("id")).split("-")[2];

            document.cookie = "data-member=" + JSON.stringify({
                sId: id,
                price: price
            }) + "; path=/; max-age=" + (86400 * 30);

            let newForm = $("<form>", {
                action: "principal.php?methodMember=viewStripe",
                method: "POST"
            });
            $("body").append(newForm);
            newForm.submit();

        });
        //*-----------------------------PAYMENT DATA------------------------------*//
    }
</script>