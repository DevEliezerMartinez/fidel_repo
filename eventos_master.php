<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Gral</title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/eventos_Master.css">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>



    <aside>
        <?php include("./components/sidebar.php") ?>
    </aside>

    <main>
        <div class="main_header">
            <h3>Eventos</h3>
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

        <section class="principal_clase">
            <div class="visualizer"></div>
            <form class="form_generator" action="">
                <p>Mapa:</p>
                <div class="row">
                    <label for="Columnas">Columnas:</label>
                    <input type="number" name="number" id="columnas" max="20" min="1">
                    <label for="Filas">Filas:</label>
                    <input type="number" name="number" id="filas" max="20" min="1">
                </div>
                <button id="draw-rect">Dibujar Rectángulo</button> <!-- Botón para dibujar el rectángulo -->

                <p>Escenario</p>
                <div class="row">
                    <label for="escenarioCantidad">Cantidad:</label>
                    <input type="number" name="number" id="escenarioCantidad" max="2" min="1">
                </div>
                <div id="escenarioRows"></div>

                <p>Pista</p>
                <div class="row">
                    <label for="pistaCantidad">Cantidad:</label>
                    <input type="number" name="number" id="pistaCantidad">
                </div>
                <div id="pistaRows"></div>

                <p>Mesas</p>
                <div class="row">
                    <label for="mesasCantidad">Cantidad:</label>
                    <input type="number" name="number" id="mesasCantidad">
                </div>
                <div id="mesasRows"></div>

                <!-- Aquí es donde añadimos el Select dinámico de Sillas por Mesa -->
                <p for="sillasxmesa">Sillas x mesa</p>
                <select name="sillasxmesa" id="sillasxmesa">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </form>
        </section>




    </main>
    <script>
        // Función para dibujar el rectángulo basado en valores de columnas y filas
        function drawRectangle(x, y, width, height) {
            const rect = document.createElement('div');
            rect.classList.add('rect');
            const gridWidth = 100 / 20; // Hay 20 columnas
            const gridHeight = 100 / 20; // Hay 20 filas

            rect.style.left = `${(x - 1) * gridWidth}%`;
            rect.style.top = `${(y - 1) * gridHeight}%`;
            rect.style.width = `${width * gridWidth}%`;
            rect.style.height = `${height * gridHeight}%`;
            rect.style.zIndex = 10;
            document.querySelector('.visualizer').appendChild(rect);
        }

        // Función que se ejecuta al hacer clic en el botón "Dibujar Rectángulo"
        document.getElementById('draw-rect').addEventListener('click', function(event) {
            event.preventDefault();
            const columnas = parseInt(document.getElementById('columnas').value);
            const filas = parseInt(document.getElementById('filas').value);

            if (columnas > 0 && filas > 0 && columnas <= 20 && filas <= 20) {
                drawRectangle(1, 1, columnas, filas);
            } else {
                alert("Por favor, introduce valores válidos para columnas y filas.");
            }
        });
    </script>

    <script>
        // Función para generar filas dinámicas
        function generateRows(type, count, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            for (let i = 0; i < count; i++) {
                const row = document.createElement('div');
                row.classList.add('row_extra');
                row.innerHTML = `
                <div class="left">
                    <span>Posición</span>
                    <span>${type} ${i + 1}</span>
                </div>
                <label for="${type}_X_${i}">X:</label>
                <input type="number" id="${type}_X_${i}" name="${type}_X_${i}">
                <label for="${type}_Y_${i}">Y:</label>
                <input type="number" id="${type}_Y_${i}" name="${type}_Y_${i}">
                <button class="draw-scenario" data-index="${i}" data-type="${type}">Dibujar ${type}</button>
            `;
                container.appendChild(row);
            }

            const buttons = container.querySelectorAll('.draw-scenario');
            buttons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const index = this.getAttribute('data-index');
                    const x = parseInt(document.getElementById(`${type}_X_${index}`).value);
                    const y = parseInt(document.getElementById(`${type}_Y_${index}`).value);

                    if (x > 0 && y > 0) {
                        drawRectangle(x, y, 1, 1);
                    } else {
                        alert(`Por favor, introduce valores válidos para las coordenadas del ${type} ${index + 1}.`);
                    }
                });
            });
        }

        // Agregar listeners a los inputs de cantidad
        document.getElementById('escenarioCantidad').addEventListener('input', function() {
            const cantidad = parseInt(this.value);
            if (!isNaN(cantidad)) {
                generateRows('Escenario', cantidad, 'escenarioRows');
            }
        });

        document.getElementById('pistaCantidad').addEventListener('input', function() {
            const cantidad = parseInt(this.value);
            if (!isNaN(cantidad)) {
                generateRows('Pista', cantidad, 'pistaRows');
            }
        });

        document.getElementById('mesasCantidad').addEventListener('input', function() {
            const cantidad = parseInt(this.value);
            if (!isNaN(cantidad)) {
                generateRows('Mesas', cantidad, 'mesasRows');
            }
        });
    </script>

    <script>
        const visualizer = document.querySelector('.visualizer');

        // Crear la cuadrícula de 20x20
        for (let row = 0; row < 20; row++) {
            for (let col = 0; col < 20; col++) {
                const cell = document.createElement('div');
                cell.classList.add('cell');

                if (row === 0) {
                    cell.innerText = col;
                    cell.classList.add('axis-label');
                } else if (col === 0) {
                    cell.innerText = row;
                    cell.classList.add('axis-label');
                } else {
                    cell.innerText = '';
                }

                visualizer.appendChild(cell);
            }
        }
    </script>



    <script src="./assets/js/menu_options.js"></script>
    <script src="./assets/js/datepicker.js"></script>

    <!--   <script src="./assets/js/peticiones.js"></script> -->
</body>

</html>