<?php include("funciones.php"); ?>

<body style="margin:auto;">
    <?php include("../layouts/header.php"); ?>
    <div id="main" class="main-body text-center" >
        <?php seleccionarcontenidoPrincipal(); ?>
    </div>
    <?php include("../layouts/footer.php"); ?>
</body>

<script>
    //if($("#main").text().trim() == "") window.location.href = "../index.php?action=-1";
    //if($("#main").children().get(1).id == "article-error") $("#main").children().get(1).remove();
</script>