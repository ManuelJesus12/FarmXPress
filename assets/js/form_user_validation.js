$("#btn-data-user").on("click", async function(event){
    var email = $("#email").val().trim();      const emailRegex = /^[\w._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
    var cif = $("#cif").val().trim();          const cifRegex = /^[A-Z]{1}[0-9]{8}$/;
    var name = $("#name").val().trim();        const nameRegex = /^[A-Za-z0-9\s]+$/;
    var phone = $("#phone").val().trim();      const phoneRegex = /^[1-9][0-9]{8}$/;
    var address = $("#address").val().trim();  const addressRegex = /^[A-Za-z0-9\s.,\-ºª#\/]+$/;
    var password = "";                         const passwordRegex = /^[A-Za-z0-9\s.,\-ºª#\/]+$/;
    var region = $("#region").val().trim();    var province = $("#province").val().trim();  
    var file = $("#avatar").val().trim();

    // Email validación
    if(email.length < 3 || email.length > 100) {
        $("#error").text("El campo Email debe tener entre 3 y 100 caracteres.");
        $("#email").focus();
        return;
    }
    if (!emailRegex.test(email)) {
        $("#error").text("El campo Email no tiene un formato válido.");
        $("#email").focus();
        return;
    }
    let validEmail = await validateField("Email", email, "email", "#userId", "validateUser.php");
    if (!validEmail) return;
    // Email validación

    // CIF validación
    if(cif.length != 9) {
        $("#error").text("El campo CIF debe estar formado por 9 caracteres.");
        $("#cif").focus();
        return;
    }
    if (!cifRegex.test(cif)) {
        $("#error").text("El campo CIF no tiene un formato válido.");
        $("#cif").focus();
        return;
    }
    let validCif = await validateField("CIF", cif, "cif", "#userId", "validateUser.php");
    if (!validCif) return;
    // CIF validación

    // Nombre validación
    if(name.length < 3 || name.length > 100) {
        $("#error").text("El campo Nombre debe tener entre 3 y 100 caracteres.");
        $("#name").focus();
        return;
    }
    if (!nameRegex.test(name)) {
        $("#error").text("El campo Nombre no tiene un formato válido.");
        $("#name").focus();
        return;
    }
    if (name.toUpperCase() === "ADMINISTRADOR") {
        $("#error").text("Nombre no válido.");
        $("#name").val('');
        $("#name").focus();
        return;
    }
    let validName = await validateField("Nombre", name, "name", "#userId", "validateUser.php");
    if (!validName) return;
    // Nombre validación

    // Contraseña validación
    if($("#password").length > 0) {
        password = $("#password").val().trim();
        if(password.length < 3 || password.length > 20) {
            $("#error").text("El campo Contraseña debe tener entre 3 y 20 caracteres.");
            $("#password").focus();
            return;
        }
        if (!passwordRegex.test(password)) {
            $("#error").text("El campo Contraseña no tiene un formato válido.");
            $("#password").focus();
            return;
        }
    }
    // Contraseña validación

    // Teléfono validación
    if (!phoneRegex.test(phone)) {
        $("#error").text("El campo Teléfono no tiene un formato válido.");
        $("#phone").focus();
        return;
    }
    let validPhone = await validateField("Teléfono", phone, "phone", "#userId", "validateUser.php");
    if (!validPhone) return;
    // Teléfono validación

    // Dirección validación
    if(address.length < 3 || address.length > 255) {
        $("#error").text("El campo Dirección debe tener entre 3 y 255 caracteres.");
        $("#address").focus();
        return;
    }
    if (!addressRegex.test(address)) {
        $("#error").text("El campo Dirección no tiene un formato válido.");
        $("#address").focus();
        return;
    }
    let validAddress = await validateField("Dirección", address, "address", "#userId", "validateUser.php");
    if (!validAddress) return;
    // Dirección validación

    // Comunidad Autónoma y Provincia validación
    if(region == "") {
        $("#error").text("Debes seleccionar una Comunidad Autónoma.");
        $("#region").focus();
        return;
    }
    if(province == "") {
        $("#error").text("Debes seleccionar una Provincia.");
        $("#province").focus();
        return;
    }
    // Comunidad Autónoma y Provincia validación

    // Aceptar términos y condiciones
    if($("#terms").length > 0 && !$("#terms").is(":checked")) {
        $("#error").text("Debes aceptar los términos y condiciones.");
        return;
    }
    // Aceptar términos y condiciones

    // Subir Avatar
    if(file != "") {
        var fileExt = $("#avatar").val().split('.').pop().toLowerCase();
        if($.inArray(fileExt, ['png', 'jpg', 'jpeg']) == -1) {
            $("#error").text("El campo Avatar debe estar en formatos PNG, JPG o JPEG.");
            $("#avatar").focus();
            return;
        } else if ($("#avatar").get(0).files[0].size > 1000000) {
            $("#error").text("El campo Avatar no puede superar el 1MB.");
            $("#avatar").focus();
            return;
        } else {
            var formData = new FormData();
            var file=$("#avatar").get(0).files[0];
            if($("#userId").length > 0) var id = $("#userId").val().trim(); else var id="";

            formData.append('userId', id);
            formData.append('avatar', file);

            $.ajax({
                url: 'principal.php?methodUser=uploadAvatar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Upload response:', response.text);
                }
            });

            await sleep(500);
        }
    }
    // Subir Avatar

    var fieldValues = [email, cif, name, password, phone, address, region, province, $("#tipo").val() ?? "C"];
    document.cookie = "data-user=" + encodeURIComponent(JSON.stringify(fieldValues)) + "; max-age=" + (60);
    $("#form-data-user").submit();
    
    event.preventDefault();
});
///////////////////////////////////////////////////////////////