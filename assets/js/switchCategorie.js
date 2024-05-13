import { sendVisibilityRequest } from "./utils/sendVisibilityRequest";
document.querySelectorAll('input[data-switch-categorie-id]')
    .forEach(input => {
        input.addEventListener('change', async (e) => {
            const id = e.currentTarget.dataset.switchCategorieId;
            sendVisibilityRequest(`/admin/categories/${id}/switch`, e.target);
        });
    });