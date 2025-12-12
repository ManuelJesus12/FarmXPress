<body class="index-page">

<?php include("layouts/header.php"); 

if(isset($_GET['action'])){
    $name=(isset($_SESSION["User"])) ? $_SESSION["User"]["Nombre"] : "";
    echo "<script>showBoxSuccessLogin('".$_GET["action"]."', '".$name."');</script>";
}
?>

<main class="main">
<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

    <div class="carousel-item active">
        <img src="assets/img/hero/hero_1.jpg" alt="">
        <div class="carousel-container">
        <h2>Alquiler de Maquinaria Agrícola de Última Generación</h2>
        <p>Optimiza tus cosechas con equipos modernos disponibles cuando los necesites, sin comprometer tu capital.</p>
        </div>
    </div><!-- End Carousel Item -->

    <div class="carousel-item">
        <img src="assets/img/hero/hero_2.jpg" alt="">
        <div class="carousel-container">
        <h2>Renting Flexible para el Campo</h2>
        <p>Nuestros proveedores ofrecen planes de renting personalizados para tractores, sembradoras, sistemas de riego y más.</p>
        </div>
    </div><!-- End Carousel Item -->

    <div class="carousel-item">
        <img src="assets/img/hero/hero_3.jpg" alt="">
        <div class="carousel-container">
        <h2>Soluciones Tecnológicas para una Agricultura Eficiente</h2>
        <p>Desde drones hasta sensores de humedad: integra tecnología sin grandes inversiones iniciales.</p>
        </div>
    </div><!-- End Carousel Item -->

    <div class="carousel-item">
        <img src="assets/img/hero/hero_4.jpg" alt="">
        <div class="carousel-container">
        <h2>Equipos Disponibles Cuando Más los Necesitas</h2>
        <p>Alquila por día, semana o temporada según las necesidades de tu producción agrícola.</p>
        </div>
    </div><!-- End Carousel Item -->

    <div class="carousel-item">
        <img src="assets/img/hero/hero_5.jpg" alt="">
        <div class="carousel-container">
        <h2>Impulsa tu Producción sin Comprar Maquinaria</h2>
        <p>Con nuestras soluciones de renting podés crecer más rápido, con menor riesgo y mayor flexibilidad.</p>
        </div>
    </div><!-- End Carousel Item -->

    <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
    </a>

    <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
    </a>

    <ol class="carousel-indicators"></ol>

    </div>

</section><!-- /Hero Section -->

<?php global $PDOConnect;
if($PDOConnect!=false) { 
  include("include/_Indexes/Index_Product.php"); $count=1;
  $productControl = $productController->carouselListProduct();

  if(is_array($productControl) && count($productControl) > 0) {
?>
  <section id="services-2" class="services-2 element-green-bg">
    <div class="container section-title" data-aos="fade-up">
      <h2>Algunos de nuestros productos</h2>
    </div>
    <div class="services-carousel-wrap carousel-container">
      <div class="container">
        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "navigation": {
                "nextEl": ".js-custom-next",
                "prevEl": ".js-custom-prev"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 40
                }
              }
            }
          </script>
          <button class="navigation-prev js-custom-prev">
            <i class="bi bi-arrow-left-short"></i>
          </button>
          <button class="navigation-next js-custom-next">
            <i class="bi bi-arrow-right-short"></i>
          </button>
          <div class="swiper-wrapper">

          <?php foreach($productControl as $product) { ?>
            <div class='swiper-slide card-prod element-green-border rounded text-center pt-4 pb-4' style="margin: auto; font-size: 0.8em !important;">
              <?php if($product['Imagen']!=null) $file="assets/img/products/".$product['Imagen']; else $file="assets/img/products/anon.png"; ?>
              <img src="<?php echo $file; ?>" class="img-fluid shadow element-green-border rounded mb-3">
              <h3 class='service-item-category' style='color: white !important;'><?php echo $product['Nombre']." - ".$product['Precio_Mensual']; ?>€</h3>
              <?php if($product["Estado"]==1){ ?>
                <p class="card-text prod-status text-success fw-semibold mb-2" id='enabled-<?php echo $product["Producto_ID"]; ?>'>
                  <i class="fa fa-check-circle me-1"></i>Estado: Disponible
                </p>
              <?php } else { ?>
                <p class="card-text prod-status text-danger fw-semibold mb-2" id='disabled-<?php echo $product["Producto_ID"]; ?>'>
                  <i class="fa fa-times-circle me-1"></i>Estado: No disponible
                </p>
              <?php } 
              
              if(isset($_SESSION["User"])){ ?>
                <a href="include/principal.php?methodProd=viewProduct&id=<?php echo $product['Producto_ID']; ?>&page=1" class="col-6 btn btn-log btn-shape element-green-bg" style="font-size:1em">Ver Detalles</a>
              <?php } else { ?>
                <a href="include/principal.php?methodUser=login" class="col-6 btn btn-log btn-shape element-green-bg" style="font-size:1em">Iniciar Sesión</a>
              <?php } ?>
            </div>
          <?php } ?>

          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </section>
<?php }} ?>

<!-- Services Section -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
    <h2>SERVICIOS</h2>
    <p>Soluciones en maquinaria y tecnología agrícola al alcance de tu campo</p>
    </div><!-- End Section Title -->
    <div class="content">
    <div class="container">
        <div class="row g-0">
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">01</span>
            <div class="service-item-icon">
              <i class="fa-solid fa-tractor element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Alquiler de Tractores</h3>
                <p>
                Renta de tractores modernos y eficientes para todo tipo de labores agrícolas.
                </p>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">02</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-cloud-showers-water element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Sistemas de Riego</h3>
                <p>
                Instalación y alquiler de sistemas de riego por goteo, aspersión y automatizados.
                </p>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">03</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-seedling element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Maquinaria para Siembra</h3>
                <p>
                Equipos especializados para siembra precisa y eficiente, disponibles por campaña.
                </p>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">04</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-apple-whole element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Equipos para Cosecha</h3>
                <p>
                Alquiler de cosechadoras y recolectoras para distintos tipos de cultivos.
                </p>
            </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">05</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-satellite-dish element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Sistemas de Monitoreo</h3>
                <p>
                Renta de soluciones digitales para control de riego, humedad y rendimiento del campo.
                </p>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">06</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-tools element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Asesoramiento Técnico</h3>
                <p>
                Servicio de mantenimiento preventivo y correctivo para tu maquinaria alquilada.
                </p>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">07</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-truck element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Logística Agrícola</h3>
                <p>
                Coordinación de entrega, retiro y movilidad de maquinaria agrícola en tu precio.
                </p>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="service-item">
            <span class="number">08</span>
            <div class="service-item-icon">
                <i class="fa-solid fa-wrench element-green-color service-icon"></i>
            </div>
            <div class="service-item-content">
                <h3 class="service-heading">Mantenimiento de Equipos</h3>
                <p>
                Servicio de mantenimiento preventivo y correctivo para tu maquinaria alquilada.
                </p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</section><!-- /Services Section -->

<!-- About Section -->
<section id="about" class="about section">

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="assets/img/img_long_5.jpg" alt="Maquinaria agrícola en acción" class="img-fluid img-overlap" data-aos="zoom-out">
        </div>
        <div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="100">
          <h3 class="content-subtitle text-white opacity-50">¿Por qué elegirnos?</h3>
          <h2 class="content-title mb-4">
            Más de <strong>50 años de experiencia</strong> apoyando al campo con tecnología y maquinaria
          </h2>
          <p class="opacity-50">
            Nos especializamos en brindar soluciones confiables de alquiler de maquinaria agrícola, sistemas de riego y herramientas tecnológicas para maximizar la productividad y sostenibilidad de tus cultivos.
          </p>

          <div class="row my-5">
            <div class="col-lg-12 d-flex align-items-start mb-4">
              <i class="bi bi-gear-wide-connected me-4 display-6"></i>
              <div>
                <h4 class="m-0 h5 text-white">Tecnología que trabaja para ti</h4>
                <p class="text-white opacity-50">Ofrecemos equipos modernos y eficientes para cada etapa del proceso agrícola.</p>
              </div>
            </div>
            <div class="col-lg-12 d-flex align-items-start mb-4">
              <i class="bi bi-people me-4 display-6"></i>
              <div>
                <h4 class="m-0 h5 text-white">Asesoramiento personalizado</h4>
                <p class="text-white opacity-50">Contamos con un equipo técnico que te guía en cada decisión para optimizar tus recursos.</p>
              </div>
            </div>
            <div class="col-lg-12 d-flex align-items-start">
              <i class="bi bi-truck me-4 display-6"></i>
              <div>
                <h4 class="m-0 h5 text-white">Logística rápida y segura</h4>
                <p class="text-white opacity-50">Entregamos e instalamos los equipos en tiempo récord en cualquier zona rural.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- /About Section -->


<!-- About 3 Section -->
<section id="about-3" class="about-3 section">

  <div class="container">
    <div class="row gy-4 justify-content-between align-items-center">
      <div class="col-lg-6 order-lg-2 position-relative" data-aos="zoom-out">
        <img src="assets/img/services/img_sq_1.jpg" alt="Maquinaria agrícola moderna" class="img-fluid">
        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn">
          <span class="play"><i class="bi bi-play-fill"></i></span>
        </a>
      </div>
      <div class="col-lg-5 order-lg-1" data-aos="fade-up" data-aos-delay="100">
        <h2 class="content-title mb-4">Impulsamos el futuro de la agricultura</h2>
        <p class="mb-4">
          Nuestra misión es facilitar el acceso a maquinaria de última generación y sistemas agrícolas eficientes a través de un modelo de alquiler accesible, flexible y adaptado a cada necesidad del productor.
        </p>
        <ul class="list-unstyled list-check">
          <li>Equipos modernos para siembra, cosecha y riego</li>
          <li>Planes de renting ajustados a tus ciclos agrícolas</li>
          <li>Soporte técnico y mantenimiento incluidos</li>
        </ul>

        <p><a href="#" class="btn-cta">Contáctanos hoy</a></p>
      </div>
    </div>
  </div>
</section><!-- /About 3 Section -->

<!-- Testimonials Section -->
<section class="testimonials-12 testimonials section" id="testimonials">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>TESTIMONIOS</h2>
    <p>Lo que dicen nuestros clientes del campo</p>
  </div><!-- End Section Title -->

  <div class="testimonial-wrap">
    <div class="container">
      <div class="row d-flex justify-content-evenly">

      <div class="review card col-lg-5 col-md-5 col-sm-10 mb-3">
        <div class="card-body">
          <div class="d-flex align-items-start align-items-center mb-2">
            <img class="img-fluid card-image me-3 review-image" src="assets/img/testimonials/testimonials-01.jpg" alt="Imagen del usuario">
              <div>
                <p class="card-title mb-1">Carlos González</p>
                <p>Productor en Santa Fe</p>
              </div>
          </div>
          <p class="card-text text-start">“Gracias al renting de tractores, pude sembrar a tiempo toda mi parcela. ¡El equipo estaba impecable y el soporte fue excelente!”</p>
        </div>
      </div>

      <div class="review card col-lg-5 col-md-5 col-sm-10 mb-3">
        <div class="card-body">
          <div class="d-flex align-items-start align-items-center mb-2">
            <img class="img-fluid card-image me-3 review-image" src="assets/img/testimonials/testimonials-02.jpg" alt="Imagen del usuario">
              <div>
                <p class="card-title mb-1">Esteban Morales</p>
                <p>Finca El Amanecer</p>
              </div>
          </div>
          <p class="card-text text-start">“Alquilamos cosechadoras durante la temporada alta. Nos permitió ahorrar en mantenimiento y tener siempre equipos listos para trabajar.”</p>
        </div>
      </div>
        
        <a href="index.php?view=testimonials" class="btn btn-cta btn-shape element-green-bg">Ver más testimonios</a>
      </div>
    </div>
  </div>
</section><!-- /Testimonials Section -->
</main>

<?php include("layouts/footer.php") ?>