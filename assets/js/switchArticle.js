document.querySelectorAll('input[data-switch-article-id]')
    .forEach(input => {
        input.addEventListener('change', async (e) => {
            const id = e.currentTarget.dataset.switchArticleId;

            const response = await fetch(`/admin/articles/${id}/switch`);

            if (response.ok) {
                const data = await response.json();
                const card = e.target.closest('.card');

                if (data.enable) {
                    card.classList.replace('border-danger', 'border-success');
                } else {
                    card.classList.replace('border-success', 'border-danger');
                }
            }
        });
    });