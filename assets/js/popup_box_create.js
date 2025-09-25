///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function showBoxActiveUser(bool){
    const warning = document.createElement("div");

    if(bool==1){
        warning.textContent="Usuario activado correctamente";
        warning.setAttribute("class", "warning alert alert-success");
    }else{
        warning.textContent="Usuario desactivado correctamente";
        warning.setAttribute("class", "warning alert alert-danger");
    }

    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////

function showBoxActiveRent(name){
    const warning = document.createElement("div");
    
    warning.textContent="El alquiler del producto " + name + " ha finalizado.";
    warning.setAttribute("class", "warning alert alert-danger");
    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////

function showBoxActiveMember(name){
    const warning = document.createElement("div");
    
    warning.textContent="La suscripción " + name + " ha finalizado.";
    warning.setAttribute("class", "warning alert alert-danger");
    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////

function showBoxActiveFav(bool){
    const warning = document.createElement("div");

    if(bool==1){
        warning.textContent="Producto añadido a favoritos correctamente";
        warning.setAttribute("class", "warning alert alert-success");
    }else{
        warning.textContent="Producto eliminado de favoritos correctamente";
        warning.setAttribute("class", "warning alert alert-danger");
    }

    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function showBoxSuccessPay(bool){
    const warning = document.createElement("div");

    if(bool==1){
        warning.textContent="Pago realizado correctamente";
        warning.setAttribute("class", "warning alert alert-success");
    }else{
        warning.textContent="Error al realizar el pago";
        warning.setAttribute("class", "warning alert alert-danger");
    }

    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////

function showBoxSuccessLogin(bool, name){
    const warning = document.createElement("div");

    if(bool==0){
        warning.textContent="Sesión cerrada correctamente.";
        warning.setAttribute("class", "warning alert alert-danger");
    }else if(bool==1){
        warning.textContent="Bienvenido " + name + ", has iniciado sesión correctamente";
        warning.setAttribute("class", "warning alert alert-success");
    }else if(bool==2){
        warning.textContent="Datos actualizados correctamente, " + name;
        warning.setAttribute("class", "warning alert alert-success");
    }else if(bool==-1){
        warning.textContent="Error de conexión. Por favor, inténtalo de nuevo más tarde.";
        warning.setAttribute("class", "warning alert alert-danger");
    }

    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////

function showBoxSuccessMember(bool){
    const warning = document.createElement("div");

    if(bool==1){
        warning.textContent="Suscripción comprada correctamente.";
        warning.setAttribute("class", "warning alert alert-success");
    }else if(bool==2){
        warning.textContent="Suscripción extendida correctamente.";
        warning.setAttribute("class", "warning alert alert-success");
    }else if(bool==-1){
        warning.textContent="Error al comprar la suscripción.";
        warning.setAttribute("class", "warning alert alert-danger");
    }else if(bool==-2){
        warning.textContent="Error al extender la sucripción";
        warning.setAttribute("class", "warning alert alert-danger");
    }

    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function showBoxActionRev(bool){
    const warning = document.createElement("div");

    if(bool==1){
        warning.textContent="Reseña creada correctamente";
        warning.setAttribute("class", "warning alert alert-success");
    }else if(bool==0){
        warning.textContent="Error al alquilar el producto";
        warning.setAttribute("class", "warning alert alert-danger");
    }else if(bool==-1){
        warning.textContent="Reseña eliminada correctamente";
        warning.setAttribute("class", "warning alert alert-danger");
    }
    
    showBoxAux(warning);
}

function showBoxProduct(bool){
    const warning = document.createElement("div");

    if(bool==1){
        warning.textContent="Error inesperado, lo sentimos";
        warning.setAttribute("class", "warning alert alert-danger");
    }

    showBoxAux(warning);
};

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function showBoxAux(box){
    document.body.appendChild(box);

    setTimeout(function() { box.classList.add("show-warning"); }, 10);
    setTimeout(function() { box.classList.remove("show-warning"); }, 2000);
    setTimeout(function() { box.style.display = "none"; }, 2500);
}
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
