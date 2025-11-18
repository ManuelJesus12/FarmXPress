<?php global $PDOConnect; ?>
<link rel="stylesheet" href="assets/css/principal.css">
<!-- Sidebar Menu -->
    <nav id="navmenu" class="d-none d-lg-block navmenu">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .margin-5 class
            with font-awesome or any other icon font library -->
            
        <?php if($PDOConnect==false){ ?>
            <li class="nav-item"><a href="include/principal.php?methodAdmin=CreateBD" target="main-frame" class="nav-link sidebar-link element-green-color" onclick="setTimeout(function() {window.location.reload();}, 250);"><i class="margin-5 fa-solid fa-database"></i><p><b>Crear Base de Datos</b></p></a></li>
        <?php }else{ ?>
            <li class="nav-item"><a href="include/principal.php?methodAdmin=DeleteBD" target="main-frame" class="nav-link sidebar-link element-red-color" onclick="setTimeout(function() {window.location.reload();}, 250);"><i class="margin-5 fa-solid fa-database"></i><p><b>Eliminar Base de Datos</b></p></a></li>
            <li class="nav-item"><a href="include/principal.php?methodAdmin=DataUpload" target="main-frame" class="nav-link sidebar-link element-green-color" onclick="setTimeout(function() {window.location.reload();}, 250);" style='color: orange !important;'><i class="margin-5 fa-solid fa-file-import"></i><p><b>Carga Masiva de Datos</b></p></a></li>
        <?php } ?>

        <li class="nav-item">
        <a href="include/principal.php?methodUser=select&page=1" target="main-frame" class="nav-link sidebar-link element-green-color">
            <i class="margin-5 fa-solid fa-users"></i><p><b>Gestionar Usuarios</b></p>
        </a>
        </li>

        <li class="nav-item">
        <a href="include/principal.php?methodCat=select&page=1" target="main-frame" class="nav-link sidebar-link element-green-color">
            <i class="margin-5 fa-solid fa-tags"></i><p><b>Gestionar Categorías</b></p>
        </a>
        </li>

        <li class="nav-item">
        <a href="include/principal.php?methodSub=select&page=1" target="main-frame" class="nav-link sidebar-link element-green-color">
            <i class="margin-5 fa-solid fa-bell"></i><p><b>Gestionar Suscripciones</b></p>
        </a>
        </li>

        <li class="nav-item">
        <a href="include/principal.php?methodProd=select&page=1" target="main-frame" class="nav-link sidebar-link element-green-color">
            <i class="margin-5 fa-solid fa-wheat-awn"></i><p><b>Gestionar Productos</b></p>
        </a>
        </li>

        <li class="nav-item dropdown">
        <a href="#" class="nav-link sidebar-link element-green-color nav-admin-toggle-link">
            <i class="margin-5 fa-solid fa-file"></i>
            <p><b>Gestionar Logs </b><i class="right fas fa-angle-left"></i></p>
        </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="include/principal.php?methodAdmin=newLog" target="main-frame" class="nav-link sidebar-link element-green-color">
                    <i class="far fa-circle margin-5"></i>
                    <p>Visualizar Datos</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="include/principal.php?methodAdmin=viewLog" target="main-frame" class="nav-link sidebar-link element-green-color">
                    <i class="far fa-circle margin-5"></i>
                    <p>Consultar Logs Existentes</p>
                </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
        <a href="include/principal.php?methodUser=logout"class="nav-link element-red-color sidebar-link">
            <i class="margin-5 fa-solid fa-right-from-bracket"></i><p><b>Cerrar Sesión</b></p>
        </a>
        </li>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    <!-- /.sidebar-menu -->

<script>
$("#navmenu").on("click", "a:not(.nav-admin-toggle-link)", function() {
    $(".content-iframe").attr("src", $(this).attr("href"));
    $(".content-iframe").css("display", "block");
    $(".content-admin").css("display", "none");
});

$("#navmenu").on("click", ".dropdown > a", function(e) {
    e.preventDefault(); // prevent "#" from changing URL
    $(this).next(".nav-treeview").slideToggle();
    $(this).parent().toggleClass("menu-open");
});
</script>