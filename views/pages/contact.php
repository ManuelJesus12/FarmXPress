<style>
a, a h2{font-weight: bold;}
</style>

<?php include("layouts/header.php"); ?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
  <div class="container position-relative">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
    <h2>Servicio de Contacto</h2>
  </div><!-- End Section Title -->
  </div>
</div>
<!-- End Page Title -->

<!-- Contact Section -->
<section id="contact" class="contact section">

  <div class="col-10 site-article google-map element-green-color text-center" data-aos="fade">
    <a class="btn-log">Estamos situados en:</a>
    <iframe class="col-12" style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6351.301047696279!2d-7.209022962556408!3d37.255998384715824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1031c52bfcf10d%3A0x3d3cdb74ee712c96!2sIES%20La%20Arboleda!5e0!3m2!1ses!2ses!4v1746433450044!5m2!1ses!2ses" frameborder="0" allowfullscreen=""></iframe>
  </div><!-- End Google Maps -->

  <div class="container site-article" data-aos="fade">
    <div class="row gy-5 gx-lg-5">

      <div class="col-lg-4">
        <div class="info">
          <h3>Ponte en Contacto</h3>
          <p>Si tienes alguna consulta sobre el funcionamiento o políticas de esta web, contáctanos:</p>

          <div class="info-item d-flex">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h4>Dirección:</h4>
              <p>Av de la Arboleda, s/n, Av. Arboleda, 21440 Lepe, Huelva</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h4>Correo Electrónico:</h4>
              <p>info@farmxpress.com</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex">
            <i class="bi bi-phone flex-shrink-0"></i>
            <div>
              <h4>Teléfono:</h4>
              <p>+1 999 99 99 99</p>
            </div>
          </div><!-- End Info Item -->
        </div>
      </div>

      <div class="col-lg-8">
        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Tu Nombre" required="">
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Tu correo electrónico" required="">
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" required="">
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" placeholder="Mensaje" required=""></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Cargando...</div>
            <div class="error-message"></div>
            <div class="sent-message">Tu mensaje ha sido enviado. Gracias.</div>
          </div>
          <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>

</section><!-- /Contact Section -->
</main>

<?php include("layouts/footer.php") ?>