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
                    <label for="Columnas">Columnas: X</label>
                    <input type="number" name="number" id="columnas" max="20" min="1">
                    <label for="Filas">Filas: Y</label>
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

                <div class="cantidad_sillas_container">
                    <span>Cantidad: </span>
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
                </div>

                <p for="">Detalles de venta:</p>
                <div class="precios">
                    <span>Precio silla adulto $</span>
                    <input type="number" name="precioAdulto" id="precioAdulto">
                </div>

                <div class="precios">
                    <span>Precio silla menor $</span>
                    <input type="number" name="precioMenor" id="precioMenor">
                </div>


                <input class="submitPrincipal" id="save" type="submit" value="Guardar cambios">


            </form>
        </section>




    </main>
<script>
    // Función para dibujar el rectángulo basado en valores de columnas y filas
    function drawRectangle(x, y, width, height, label = '', type = '') {
        console.log("type recibido", type);
        console.log("valores x,y", x," ",y)
        const rect = document.createElement('div');
        rect.classList.add('rect');
        const gridWidth = 100 / 21; // Cambiado a 21 columnas
        const gridHeight = 100 / 21; // Cambiado a 21 filas

        rect.style.left = `${x * gridWidth}%`; // Usar x directamente
        rect.style.top = `${y * gridHeight}%`; // Usar y directamente
        rect.style.width = `${width * gridWidth}%`;
        rect.style.height = `${height * gridHeight}%`;
        rect.style.zIndex = 10;
        rect.style.textAlign = "center";

        // Si el tipo es "Mesas", hacer que el rectángulo sea circular
        if (type === 'Mesas') {
            rect.style.borderRadius = '100%'; // Hacer el elemento circular
        }

        // Añadir el texto al rectángulo
        rect.innerText = label;

        // Añadir el rectángulo a la visualización
        document.querySelector('.visualizer').appendChild(rect);
    }

    // Función que se ejecuta al hacer clic en el botón "Dibujar Rectángulo"
    document.getElementById('draw-rect').addEventListener('click', function(event) {
        event.preventDefault();
        const columnas = parseInt(document.getElementById('columnas').value);
        const filas = parseInt(document.getElementById('filas').value);

        if (columnas > 0 && filas > 0 && columnas <= 21 && filas <= 21) { // Cambiado a 21
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
                console.log("click para dibujar escenario")
                event.preventDefault();
                const index = this.getAttribute('data-index');
                console.log("index", index)
                const x = parseInt(document.getElementById(`${type}_X_${index}`).value);
                const y = parseInt(document.getElementById(`${type}_Y_${index}`).value);

                if (x > 0 && y > 0) {
                    const label = `${type.charAt(0)}${parseInt(index) + 1}`; // Concatena la letra en minúscula y el número sin ceros adicionales

                    drawRectangle(x, y, 1, 1, label, type);
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

    // Crear la cuadrícula de 21x21
    for (let row = 0; row < 21; row++) { // Cambiado a 21
        for (let col = 0; col < 21; col++) { // Cambiado a 21
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

    // Selecciona el botón por su ID y agrega el event listener
    document.getElementById('save').addEventListener('click', function(event) {
        event.preventDefault(); // Evita el envío del formulario, si aplica
        saveConfiguration(); // Llama a la función para guardar la configuración
        console.log("Configuración guardada"); // Mensaje opcional para confirmar
    });

    function saveConfiguration() {
        // Obtener todos los elementos renderizados en el contenedor `.visualizer`
        const elements = document.querySelectorAll('.visualizer .rect');
        const config = [];

        elements.forEach(element => {
            const itemConfig = {
                x: parseFloat(element.style.left) / (100 / 21) + 1, // Cambiado a 21
                y: parseFloat(element.style.top) / (100 / 21) + 1, // Cambiado a 21
                width: parseFloat(element.style.width) / (100 / 21), // Cambiado a 21
                height: parseFloat(element.style.height) / (100 / 21), // Cambiado a 21
                label: element.innerText,
                type: element.classList.contains('circle') ? 'Mesas' : 'Other', // Determina el tipo basado en el estilo
                styles: {
                    borderRadius: element.style.borderRadius,
                    textAlign: element.style.textAlign,
                    zIndex: element.style.zIndex
                }
            };
            config.push(itemConfig);
        });

        // Guardar configuración en localStorage (o enviarla a un servidor si es necesario)
        localStorage.setItem('visualizerConfig', JSON.stringify(config));
        //window.location.href = "adminEventos.php";
    }
</script>





    <script src="./assets/js/menu_options.js"></script>
    <script src="./assets/js/datepicker.js"></script>

    <!--   <script src="./assets/js/peticiones.js"></script> -->
</body>

</html>