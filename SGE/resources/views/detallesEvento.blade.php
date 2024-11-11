<x-app-layout>
    <div class="main_header">
        <h3>Panorama Gral</h3>
        <img id="config" src="./assets/img/icons/config.png" alt="config">

        <div class="options_config">
            <a href="" class="botton_option">
                Palacio mundo imperial
            </a>
            <a href="" class="botton_option">
                Princess mundo imperial
            </a>

        </div>
    </div>


    <div class="no_info">
        <img src="./assets/img/icons/alert.png" alt="alert">
        <p>Informacion no disponible</p>
        <span>El evento no tiene informacion para su reservacion</span>

        <a href="./panorama_gral.php">Regresar</a>
    </div>

    <form class="basic_info">

        <div class="sideform">

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"></textarea>
        </div>

        <div class="right_form">

            <div class="options_conteiner">
                <label for="fecha">Fecha</label>
                <div class="options date_start">
                    <img src="./assets/img/icons/calendar.png" alt="calendar">

                    <input type="text" id="date_start" placeholder="Fecha de inicio">
                </div>
                <div class="options date_end">
                    <img src="./assets/img/icons/calendar.png" alt="calendar">
                    <input type="text" id="date_end" placeholder="Fecha de fin">
                </div>

            </div>

            <div class="lugar">

                <label for="Lugar">Lugar:</label>
                <select name="Lugar" id="Lugar">
                    <option value="Place">place1</option>
                    <option value="Place3">place2</option>
                    <option value="PlacE2">place3</option>
                </select>
            </div>
        </div>






    </form>
    <div class="infomesas">
        <p>Mesas vendidas</p>
        <span class="info_mesa vendidas">0</span>
        <p>Mesas disponibles</p>
        <span class="info_mesa disponibles">10</span>
    </div>


    <div class="details">

        <div class="info"></div>


        <div class="info_details">
            <div class="element">
                <p>Capacidad total <span id="capacidad">100</span> </p>
            </div>
            <div class="element">6
                <p>Asientos vendidos total <span id="vendidos">16</span> </p>
            </div>
            <div class="element">
                <p>Asientos disponibles <span id="disponibles">84</span> </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
</x-app-layout>
