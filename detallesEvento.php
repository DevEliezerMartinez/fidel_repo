<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles evento </title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/eventos_Master.css">
    <link rel="stylesheet" href="./assets/css/detallesEvento.css">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>



    <aside>
        <?php include("./components/sidebar.php") ?>
    </aside>

    <main>
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




    </main>

    <script src="./assets/js/menu_options.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Verificar si visualizerConfig existe en localStorage
            const visualizerConfig = localStorage.getItem("visualizerConfig");

            // Obtener elementos de la interfaz
            const noInfoSection = document.querySelector('.no_info');
            const infoSection = document.querySelector('.info');

            if (visualizerConfig) {
                // Si visualizerConfig existe, muestra la sección .info y oculta .no_info
                noInfoSection.style.display = 'none';
                infoSection.style.display = 'block';

                // Cargar y renderizar la configuración almacenada
                const configData = JSON.parse(visualizerConfig);
                renderConfig(configData); // Llama a una función que use la configuración para renderizar
            } else {
                // Si visualizerConfig no existe, muestra la sección .no_info y oculta .info
                noInfoSection.style.display = 'block';
                infoSection.style.display = 'none';
            }
        });

       // Función para renderizar los elementos en sus posiciones guardadas
function renderConfig(configData) {
    const groupedElements = {};

    // Agrupar elementos que empiezan con la misma letra (excepto 'm')
    configData.forEach((item) => {
        const firstChar = item.label.charAt(0).toLowerCase(); // Obtener la primera letra

         // Verificar si el label es vacío o no existe
         if (!item.label || item.label.trim() === '') {
            return; // No renderizar si el label está vacío
        }

        // Si es un elemento que empieza con 'm', dibujarlo individualmente
        if (firstChar === 'm') {
            drawRectangle(item.x, item.y, item.width, item.height, item.label, 'individual');
        } else {
            // Si el grupo no existe, crear uno nuevo
            if (!groupedElements[firstChar]) {
                groupedElements[firstChar] = [];
            }
            // Agregar el elemento al grupo correspondiente
            groupedElements[firstChar].push(item);
        }
    });

    // Dibujar cada grupo de elementos (solo letras que no son 'm')
    for (const char in groupedElements) {
        // Obtener el primer elemento del grupo
        const firstItem = groupedElements[char][0];

        // Calcular las dimensiones y posición de la fusión
        const width = groupedElements[char].reduce((total, item) => total + item.width, 0);
        const height = Math.max(...groupedElements[char].map(item => item.height));
        const x = firstItem.x; // La posición x del primer elemento
        const y = firstItem.y; // La posición y del primer elemento

        // Definir el label basado en la inicial
        let displayLabel;
        switch (char) {
            case 'e':
                displayLabel = 'esc';
                break;
            case 'p':
                displayLabel = 'pista';
                break;
            default:
                displayLabel = char; // Por defecto muestra la letra
        }

        // Dibujar el rectángulo agrupado
        drawRectangle(x, y, width, height, displayLabel, 'grouped');
    }
}

// Modificar la función drawRectangle para manejar el label redondo
function drawRectangle(x, y, width, height, label, type) {
    const rectangle = document.createElement('div');

    // Ajusta el tamaño de la cuadrícula
    const cellSize = 30; // Tamaño de cada celda

    // Establecer estilos CSS para posicionar el rectángulo
    rectangle.style.position = 'absolute';
    rectangle.style.left = `${x * cellSize}px`;
    rectangle.style.top = `${y * cellSize}px`;
    rectangle.style.width = `${width * cellSize}px`;
    rectangle.style.height = `${height * cellSize}px`;

    // Verificar si el label es un elemento individual (tipo 'm') para hacerlo redondo
    if (type === 'individual') {
        rectangle.style.borderRadius = '50%'; // Hacerlo redondo
        rectangle.style.backgroundColor = 'rgba(255, 0, 0, 0.5)'; // Color diferente para distinguir
    } else {
        rectangle.style.backgroundColor = 'rgba(0, 0, 255, 0.5)'; // Color del rectángulo agrupado
    }

    rectangle.innerText = label; // Agregar texto al rectángulo
    rectangle.classList.add('rectangle'); // Clase opcional para estilos

    // Agregar el evento de clic solo a los elementos de mesa
    if (type === 'individual') {
        rectangle.addEventListener('click', function() {
            alert(`Mesa seleccionada: ${label}`); // Acción al hacer clic
            window.location.href = "reservacionEvento.php";
        });
    }

    // Agregar el rectángulo a la sección de información
    document.querySelector('.info').appendChild(rectangle);
}

    </script>

</body>

</html>