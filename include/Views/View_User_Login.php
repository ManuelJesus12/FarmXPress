<article class="col-4 form-log site-section rounded mb-3">
    <h2>Iniciar Sesión</h2>
    <table style="margin:auto" >
        <form action="principal.php?methodUser=login" method="post">
            <tr>
                <td>Empresa: </td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Contraseña: </td>
                <td><input type="password" name="password"></td>
            </tr>
            <?php if(isset($_GET["login"]) && $_GET["login"]=="false"){ ?>
                <tr>
                    <td colspan="2"><p style="color:red">Usuario o contraseña incorrectos</p></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2"><input type="submit" class="btn-log btn-shape element-green-bg" value="Aceptar"></td>
            </tr>
        </form>
            <tr>
                <td colspan="2"><p>¿Aún no tienes una cuenta? <a href="principal.php?methodUser=viewRegister">Regístrate gratis</a></p></td>
            </tr>
    </table>
</article>