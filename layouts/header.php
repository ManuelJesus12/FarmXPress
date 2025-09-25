<!DOCTYPE html>
<html lang="en">

<?php if(dirChangeProgram()==1) $dir="../"; else $dir=""; ?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - AgriCulture Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href= <?php echo $dir."assets/img/favicon.png"; ?> rel="icon">
    <link href= <?php echo $dir."assets/img/apple-touch-icon.png"; ?> rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href= <?php echo $dir."assets/vendor/bootstrap/css/bootstrap.min.css"; ?> rel="stylesheet">
    <link href= <?php echo $dir."assets/vendor/bootstrap-icons/bootstrap-icons.css"; ?> rel="stylesheet">
    <link href= <?php echo $dir."assets/vendor/aos/aos.css"; ?> rel="stylesheet">
    <link href= <?php echo $dir."assets/vendor/swiper/swiper-bundle.min.css"; ?> rel="stylesheet">
    <link href= <?php echo $dir."assets/vendor/glightbox/css/glightbox.min.css"; ?> rel="stylesheet">

    <!-- Main CSS File -->
    <link href= <?php echo $dir."assets/css/main.css"; ?> rel="stylesheet">
    <link href= <?php echo $dir."assets/css/principal.css"; ?> rel="stylesheet">
    <script src="https://kit.fontawesome.com/874dee0d68.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src= <?php echo $dir."assets/js/popup_box_create.js"; ?>></script>

    
    <!-- =======================================================
    * Template Name: AgriCulture
    * Template URL: https://bootstrapmade.com/agriculture-bootstrap-website-template/
    * Updated: Aug 07 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<header id="header" class="header d-flex align-items-center position-relative">
<div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
<?php
    $logo = $dir.'assets/img/logo.png';
    if(!isset($_SESSION["usuario"]) || (isset($_SESSION["usuario"]) && $_SESSION["usuario"]!="ADMINISTRADOR")){
        echo "<img src=$logo alt='FarmXPress' style='width: 80px ; height:60px ;'></img>";
    }

    ob_start();
    navegacion(); 
?>
</div>
</header>
