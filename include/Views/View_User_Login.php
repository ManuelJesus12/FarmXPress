<article class="col-12 col-md-6 form-log site-section rounded mb-3 mx-auto">
    <h2 style='padding: 10px'>Iniciar Sesión</h2>

    <form action="principal.php?methodUser=login" method="post" id="form-login" class="needs-validation" novalidate>
        <div class="container-fluid">
            <div class="row gx-3">
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Empresa:</label>
                    <input type="text" name="name" id="name" class="form-control" />
                    <div class="form-text text-danger" id="error-name"></div>
                </div>

                <div class="col-12 mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" name="password" id="password" class="form-control" />
                    <div class="form-text text-danger" id="error-password"></div>
                </div>

                <?php if(isset($_GET["login"]) && $_GET["login"]=="false"){ ?>
                <div class="col-12 mb-2">
                    <div class="text-danger" id="server-error">Usuario o contraseña incorrectos</div>
                </div>
                <?php } ?>

                <div class="col-12 text-center mt-2">
                    <input type="submit" class="btn btn-pill btn-pill-green element-green-bg px-4 py-2" value="Aceptar" />
                </div>

                <div class="col-12 text-center mt-3">
                    <p>¿Aún no tienes una cuenta? <a href="principal.php?methodUser=viewRegister">Regístrate gratis</a></p>
                </div>
            </div>
        </div>
    </form>
</article>
<div style='height:50px'></div>