function content_paginate(contentList){
    /////////////////////////////CARGA INICIAL/////////////////////////////
    $("#boxContent").on("load", function(){
        for(let i=0; i<5; i++){
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
        event.preventDefault();

        $("#boxContent").empty();
        let page = parseInt($("#btn-page").text())+1;
        let offset = (page-1)*5;

        for(let i=offset; i<offset+5; i++){
            if(contentList[i]!=undefined)
                createContent(contentList[i]);
            else break;
            if(contentList[i+1]==undefined) $("#btn-next").addClass("not-visible");
            else $("#btn-next").removeClass("not-visible");
        }
        $("#btn-prev").removeClass("not-visible");
        $("#btn-page").text(page);
    });
    /////////////////////////////BOTÓN DERECHO/////////////////////////////

    ////////////////////////////BOTÓN IZQUIERDO////////////////////////////
    $("#btn-prev").on("click", function(){
        event.preventDefault();
        
        $("#boxContent").empty();
        let page = parseInt($("#btn-page").text())-1;
        let offset = (page-1)*5;

        for(let i=offset; i<offset+5; i++){
            if(contentList[i]!=undefined)
                createContent(contentList[i]);
            else break;
        }
        if(page==1) $("#btn-prev").addClass("not-visible");
        else $("#btn-prev").removeClass("not-visible");
        $("#btn-next").removeClass("not-visible");
        $("#btn-page").text(page);
    });
    ////////////////////////////BOTÓN IZQUIERDO////////////////////////////
}