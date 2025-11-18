$("#btn-data-user").on("click", async function(event){
    event.preventDefault();

    var email = $("#email").val().trim();      const emailRegex = /^[\w._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
    var cif = $("#cif").val().trim();          const cifRegex = /^[A-Z]{1}[0-9]{8}$/;
    var name = $("#name").val().trim();        const nameRegex = /^[A-Za-z0-9\s]+$/;
    var phone = $("#phone").val().trim();      const phoneRegex = /^[1-9][0-9]{8}$/;
    var address = $("#address").val().trim();  const addressRegex = /^[A-Za-z0-9\s.,\-ºª#\/]+$/;
    var password = "";                         const passwordRegex = /^[A-Za-z0-9\s.,\-ºª#\/]+$/;
    var region = $("#region").val().trim();    var province = $("#province").val().trim();  
    var file = $("#avatar").val().trim();

    // Clear previous errors
    $('#error-email, #error-name, #error-cif, #error-phone, #error-address, #error-region, #error-province, #error-password, #error-avatar, #error-terms').text('');
    $('#email, #name, #cif, #phone, #address, #region, #province, #password, #avatar, #terms').removeClass('input-error');

    // Email validación
    if(email.length < 5 || email.length > 100) {
        $("#error-email").text("El campo Email debe tener entre 5 y 100 caracteres.");
        $("#email").addClass('input-error').focus();
        return;
    }
    if (!emailRegex.test(email)) {
        $("#error-email").text("El campo Email no tiene un formato válido.");
        $("#email").addClass('input-error').focus();
        return;
    }
    let validEmail = await validateField("Email", email, "email", "#userId", "USUARIO");
    if (!validEmail) return;
    // Email validación

    // Nombre validación
    if(name.length < 5 || name.length > 100) {
        $("#error-name").text("El campo Nombre debe tener entre 5 y 100 caracteres.");
        $("#name").addClass('input-error').focus();
        return;
    }
    if (!nameRegex.test(name)) {
        $("#error-name").text("El campo Nombre no tiene un formato válido.");
        $("#name").addClass('input-error').focus();
        return;
    }
    if (name.toUpperCase() === "ADMINISTRADOR") {
        $("#error-name").text("Nombre no válido.");
        $("#name").val('');
        $("#name").addClass('input-error').focus();
        return;
    }
    let validName = await validateField("Nombre", name, "name", "#userId", "USUARIO");
    if (!validName) return;
    // Nombre validación

    // CIF validación
    if(cif.length != 9) {
        $("#error-cif").text("El campo CIF debe estar formado por 9 caracteres.");
        $("#cif").addClass('input-error').focus();
        return;
    }
    if (!cifRegex.test(cif)) {
        $("#error-cif").text("El campo CIF no tiene un formato válido.");
        $("#cif").addClass('input-error').focus();
        return;
    }
    let validCif = await validateField("CIF", cif, "cif", "#userId", "USUARIO");
    if (!validCif) return;
    // CIF validación

    // Teléfono validación
    if (!phoneRegex.test(phone)) {
        $("#error-phone").text("El campo Teléfono no tiene un formato válido.");
        $("#phone").addClass('input-error').focus();
        return;
    }
    let validPhone = await validateField("Teléfono", phone, "phone", "#userId", "USUARIO");
    if (!validPhone) return;
    // Teléfono validación

    // Dirección validación
    if(address.length < 5 || address.length > 255) {
        $("#error-address").text("El campo Dirección debe tener entre 5 y 255 caracteres.");
        $("#address").addClass('input-error').focus();
        return;
    }
    if (!addressRegex.test(address)) {
        $("#error-address").text("El campo Dirección no tiene un formato válido.");
        $("#address").addClass('input-error').focus();
        return;
    }
    let validAddress = await validateField("Dirección", address, "address", "#userId", "USUARIO");
    if (!validAddress) return;
    // Dirección validación

    // Comunidad Autónoma y Provincia validación
    if(region == "") {
        $("#error-region").text("Debes seleccionar una Comunidad Autónoma.");
        $("#region").addClass('input-error').focus();
        return;
    }
    if(province == "") {
        $("#error-province").text("Debes seleccionar una Provincia.");
        $("#province").addClass('input-error').focus();
        return;
    }
    // Comunidad Autónoma y Provincia validación

    // Contraseña validación
    if($("#password").length > 0) {
        password = $("#password").val().trim();
        if(password.length < 8 || password.length > 20) {
            $("#error").text("El campo Contraseña debe tener entre 8 y 20 caracteres.");
            $("#password").addClass('input-error').focus();
            return;
        }
        if (!passwordRegex.test(password)) {
            $("#error").text("El campo Contraseña no tiene un formato válido.");
            $("#password").addClass('input-error').focus();
            return;
        }
    }
    // Contraseña validación

    // Subir Avatar
    if(file != "") {
        var fileExt = $("#avatar").val().split('.').pop().toLowerCase();
        if($.inArray(fileExt, ['png', 'jpg', 'jpeg']) == -1) {
            $("#error-avatar").text("El campo Avatar debe estar en formatos PNG, JPG o JPEG.");
            $("#avatar").addClass('input-error').focus();
            return;
        } else if ($("#avatar").get(0).files[0].size > 1000000) {
            $("#error-avatar").text("El campo Avatar no puede superar el 1MB.");
            $("#avatar").addClass('input-error').focus();
            return;
        } 
        await sleep(500);
    }
    // Subir Avatar

    // Aceptar términos y condiciones
    if($("#terms").length > 0 && !$("#terms").is(":checked")) {
        $("#error-terms").text("Debes aceptar los términos y condiciones.");
        return;
    }
    // Aceptar términos y condiciones

    $("#form-data-user").submit();
});
///////////////////////////////////////////////////////////////