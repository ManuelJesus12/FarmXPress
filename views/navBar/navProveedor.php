<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="<?php echo $dirUrl."../index.php"; ?>" class="active"><span><i class="margin-5 fa-solid fa-house"></i>Inicio</span></a></li>
        <li><a href="<?php echo $dirUrl."principal.php?methodProd=select&page=1"; ?>"><span><i class="margin-5 fa-solid fa-wheat-awn"></i>Mis Productos</span></a></li>
        <li class="dropdown"><a href="#"><span><img class="user-avatar margin-5" src="<?php echo $file; ?>"></img> <?php echo $_SESSION["usuario"]; ?></span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
        <ul>
            <li><a href="<?php echo $dirUrl."principal.php?methodUser=viewUpdate"; ?>">Modificar Datos</a></li>
            <li><a href="<?php echo $dirUrl."principal.php?methodSub=select"; ?>">Gestionar Suscripción</a></li>
            <li><a href="<?php echo $dirUrl."principal.php?methodUser=logout"; ?>" class="element-red-color">Cerrar Sesión</a></li>
        </ul>
        </li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>