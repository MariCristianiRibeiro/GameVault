document.addEventListener("DOMContentLoaded", () => {
    const flashMessage = window.GameVaultFlash;

    if (flashMessage?.text) {
        Swal.fire({
            icon: flashMessage.type,
            text: flashMessage.text,
            timer: 2200,
            showConfirmButton: false,
            toast: true,
            position: "top-end",
        });
    }

    document.querySelectorAll("form[data-confirm]").forEach((form) => {
        form.addEventListener("submit", (event) => {
            event.preventDefault();

            Swal.fire({
                icon: "warning",
                title: form.dataset.confirm || "Confirmar exclusao?",
                text: form.dataset.confirmText || "Essa acao nao podera ser desfeita.",
                showCancelButton: true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Sim, continuar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
