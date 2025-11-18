///////////////////////////////////////////////////////////////
async function validateField(field, value, fieldName, idField, type) {
    var id = ($(idField).length > 0) ? $(idField).val().trim() : null;

    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../assets/php/validateField.php',
            type: 'POST',
            dataType: 'json',
            data: { field: field, value: value, objectId: id, type: type },
            success: function(response) {
                if(response.text != 0){
                    $("#error-"+fieldName).text("Ya hay un usuario registrado con este " + field);
                    $("#"+fieldName).addClass("input-error");
                    $("#"+fieldName).val("");
                    $("#"+fieldName).focus();
                    resolve(false);
                }else{
                    $("#"+fieldName).removeClass("input-error");
                    $("#error-"+fieldName).text("");
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
