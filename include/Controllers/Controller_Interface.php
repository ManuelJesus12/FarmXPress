<?php
class InterfaceController {
    
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    Funcion: Recoger la pagina en la que se desarrolla el programa
    @param: $c - Conexion a la base de datos por referencia - Salida
    */
    function PDOConnect(){
        try {
            $c = new PDO("mysql:host=localhost;dbname=FARMXPRESS", "root", "");
            $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $c;
        } catch (Exception $e) {
            return false;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    Funcion: Seleccionar la barra de navegación que se va a mostrar, y guardar el tipo de usuario y su avatar en cookies
    @param: No recibe parametros
    @return: No devuelve nada, pero incluye la barra de navegación correspondiente
    */
    function navegacion(){
        global $dirLocation;
        $dirNav = ($dirLocation==0) ? "" : "../";
        $dirUrl = ($dirLocation==0) ? "include/" : "";

        if(isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]!="ADMINISTRADOR"){
            $dirFile = ($_SESSION["User"]["Avatar"]!=null) ? $dirNav."assets/img/users/".$_SESSION["User"]["Avatar"] : $dirNav."assets/img/users/anon.png";
            
            if($_SESSION["User"]["Tipo"]=="C") include($dirNav."views/navBar/navCliente.php");
            else if($_SESSION["User"]["Tipo"]=="P") include($dirNav."views/navBar/navProveedor.php");
        }else
            include($dirNav."views/navBar/navInvitado.php");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    Funcion: Mostrar las vistas y páginas de utilidad de la web
    @param: No recibe parametros
    @return: No devuelve nada, pero incluye las vistas correspondientes a cada página
    */
    function seleccionarContenidoIndex(){
        $allowedPages = ["testimonials", "services", "contact", "about", "legal", "cookie", "privacy", "plan"];
        if(isset($_GET["view"]) && in_array($_GET["view"], $allowedPages)){
            if($_GET["view"]=="testimonials")
                include("views/pages/testimonials.php");
            if($_GET["view"]=="services")
                include("views/pages/services.php");
            if($_GET["view"]=="contact")
                include("views/pages/contact.php");
            if($_GET["view"]=="about")
                include("views/pages/about.php");
            if($_GET["view"]=="legal")
                include("views/pages/aviso-legal.php");
            if($_GET["view"]=="cookie")
                include("views/pages/politica-cookies.php");
            if($_GET["view"]=="privacy")
                include("views/pages/politica-privacidad.php");
            if($_GET["view"]=="plan")
                include("views/pages/plan-prevencion.php");
        }else{
            $type = (isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]=="ADMINISTRADOR") ? "Admin" : "User";
            include("views/viewIndex$type.php");
        }  
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    Funcion: Mostrar el contenido principal de la pagina, dependiendo de si es un usuario o un administrador
    @param: No recibe parametros
    @return: No devuelve nada, pero incluye los índices correspondientes a cada entidad MVC para mostrar el contenido
    */
    function seleccionarContenidoPrincipal(){
        global $PDOConnect;

        if($PDOConnect!=false && isset($_SESSION["User"])){
            if(isset($_GET["methodCat"]))
                include("_Indexes/Index_Category.php");
            if(isset($_GET["methodSub"]))
                include("_Indexes/Index_Sub.php");
            if(isset($_GET["methodPerk"]))
                include("_Indexes/Index_Perk.php");
            if(isset($_GET["methodFav"]))
                include("_Indexes/Index_Fav.php");
            if(isset($_GET["methodRev"]))
                include("_Indexes/Index_Review.php");
            if(isset($_GET["methodPay"]))
                include("_Indexes/Index_Pay.php");
        }

        if(isset($_GET["methodProd"]))
            include("_Indexes/Index_Product.php");
        if(isset($_GET["methodUser"]))
            include("_Indexes/Index_User.php");
        if(isset($_GET["methodAdmin"]) && isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]=="ADMINISTRADOR")
            include("_Indexes/Index_Admin.php");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    Funcion: Incluir los índices de las visitas, miembros y alquileres para realizar las operaciones de inserción de visitas y desactivación correspondientes
    @param: No recibe parametros
    @return: No devuelve nada, pero incluye los índices de las visitas, miembros y alquileres
    */
    function includeVisit(){
        global $dirLocation, $PDOConnect;
        
        if(($PDOConnect!=false && isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]!="ADMINISTRADOR")){
            $dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
            include_once($dir."_Indexes/Index_Visit.php");
            $visitController  -> insertVisit();
        }
    }

    function checkRentsActive(){
        global $dirLocation, $PDOConnect;
        
        if(($PDOConnect!=false)){
            $dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
            include($dir."_Indexes/Index_Rent.php");
            $rentController -> checkActiveRents();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
}
?>