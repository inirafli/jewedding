function showAlert(type, title, text, redirectUrl, confirmButtonText) {
    Swal.fire({
        icon: type,
        title: title,
        text: text,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed && redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

function showConfirmationAlert(title, text, confirmButtonText, cancelButtonText, onConfirm) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirm();
        }
    });
}

function showRetryAlert(type, title, text, confirmButtonText) {
    Swal.fire({
        icon: type,
        title: title,
        text: text,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.back();
        }
    });
}

function confirmLogout() {
    showConfirmationAlert(
        'Keluar dari Akun',
        'Apakah kamu yakin ingin keluar dari Akun?',
        'Iya',
        'Tidak',
        function() {
            window.location.href = '/jewedding/logout.php';
        }
    );
}
