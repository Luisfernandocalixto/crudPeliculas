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
</head>

<body>

    <div class="container py-3">

        <h2 class="text-center">Peliculas</h2>

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
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal">
                    <svg fill="#fff" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                        <path d="M256,0C114.6,0,0,114.6,0,256s114.6,256,256,256s256-114.6,256-256S397.4,0,256,0z M405.3,277.3c0,11.8-9.5,21.3-21.3,21.3
                h-85.3V384c0,11.8-9.5,21.3-21.3,21.3h-42.7c-11.8,0-21.3-9.6-21.3-21.3v-85.3H128c-11.8,0-21.3-9.6-21.3-21.3v-42.7
                c0-11.8,9.5-21.3,21.3-21.3h85.3V128c0-11.8,9.5-21.3,21.3-21.3h42.7c11.8,0,21.3,9.6,21.3,21.3v85.3H384c11.8,0,21.3,9.6,21.3,21.3
                V277.3z" />
                    </svg>
                    Nuevo registro
                </a>
            </div>

        </div>

        <table class="table table-sm table-striped table-hover mt-4">

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
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" style="color: #fff;" data-bs-id="<?= $row['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Editar
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row['id']; ?>">
                                <svg fill="#fff" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z" />
                                </svg>
                                Eliminar
                            </a>
                        </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>



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