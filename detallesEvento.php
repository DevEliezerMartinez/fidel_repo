<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles evento </title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
    <link rel="stylesheet" href="./assets/css/main.css">
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


    </main>

    <script src="./assets/js/menu_options.js"></script>

</body>

</html>