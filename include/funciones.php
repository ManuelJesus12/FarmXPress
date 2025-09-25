<?php
session_start();

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

/*
Funcion: Recoger la pagina en la que se desarrolla el programa
@param: $c - Conexion a la base de datos por referencia - Entrada y salida
*/
function PDOConnect(&$c){
    try {
        $c = new PDO("mysql:host=localhost;dbname=FARMXPRESS", "root", "");
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $c;
    } catch (Exception $e) {
        return false;
    }
}

/*
Funcion: Recoger la pagina en la que se desarrolla el programa
@param: No recibe parametros
@return: Devuelve 1 si es la pagina principal, 0 si es la pagina de inicio
*/
function dirChangeProgram(){
    $link=explode("/", $_SERVER["PHP_SELF"]);
    $page=$link[count($link)-1];
    if($page=="principal.php") return 1; 
    else if($page=="index.php") return 0;
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
    if(dirChangeProgram()==0){ $dirNav=""; $dirUrl="include/"; }else{ $dirNav="../"; $dirUrl=""; }

    if(isset($_SESSION["usuario"])){
        if($_SESSION["usuario"]!="ADMINISTRADOR"){
            if(!isset($_COOKIE["UserType"]) || !isset($_COOKIE["UserAvatar"])){
                include($dirNav."_Indexes/Index_User.php"); $field="Nombre";
                $usuario=$userController->selectUser($field, $_SESSION["usuario"])[0];

                $tipo=$usuario['Tipo'];
                if($usuario["Avatar"]==null) $avatarAux="anon.png"; 
                else $avatarAux=$usuario["Avatar"];
                
                $avatar=$dirNav."assets/img/users/".$avatarAux;
                setcookie("UserType", $tipo, time()+3600*24*7, "/");
                setcookie("UserAvatar", "assets/img/users/".$avatarAux, time()+3600*24*7, "/");
            }else{ $tipo=$_COOKIE["UserType"]; $avatar=$dirNav.$_COOKIE["UserAvatar"]; }

            if($tipo=="C") include($dirNav."views/navBar/navCliente.php");
            else if($tipo=="P") include($dirNav."views/navBar/navProveedor.php");

        }else
            echo '<i class="mobile-nav-toggle"></i>';
    }else
        include($dirNav."views/navBar/navInvitado.php");
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
    if(isset($_GET["methodUser"]))
        include("_Indexes/Index_User.php");
    if(isset($_GET["methodAdmin"])){
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR"){
            include("_Indexes/Index_Admin.php");
        }else
            echo "<article class='col-12 list-user form-log site-section rounded'><h2>Acceso a esta sección denegado</h2></article>";
    }

    if(PDOConnect($c)!=false && isset($_SESSION["usuario"])){
        includeVisit();

        if(isset($_GET["methodCat"]))
            include("_Indexes/Index_Category.php");
        if(isset($_GET["methodSub"]))
            include("_Indexes/Index_Sub.php");
        if(isset($_GET["methodPerk"]))
            include("_Indexes/Index_Perk.php");
        if(isset($_GET["methodProd"]))
            include("_Indexes/Index_Product.php");
        if(isset($_GET["methodFav"]))
            include("_Indexes/Index_Fav.php");
        if(isset($_GET["methodRev"]))
            include("_Indexes/Index_Review.php");
        if(isset($_GET["methodPay"]))
            include("_Indexes/Index_Pay.php");
    }
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
    includeVisit();

    if(isset($_GET["view"])){
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
    }else{
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]=="ADMINISTRADOR")
            include("views/viewIndexAdmin.php");
        else
            include("views/viewIndexUser.php");
    }    
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
    if((PDOConnect($c)!=false && isset($_SESSION["usuario"]) and $_SESSION["usuario"]!="ADMINISTRADOR") and !isset($dirChangeVar)){
        if(dirChangeProgram()==1) $dir=""; else $dir="include/";
        include($dir."_Indexes/Index_Visit.php");
        include($dir."_Indexes/Index_Member.php");
        include($dir."_Indexes/Index_Rent.php");
        
        $offset=-1;
        $memberController -> activeMember();
        $rentController   -> checkActiveRent($offset);
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

?>