<?php include("layouts/header.php"); ?>

<main class="main">
<!-- Page Title -->
<div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
  <div class="container position-relative">
    <h1>Servicios</h1>
  </div>
</div>
<!-- End Page Title -->

<!-- Services 2 Section -->
<section id="services-2" class="services-2 element-green-bg">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Servicios</h2>
    <p>Soluciones integrales para el campo</p>
  </div><!-- End Section Title -->

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
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Alquiler</h2>
                  <span class="service-item-title text-black">Tractores y sembradoras</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_1.jpg" alt="Tractor en campo" style="height:347px" class="img-fluid rounded">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Tecnología</h2>
                  <span class="service-item-title text-black">Sistemas de riego automatizado</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_3.jpg" alt="Sistema de riego" class="img-fluid rounded">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Mantenimiento</h2>
                  <span class="service-item-title text-black">Asistencia técnica especializada</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_8.jpg" alt="Técnico agrícola" class="img-fluid rounded">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Logística</h2>
                  <span class="service-item-title text-black">Transporte de maquinaria</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_4.jpg" alt="Camión transportando maquinaria" class="img-fluid rounded">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Cosecha</h2>
                  <span class="service-item-title text-black">Alquiler de cosechadoras</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_5.jpg" alt="Cosechadora en acción" class="img-fluid rounded">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Innovación</h2>
                  <span class="service-item-title text-black">Monitoreo satelital de cultivos</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_6.jpg" alt="Monitoreo satelital" class="img-fluid rounded">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="service-item">
              <div class="service-item-contents">
                <a href="#">
                  <h2 class="service-item-category">Renting</h2>
                  <span class="service-item-title text-black">Maquinaria por temporada</span>
                </a>
              </div>
              <img src="assets/img/services/img_sq_8.jpg" alt="Maquinaria agrícola" class="img-fluid rounded">
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</section><!-- /Services 2 Section -->

<!-- Services Section -->
<section id="services" class="services section element-green-color">
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

<!-- Services Section -->
<section id="services" class="services section element-green-bg">
  <div class="container section-title" data-aos="fade-up">
    <h2 style="color:white">SERVICIOS ESPECIALIZADOS</h2>
    <p>Soluciones de alto valor para optimizar tu producción agrícola</p>
  </div><!-- End Section Title -->

  <div class="content">
    <div class="container">
      <div class="row g-0">

        <div class="col-lg-3 col-md-6">
          <div class="service-item">
            <span class="number">01</span>
            <div class="service-item-icon">
              <i class="fa-solid fa-video element-green-color service-icon"></i>
            </div>
            <div class="service-item-content element-green-color">
              <h3 class="service-heading">Drones Agrícolas</h3>
              <p>Monitoreo aéreo, fumigación y mapeo de cultivos con tecnología de drones de última generación.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="service-item">
            <span class="number">02</span>
            <div class="service-item-icon">
              <i class="fa-solid fa-brain element-green-color service-icon"></i>
            </div>
            <div class="service-item-content element-green-color">
              <h3 class="service-heading">Agricultura de Precisión</h3>
              <p>Análisis de datos, sensores y software para una toma de decisiones más eficiente en el campo.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="service-item">
            <span class="number">03</span>
            <div class="service-item-icon">
              <i class="fa-solid fa-bolt element-green-color service-icon"></i>
            </div>
            <div class="service-item-content element-green-color">
              <h3 class="service-heading">Energía Solar Rural</h3>
              <p>Soluciones de energía solar para sistemas de riego, cercos eléctricos y estaciones meteorológicas.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="service-item">
            <span class="number">04</span>
            <div class="service-item-icon">
              <i class="fa-solid fa-droplet element-green-color service-icon"></i>
            </div>
            <div class="service-item-content element-green-color">
              <h3 class="service-heading">Fertirrigación</h3>
              <p>Avanzados equipos para la aplicación precisa de fertilizantes y nutrientes a través del riego.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section><!-- /Services Section -->
</main>

<?php include("layouts/footer.php") ?>