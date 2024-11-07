<x-app-layout>
<div>
        <div class="main_header">
            <h3>Panorama Gral</h3>
            <img id="config" src="./assets/img/icons/config.png" alt="config">

            <div class="options_config">
                <span data-ubicacion="Palacio mundo imperial" href="" class="botton_option">
                    Palacio mundo imperial
                </span>
                <span data-ubicacion="Princess mundo imperial" href="" class="botton_option">
                    Princess mundo imperial
                </span>
                <span data-ubicacion="Todos" href="" class="botton_option">
                    Todos
                </span>

                <input type="hidden" name="ubicacion" id="ubicacion" value="Todos">

            </div>
        </div>


        <div class="options_conteiner">
            <div class="options date_start">
                <img src="./assets/img/icons/calendar.png" alt="calendar">

                <input type="text" id="date_start" placeholder="Fecha de inicio">
            </div>
            <div class="options date_end">
                <img src="./assets/img/icons/calendar.png" alt="calendar">
                <input type="text" id="date_end" placeholder="Fecha de fin">
            </div>
            <div class="options filter">
                <span>Filtrar</span>
            </div>
        </div>

        <section class="general_info">
            <div class="total_events  ">
                <p>Total de eventos</p>
                <div class="circle">0</div>
            </div>

            <div class="events_info">
                <div class="card_event_info">
                    <p>Capacidad total</p>
                    <div class="secondary_circles">0</div>
                </div>
                <div class="card_event_info">
                    <p>Asientos vendidos</p>
                    <div class="secondary_circles">0</div>
                </div>
                <div class="card_event_info">
                    <p>Asientos disponibles</p>
                    <div class="secondary_circles">0</div>
                </div>
            </div>
        </section>


        <section class="list_events">

        <p>Seleccione un periodo</p>

       
          <!--   <div class="event">
                <p id="name_event">Fiesta Mexicana</p>
                <p id="date">15 de septiembre</p>
                <p id="place">Salon consquistadores</p>
            </div> -->

        </section>
        <div class="leyends">
            <!-- <div class="label_info">
                <div class="bar blue"></div>
                <span>Palacio</span>
            </div>
            <div class="label_info">
                <div class="bar alternative_blue"></div>
                <span>Salon consquistadores</span>
            </div> -->
        </div>
    </main>
    <script src="{{ asset('assets/js/menu_options.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/peticiones.js') }}"></script>
   
</x-app-layout>