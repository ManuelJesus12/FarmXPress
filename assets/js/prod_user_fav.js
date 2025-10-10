function toggleFav(id, action){
    event.preventDefault();

    $.ajax({
        url: "principal.php?methodFav=toggleFav",
        type: "POST",
        data: {prodId:id, action:action},
        success: function(data){
            if(action=="add"){
                showBoxActiveFav(1);
                $("#add-"+id).attr("onclick", "toggleFav("+id+", 'del')");
                $("#add-"+id).attr("id", "del-"+id);
            }
            else if (action=="del"){
                showBoxActiveFav(0);
                $("#del-"+id).attr("onclick", "toggleFav("+id+", 'add')");
                $("#del-"+id).attr("id", "add-"+id);
            }
        },
        error: function(){
            alert("Error inesperado");
        }
    });

    $("#fav-star-"+id).toggleClass("fa-regular");
    $("#fav-star-"+id).toggleClass("fas");
}