///////////////////////////////////////////////////////////////
async function validateField(field, value, fieldName, idField, link) {
    if($(idField).length > 0) var id = $(idField).val().trim();
    else var id= null;

    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../assets/js/' + link,
            type: 'POST',
            dataType: 'json',
            data: { field: field, value: value, objectId: id },
            success: function(response) {
                if(response.text != 0){
                    $("#error").text("Ya hay un usuario registrado con este " + field);
                    $("#" + fieldName).val("");
                    $("#" + fieldName).addClass("input-error");
                    $("#" + fieldName).focus();
                    resolve(false);
                }else{
                    $("#" + fieldName).removeClass("input-error");
                    $("#error").text("");
                    resolve(true);
                }
            },
            error: function(xhr, status, error) {
                $("#error").text("Error en la validación del campo " + field + ": " + error);
                reject(error);
            }
        });
    });
}

async function sleep(ms) { return new Promise(resolve => setTimeout(resolve, ms)); }
///////////////////////////////////////////////////////////////
