<?php
///////////////////////////////////////////////////////////////////////
if(PDOConnect($c)!=false){
  include ("include/_Indexes/Index_User.php");
  include ("include/_Indexes/Index_Product.php");
  include ("include/_Indexes/Index_Rent.php");
  include ("include/_Indexes/Index_Member.php");

  $userCount = $userController -> countUser();
  $productCount = $productController -> countProduct();
  $rentCount = $rentController -> countRent();
  $memberCount = $memberController -> countMember();
}else{
  $userCount = $productCount = $rentCount = $memberCount = 0;
  if(dirChangeProgram()==1) $dir=""; else $dir="include/";
}
///////////////////////////////////////////////////////////////////////
?>

<!--------------------------------------------HEAD--------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <!-- Vendor CSS Files -->
  <link href= <?php echo $dir."assets/vendor/bootstrap/css/bootstrap.min.css"; ?> rel="stylesheet">
  <link href= <?php echo $dir."assets/vendor/bootstrap-icons/bootstrap-icons.css"; ?> rel="stylesheet">
  <link href= <?php echo $dir."assets/vendor/aos/aos.css"; ?> rel="stylesheet">
  <link href= <?php echo $dir."assets/vendor/swiper/swiper-bundle.min.css"; ?> rel="stylesheet">
  <link href= <?php echo $dir."assets/vendor/glightbox/css/glightbox.min.css"; ?> rel="stylesheet">

  <!-- Main CSS File -->
  <link href= "<?php echo $dir."assets/css/main.css"; ?>" rel="stylesheet">
  <link href= "<?php echo $dir."assets/css/principal.css"; ?>" rel="stylesheet">
  <script src="https://kit.fontawesome.com/874dee0d68.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<!--------------------------------------------HEAD--------------------------------------------->

<!--------------------------------------------BODY--------------------------------------------->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link" style="background-color: #116530;">
      <img src="assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">FARMXPRESS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: #116530;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/img/users/anon.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">ADMINISTRADOR</a>
        </div>
      </div>

      <?php include("views/navBar/navAdmin.php"); ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <iframe name="main-frame" class="content-iframe" src=""></iframe>
    
    <!-- Main content -->
    <section class="content content-admin">
      <div class="separator" style="margin-bottom: 25px"></div>
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row box-row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $rentCount ?></h3>

                <p>Alquileres totales</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="include/principal.php?methodAdmin=newLog" target="main-frame" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $productCount ?></h3>

                <p>Productos Totales</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="include/principal.php?methodProd=select&page=1" target="main-frame" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $userCount ?></h3>

                <p>Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="include/principal.php?methodUser=select&page=1" target="main-frame" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $memberCount ?></h3>

                <p>Suscripciones compradas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="include/principal.php?methodSub=select&page=1" target="main-frame" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable" style="text-align: center;">
            <h2>BIENVENIDO A LA ZONA ADMINISTRATIVA DE FARMXPRESS</h2>
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
<!--------------------------------------------BODY--------------------------------------------->

<script>
$(".small-box").on("click", "a:not(.nav-admin-toggle-link)", function() {
    $(".content-iframe").attr("src", $(this).attr("href"));
    $(".content-iframe").css("display", "block");
    $(".content-admin").css("display", "none");
});
</script>

</html>