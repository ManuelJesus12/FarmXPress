<nav id="navmenu" class="navmenu navbar-nav mb-2 mb-lg-0">
    <ul class="nav-bg-mobile">
        <li><a class="text-white" href="<?php echo $dirUrl."../index.php"; ?>" class="active"><span><i class="margin-5 fa-solid fa-house"></i>Inicio</span></a></li>
        <li><a class="text-white" href="<?php echo $dirUrl."principal.php?methodProd=select&page=1"; ?>"><span><i class="margin-5 fa-solid fa-wheat-awn"></i>Mis Productos</span></a></li>
        <li class="dropdown"><a href="#"><span class="text-white"><img class="user-avatar margin-5" src="<?php echo $dirFile; ?>"></img><?php echo $_SESSION["User"]["Nombre"]; ?></span> <i class="bi bi-chevron-down toggle-dropdown text-white"></i></a>
        <ul>
            <li><a href="<?php echo $dirUrl."principal.php?methodUser=viewUpdate"; ?>" style='background-color: white;'>Modificar Datos</a></li>
            <li><a href="<?php echo $dirUrl."principal.php?methodSub=select"; ?>"  style='background-color: white;'>Gestionar Suscripción</a></li>
            <li><a href="<?php echo $dirUrl."principal.php?methodUser=logout"; ?>" class="element-red-color">Cerrar Sesión</a></li>
        </ul>
        </li>
    </ul>
</nav>