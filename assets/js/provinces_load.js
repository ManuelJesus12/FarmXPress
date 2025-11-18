var array = fetch('../assets/js/provinces_list.json')
    .then(response => response.json())
    .then(data => {

        //CARGAR COMUNIDADES AUTÓNOMAS
        const region = document.getElementById('region');
        Object.keys(data).forEach(comunidad => {
            const option = document.createElement('option');
            option.value = comunidad;
            option.textContent = comunidad;
            if(typeof currentRegion != 'undefined' && currentRegion == comunidad) option.selected = true;
            region.appendChild(option);
        });
        //CARGAR COMUNIDADES AUTÓNOMAS

        //CARGAR PROVINCIAS SEGÚN COMUNIDAD AUTÓNOMA
        $('#region').on('change', function() {
            const provinceSelect = $('#province');
            provinceSelect.empty().append('<option value="">Seleccione</option>');

            if(this.value === "") provinceSelect.prop('disabled', true);
            else{
                const province = document.getElementById('province');
                Object.values(data[this.value]).forEach(provincia => {
                    const option = document.createElement('option');
                    option.value = provincia;
                    option.textContent = provincia;
                    if(typeof currentProvince != 'undefined' && currentProvince == provincia) option.selected = true;
                    province.appendChild(option);
                });
                provinceSelect.prop('disabled', false);
            }
        });
        $('#region').trigger('change');
        //CARGAR PROVINCIAS SEGÚN COMUNIDAD AUTÓNOMA
    });


