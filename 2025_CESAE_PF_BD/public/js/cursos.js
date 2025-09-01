//tempo post sucess
document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('successToast');
    if(toastEl){
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }
});
