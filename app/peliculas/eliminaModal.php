<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eliminaModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" class="text-center">
                <!--  -->
                <div class="text-center">
                    ¿Desea eliminar el registro?
                </div>
                <!--  -->


                <div class="modal-footer text-center">

                    <form action="elimina.php" method="post">

                        <input type="hidden" name="id" id="id">

                        <md-outlined-button data-bs-dismiss="modal">
                            Cerrar
                        </md-outlined-button data-bs-dismiss="modal">

                        <md-filled-tonal-button type="submit">
                            Eliminar
                        </md-filled-tonal-button>

                    </form>

                </div>

                <!--  -->
            </div>
        </div>
    </div>
</div>