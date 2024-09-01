<?php

session_start();

require("../config/database.php");


$sqlPeliculas = "SELECT p.id, p.nombre, p.descripcion, g.nombre AS genero FROM pelicula AS p
INNER JOIN genero AS g ON p.id_genero=g.id";
$peliculas = $conn->query($sqlPeliculas);

$dir = "posters/";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Modal</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script type="importmap">
        {
      "imports": {
        "@material/web/": "https://esm.run/@material/web/"
      }
    }
  </script>
    <script type="module">
        import '@material/web/all.js';
        import {
            styles as typescaleStyles
        } from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
    </script>
    <style>
        :root,
        body,
        .container.py-3 {
            background: #151b23 !important;
        }
    </style>
</head>

<body>

    <div class="container py-3">

        <h2 class="text-center text-white">Películas</h2>


        <hr>

        <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) {  ?>
            <div class="alert alert-<?= $_SESSION['color'];  ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg'];  ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
            unset($_SESSION['color']);
            unset($_SESSION['msg']);
        } ?>



        <div class="row justify-content-end">

            <div class="col-auto">
                <!-- <a href="" class="btn btn-primary" > -->
                <md-filled-button data-bs-toggle="modal" data-bs-target="#nuevoModal">
                    Nuevo registro
                </md-filled-button>
                <!-- </a> -->
            </div>

        </div>
        <div class="table-reponsive">

            <table class="table table-striped table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Género</th>
                        <th>Poster</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php while ($row = $peliculas->fetch_assoc()) { ?>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['nombre']; ?></td>
                            <td><?= $row['descripcion']; ?></td>
                            <td><?= $row['genero']; ?></td>
                            <td> <img src="<?= $dir . $row['id'] . '.jpg?n=' . time(); ?>" alt="" width="50px" height="70px"></td>
                            <td>
                                <md-outlined-button data-bs-toggle="modal" data-bs-target="#editaModal" style="color: #fff;" data-bs-id="<?= $row['id']; ?>">
                                    Editar
                                </md-outlined-button>
                                <md-filled-tonal-button data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row['id']; ?>">
                                    Eliminar
                                </md-filled-tonal-button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>



    </div>
    <!--  -->
    <?php
    $sqlGenero = "SELECT id, nombre FROM genero";
    $generos = $conn->query($sqlGenero);
    ?>
    <!--  -->
    <?php include('nuevoModal.php'); ?>

    <?php $generos->data_seek(0); ?>

    <?php include('editaModal.php'); ?>

    <?php include('eliminaModal.php'); ?>
    <!--  -->
    <script>
        let nuevoModal = document.getElementById("nuevoModal");
        let editaModal = document.getElementById("editaModal");
        let eliminaModal = document.getElementById("eliminaModal");

        nuevoModal.addEventListener("shown.bs.modal", event => {
            nuevoModal.querySelector(".modal-body #nombre").focus();
        });


        nuevoModal.addEventListener("hide.bs.modal", event => {
            nuevoModal.querySelector(".modal-body #nombre").value = "";
            nuevoModal.querySelector(".modal-body #descripcion").value = "";
            nuevoModal.querySelector(".modal-body #genero").value = "";
            nuevoModal.querySelector(".modal-body #poster").value = "";
        });

        editaModal.addEventListener("hide.bs.modal", event => {
            editaModal.querySelector(".modal-body #nombre").value = "";
            editaModal.querySelector(".modal-body #descripcion").value = "";
            editaModal.querySelector(".modal-body #genero").value = "";
            editaModal.querySelector(".modal-body #poster").value = "";
        });


        editaModal.addEventListener("shown.bs.modal", event => {
            let button = event.relatedTarget;
            let id = button.getAttribute("data-bs-id");

            let inputId = editaModal.querySelector(".modal-body #id");
            let inputNombre = editaModal.querySelector(".modal-body #nombre");
            let inputDescripcion = editaModal.querySelector(".modal-body #descripcion");
            let inputGenero = editaModal.querySelector(".modal-body #genero");
            let poster = editaModal.querySelector(".modal-body #img_poster");

            let url = "getPelicula.php";
            let formData = new FormData();
            formData.append("id", id);

            fetch(url, {
                    method: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {

                    inputId.value = data.id;
                    inputNombre.value = data.nombre;
                    inputDescripcion.value = data.descripcion;
                    inputGenero.value = data.id_genero;
                    poster.src = '<?= $dir ?>' + data.id + '.jpg';

                }).catch(err => console.log(err))

        });

        eliminaModal.addEventListener("shown.bs.modal", event => {
            let button = event.relatedTarget;
            let id = button.getAttribute("data-bs-id");
            eliminaModal.querySelector(".modal-footer #id").value = id;

        });
    </script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--  -->
</body>

</html>