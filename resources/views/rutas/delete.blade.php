<!-- Modal Eliminar -->
<div class="modal fade" id="delete{{ $ruta->id_ruta }}" tabindex="-1" aria-labelledby="deleteLabel{{ $ruta->id_ruta }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteLabel{{ $ruta->id_ruta }}">Eliminar Ruta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro que deseas eliminar la ruta <strong>{{ $ruta->nombre_ruta }}</strong>? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                <!-- Formulario DELETE -->
                <form action="{{ route('rutas.destroy', $ruta->id_ruta) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
