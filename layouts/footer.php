<?php 
    global $dirLocation, $interfaceController;
    $dir = ($dirLocation == 0) ? "" : "../"; 
?>

<footer id="footer" class="footer text-center">
    <div class="footer-top">
        <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12 col-md-6">
                <p>
                    <strong>FarmXPress</strong> - Todos los derechos reservados &copy; <?php echo date("Y"); ?> <br>
                </p>
                <ul class="footer-links">
                    <li><a href= "<?php echo $dir."index.php?view=contact";  ?>" >Contacto</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=services"; ?>" >Servicios</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=testimonials"; ?>" >Testimonios</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=about";  ?>" >Sobre nosotros</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=privacy"; ?>" >Política de privacidad</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=cookie"; ?>" >Política de cookies</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=legal";  ?>" >Aviso legal</a></li>
                    <li><a href= "<?php echo $dir."index.php?view=plan";  ?>" >Prevención Riesgos Laborales</a></li>
                </ul>
            </div>
        </div>
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src= <?php echo $dir."assets/vendor/bootstrap/js/bootstrap.bundle.min.js"; ?> ></script>
<script src= <?php echo $dir."assets/vendor/php-email-form/validate.js"; ?> ></script>
<script src= <?php echo $dir."assets/vendor/aos/aos.js"; ?> ></script>
<script src= <?php echo $dir."assets/vendor/swiper/swiper-bundle.min.js"; ?> ></script>
<script src= <?php echo $dir."assets/vendor/glightbox/js/glightbox.min.js"; ?> ></script>

<!-- Main JS File -->
<script src= <?php echo $dir."assets/js/main.js"; ?> ></script>
<?php ob_end_flush(); ?>

</body>
</html>
