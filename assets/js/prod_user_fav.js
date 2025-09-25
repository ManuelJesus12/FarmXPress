$(document).ready(function(){ 
    for(let $i=0;$i<$(".card").length;$i++){
        //*-----------------------------FAVORITE------------------------------*//
        $(".card").eq($i).find("a").eq(0).on("click", function(event){
            event.preventDefault();
            
            let id=$(this).attr("id").split("-")[1];
            let action=$(this).attr("id").split("-")[0];
            
            $.ajax({
                url: "principal.php?methodFav=toggleFav",
                type: "POST",
                data: {prodId:id, action:action},
                success: function(data){
                    if(action=="add"){
                        showBoxActiveFav(1);
                        $(".card").eq($i).find("a").eq(0).attr("id", "del-"+id);
                    }
                    else if (action=="del"){
                        showBoxActiveFav(0);
                        $(".card").eq($i).find("a").eq(0).attr("id", "add-"+id);
                    }
                    
                },
                error: function(){
                    alert("Error inesperado");
                }
            });
            $(this).children("i").eq(0).toggleClass("fa-regular");
            $(this).children("i").eq(0).toggleClass("fas");
        });
        //*-----------------------------FAVORITE------------------------------*//
    }
});