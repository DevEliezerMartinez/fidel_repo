<x-app-layout>
    <div class="main_header">
        <h3>Ticket Gral</h3>
    </div>

    <div class="ticket">
        <div class="card_ticket">
            <div class="card_header">
            <img src="{{ asset('assets/img/Logos/logo_color.png') }}" alt="">
            <div class="number_ticket">#{{ $reservation->id }}</div> <!-- Número de ticket -->
            </div>

            <div class="card_body">
                <h3>{{ $reservation->event->name }}</h3> <!-- Nombre del evento -->

                <div class="row_ticket">
                    <p>Descripcion:</p>
                    <span>{{ $reservation->event->descripcion }}</span> <!-- Descripción del evento -->
                </div>

                <div class="row_ticket">
                    <p>Fecha evento:</p>
                    <span>{{ \Carbon\Carbon::parse($reservation->event->event_date)->format('Y-m-d') }}</span> <!-- Fecha del evento -->
                </div>

                <div class="row_ticket">
                    <p>Propiedad:</p>
                    <span>{{ $reservation->event->space->name }}</span> <!-- Propiedad (lugar) -->
                </div>

                <div class="row_ticket">
                    <p>Lugar:</p>
                    <span>{{ $reservation->table->table_number }}</span> <!-- Número de mesa -->
                </div>

                <h3>Detalles de la reservacion</h3>

                <div class="row_ticket">
                    <p>Nombre reservacion:</p>
                    <span>{{ $reservation->name }}</span> <!-- Nombre de la persona que hizo la reserva -->
                </div>

                <div class="row_ticket">
                    <p>Fecha reservacion</p>
                    <span>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}</span> <!-- Fecha de la reserva -->
                </div>

                <div class="row_ticket">
                    <p>Asientos reservados:</p>
                    <span>{{ $reservation->seats_reserved }}</span> <!-- Número de asientos reservados -->
                </div>

                <!-- Desglose de los asientos reservados -->
                <h3>Desglose del total</h3>
                <div class="row_ticket">
                    <p>Adultos:</p>
                    <span>{{ $adultos }} x {{ $event->precioAdulto }} = {{ $event->precioAdulto * $adultos }}</span>
                </div>
                <div class="row_ticket">
                    <p>Infantes:</p>
                    <span>{{ $infantes }} x {{ $event->precioInfante }} = {{ $event->precioInfante * $infantes }}</span>
                </div>
                <div class="row_ticket">
                    <p>Menores:</p>
                    <span>{{ $menores }} x {{ $event->precioMenor }} = {{ $event->precioMenor * $menores }}</span>
                </div>

                <div class="row_ticket">
                    <p>Total:</p>
                    <span>{{ number_format($total, 2, '.', ',') }} MXN</span> <!-- Total calculado con formato moneda -->

                  
                </div>

            </div>
        </div>

        <div class="download_ticket submit_button">
            Descargar
        </div>
    </div>

</x-app-layout>