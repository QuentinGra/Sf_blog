document.querySelectorAll('input[data-switch-article-id]')
    .forEach(input => {
        input.addEventListener('change', async (e) => {
            const id = e.currentTarget.dataset.switchArticleId;

            const response = await fetch(`/admin/articles/${id}/switch`);
            const data = await response.json();

            if (response.ok) {
                const card = e.target.closest('.card');
                const label = e.target.nextElementSibling;

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
        });
    });