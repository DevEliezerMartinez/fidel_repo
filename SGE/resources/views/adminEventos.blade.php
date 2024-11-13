<x-app-layout>
   
    <p>admin eventos</p>
    <script>
        function setUbicacion(ubicacion) {
            document.getElementById('ubicacion').value = ubicacion;
            // Actualizar la clase activa
            document.querySelectorAll('.botton_option').forEach(function(element) {
                element.classList.remove('active');
            });
            document.getElementById('ubicacion-' + ubicacion.replace(/\s+/g, '-').toLowerCase()).classList.add('active');
        }
    </script>

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/peticiones.js') }}"></script>
</x-app-layout>
