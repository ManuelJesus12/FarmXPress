function content_paginate(contentList, itemAmount){
    /////////////////////////////CARGA INICIAL/////////////////////////////
    $("#boxContent").on("load", function(){
        for(let i=0; i<itemAmount; i++){
            if(contentList[i]!=undefined)
                createContent(contentList[i]);
            else break;

            if(contentList[i+1]==undefined) $("#btn-next").addClass("not-visible");
            else $("#btn-next").removeClass("not-visible");
        }
    });
    $("#boxContent").trigger("load");
    /////////////////////////////CARGA INICIAL/////////////////////////////

    /////////////////////////////BOTÓN DERECHO/////////////////////////////
    $("#btn-next").on("click", function(){
        $("#boxContent").empty().fadeOut(100).fadeIn(100);
        let page = parseInt($("#btn-page").text())+1;
        let offset = (page-1)*itemAmount;

        for(let i=offset; i<offset+itemAmount; i++){
            if(contentList[i]!=undefined)
                createContent(contentList[i]);
            else break;
            if(contentList[i+1]==undefined) $("#btn-next").addClass("not-visible");
            else $("#btn-next").removeClass("not-visible");
        }
        $("#btn-prev").removeClass("not-visible");
        $("#btn-page").text(page);

        event.preventDefault();
    });
    /////////////////////////////BOTÓN DERECHO/////////////////////////////

    ////////////////////////////BOTÓN IZQUIERDO////////////////////////////
    $("#btn-prev").on("click", function(){
        $("#boxContent").empty().fadeOut(100).fadeIn(100);
        let page = parseInt($("#btn-page").text())-1;
        let offset = (page-1)*itemAmount;

        for(let i=offset; i<offset+itemAmount; i++){
            if(contentList[i]!=undefined)
                createContent(contentList[i]);
            else break;
        }
        if(page==1) $("#btn-prev").addClass("not-visible");
        else $("#btn-prev").removeClass("not-visible");
        $("#btn-next").removeClass("not-visible");
        $("#btn-page").text(page);

        event.preventDefault();
    });
    ////////////////////////////BOTÓN IZQUIERDO////////////////////////////
}

////////////////////////////FILTRAR PRODUCTOS////////////////////////////
function filterProduct(itemAmount){
    let page = 1; let offset = (page-1)*5;
    let value = $("#inputSearch").val().toLowerCase();
    
    let filteredProducts = productControl.filter(prod => 
        (prod["Nombre"].toLowerCase().includes(value) || 
        prod["Referencia"].toLowerCase().includes(value)) );
    
    $("#boxContent").empty().fadeOut(100).fadeIn(100);
    for(let i=offset; i<offset+itemAmount; i++){
        if(filteredProducts[i]!=undefined)
            createContent(filteredProducts[i]);
        else break;
    }
    if(filteredProducts[offset+5]==undefined) $("#btn-next").addClass("not-visible");
    else $("#btn-next").removeClass("not-visible");
    
    if(page==1) $("#btn-prev").addClass("not-visible");
    else $("#btn-prev").removeClass("not-visible");

    $("#btn-page").text(page);
    event.preventDefault();
}
////////////////////////////FILTRAR PRODUCTOS////////////////////////////