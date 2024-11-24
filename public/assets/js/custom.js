$(document).on("click", ".mostrar_confirmacion", function (event) {
    var form = $(this).closest("form");
    const swalWithBootstrapButtons = swal.mixin({
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-primary  me-2",
        },
        buttonsStyling: false,
    });
    swalWithBootstrapButtons
        .fire({
            title: "¿Esta seguro?",
            text: "Esta acción no se puede deshacer. ¿Quieres continuar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar Acción",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
});
