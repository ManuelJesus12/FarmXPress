///////////////////////////////////////////////////////////////
$("#btn-data-prod").on("click", async function() {
    var name = $("#name").val().trim();
    var desc = $("#desc").val().trim();
    var ref = $("#ref").val().trim();
    var price = $("#price").val().trim();
    var file = $("#imagen").val().trim();

    if (name.length < 3 || name.length > 100) {
        $("#error").text("El campo Nombre debe tener entre 3 y 100 caracteres.");
        $("#name").addClass("input-error");
        $("#name").focus();
        return;
    }else
        $("#name").removeClass("input-error");

    const refRegex = /^[A-Z]{1}[0-9]{4}$/;
    if(ref.length != 5) {
        $("#error").text("El campo Referencia debe estar formado por una mayúscula y 4 números.");
        $("#ref").addClass("input-error");
        $("#ref").focus();
        return;
    }else if (refRegex.test(ref) == false) {
        $("#error").text("El campo Referencia debe estar formado por una mayúscula y 4 números.");
        $("#ref").addClass("input-error");
        $("#ref").focus();
        return;
    }else{
        var validRef = await validateField("Referencia", ref, "ref", "#prodId", "PRODUCTO");
        if (!validRef) return;
        else $("#ref").removeClass("input-error");
    }

    if (desc.length < 5 || desc.length > 255) {
        $("#error").text("El campo Descripción debe tener al menos 5 caracteres.");
        $("#desc").addClass("input-error");
        $("#desc").focus();
        return;
    }else
        $("#desc").removeClass("input-error");

    if(isNaN(price) || price <= 0) {
        $("#error").text("El campo Precio Mensual debe ser un número positivo.");
        $("#price").addClass("input-error");
        $("#price").focus();
        return;
    }else
        $("#price").removeClass("input-error");

    if(file != "") {
        var fileExt = $("#imagen").val().split('.').pop().toLowerCase();
        if($.inArray(fileExt, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            $("#error").text("El campo Imagen debe estar en formatos GIF, PNG, JPG o JPEG.");
            $("#imagen").focus();
            return;
        } else if ($("#imagen").get(0).files[0].size > 1000000) {
            $("#error").text("El campo imagen no puede superar el 1MB.");
            $("#imagen").focus();
            return;
        }else{
            var formData = new FormData();
            var file=$("#imagen").get(0).files[0];
            if($("#prodId").length > 0) var id = $("#prodId").val().trim(); else var id="";

            formData.append('prodId', id);
            formData.append('imagen', file);

            $.ajax({
                url: 'principal.php?methodProd=uploadImage',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Upload response:', response);
                }
            });

            await sleep(1000);
        }
    }

    var fieldValues = [name, desc, ref, price, $("#cat").val()];
    document.cookie = "data-prod=" + encodeURIComponent(JSON.stringify(fieldValues)) + "; path=/; max-age=" + (60);
    $("#form-data-prod").submit();   
});
///////////////////////////////////////////////////////////////