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
            $c = new PDO("mysql:host=localhost;dbname=farmxpress", "root", "");
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
        $allowedPages = ["testimonials", "services", "contact", "about", "aviso-legal", "politica-cookies", "politica-privacidad", "plan-prevencion"];
        if(isset($_GET["view"]) && in_array($_GET["view"], $allowedPages))
            include("views/pages/".$_GET["view"].".php");
        else{
            $type = (isset($_SESSION["User"]) && $_SESSION["User"]["Nombre"]=="ADMINISTRADOR") ? "Admin" : "User";
            include("views/viewIndex$type.php");
        }
        
        $this->checkRentsActive(); $this->checkMembersActive();
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
            $this->checkRentsActive(); $this->checkMembersActive();
        }
        if(isset($_GET["methodProd"]))
            include("_Indexes/Index_Product.php");
        if(isset($_GET["methodUser"]))
            include("_Indexes/Index_User.php");
        if(isset($_GET["methodAdmin"]))
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

    /*
    Funcion: Incluir el índice de los alquileres para comprobar los alquileres activos y desactivar los que hayan finalizado
    @param: No recibe parametros
    @return: No devuelve nada, pero incluye los índices de las visitas, miembros y alquileres
    */
    function checkRentsActive(){
        global $dirLocation, $PDOConnect;
        
        if(($PDOConnect!=false) && isset($_SESSION["User"])){
            $dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
            include($dir."_Indexes/Index_Rent.php");
            $rentController -> checkActiveRents();
        }
    }

    function checkMembersActive(){
        global $dirLocation, $PDOConnect;
        
        if(($PDOConnect!=false)  && isset($_SESSION["User"])){
            $dir = ($dirLocation == 1) ? "" : (($dirLocation == 2) ? "../" : "include/"); 
            include($dir."_Indexes/Index_Member.php");
            $memberController -> activeMember();
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
}
?>