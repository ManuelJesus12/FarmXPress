<!--------------------------------------------HEAD--------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <script src="assets/js/popup_box_create.js"></script>
  <script src="https://kit.fontawesome.com/874dee0d68.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  
  <style>
    /* Small responsive helpers for the admin view */
    .content-iframe{ display: none; width:100%; border:0; min-height:70vh; }
    .content-admin{ display:block; }
    @media (max-width: 991.98px){
      .sidebar{ display: none; }
      .sidebar.mobile-visible{ display:block; position:fixed; z-index:1040; left:0; top:56px; bottom:0; width:260px; overflow:auto; }
      .content-wrapper{ padding-left:0 !important; }
    }
  </style>
</head>
<!--------------------------------------------HEAD--------------------------------------------->

<!--------------------------------------------LÓGICA------------------------------------------->
<?php 
  global $dirLocation, $PDOConnect;

  ///////////////////////////////////////////////////////////////////////
  if($PDOConnect!=false){
    include ("include/_Indexes/Index_User.php");
    include ("include/_Indexes/Index_Product.php");
    include ("include/_Indexes/Index_Rent.php");
    include ("include/_Indexes/Index_Member.php");

    $userCount = $userController -> countUser()['COUNT'];
    $productCount = $productController -> countProduct()['COUNT'];
    $rentCount = $rentController -> countRent();
    $memberCount = $memberController -> countMember();
  }else{
    $userCount = $productCount = $rentCount = $memberCount = 0;
    $dir = ($dirLocation==1) ? "" : "include/";
  }
  ///////////////////////////////////////////////////////////////////////
?>
<!-------------------------------------------LÓGICA-------------------------------------------->

<!--------------------------------------------BODY--------------------------------------------->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Mobile top navbar (visible on small screens) -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none w-100">
    <div class="container-fluid">
      <button class="btn btn-outline-success" id="admin-sidebar-toggle" type="button">
        <i class="bi bi-list"></i>
      </button>
      <a class="navbar-brand ms-2" href="index.php">FARMXPRESS</a>
      <button class="btn btn-outline-secondary ms-auto" id="admin-back-dashboard" style="display:none;">Volver</button>
    </div>
  </nav>

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

<!-- Bootstrap bundle (includes Popper) -->
<script src="<?php echo $dir."assets/vendor/bootstrap/js/bootstrap.bundle.min.js"; ?>"></script>
<script>
// Open links in iframe and toggle dashboard view
$(".small-box").on("click", "a:not(.nav-admin-toggle-link)", function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $(".content-iframe").attr("src", href).show();
    $(".content-admin").hide();
    // show back button on small screens
    $("#admin-back-dashboard").show();
});

// Back to dashboard (close iframe)
$("#admin-back-dashboard").on("click", function(){
    $(".content-iframe").attr("src", "").hide();
    $(".content-admin").show();
    $(this).hide();
    // ensure sidebar hidden on mobile
    if(window.innerWidth < 992){ $(".sidebar").removeClass('mobile-visible'); }
});

// Mobile sidebar toggle
$("#admin-sidebar-toggle").on("click", function(){
    if($(".sidebar").hasClass('mobile-visible')){
      $(".sidebar").removeClass('mobile-visible');
    }else{
      $(".sidebar").addClass('mobile-visible');
    }
});

// Hide mobile sidebar when clicking outside
$(document).on('click touchstart', function(e){
  var sidebar = $(".sidebar");
  if(window.innerWidth < 992 && sidebar.hasClass('mobile-visible')){
    if(!$(e.target).closest('.sidebar, #admin-sidebar-toggle').length){
      sidebar.removeClass('mobile-visible');
    }
  }
});
</script>

</html>

</html>