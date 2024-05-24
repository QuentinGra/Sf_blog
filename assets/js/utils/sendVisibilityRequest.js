export async function sendVisibilityRequest(url, input) {

    const response = await fetch(url);
    const data = await response.json();
    if (response.ok) {
        const card = input.closest('.blog-card');
        const label = input.nextElementSibling;

        if (data.enable) {
            card.classList.replace('border-danger', 'border-success');
            label.classList.replace('text-danger', 'text-success');
            label.innerText = 'Actif';
        } else {
            card.classList.replace('border-success', 'border-danger');
            label.classList.replace('text-success', 'text-danger');
            label.innerText = 'Inactif';
        }
    } else {
        if (document.querySelector('.alert.alert-danger')) {
            decodeURIComponent.querySelector('alert.alert-danger').remove();
        }

        const alert = document.createElement('div');
        alert.classList.add('alert', 'alert-danger');

        alert.innerText = data.message;

        document.querySelector('main').prepend(alert);
    }
}