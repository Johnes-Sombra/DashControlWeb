const ConfirmDialog = {
    show(message, onConfirm, onCancel) {
        const dialog = document.createElement('div');
        dialog.className = 'confirm-dialog';
        dialog.innerHTML = `
            <div class="confirm-dialog-content">
                <p>${message}</p>
                <div class="confirm-dialog-buttons">
                    <button class="btn-confirm">Confirmar</button>
                    <button class="btn-cancel">Cancelar</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(dialog);
        
        dialog.querySelector('.btn-confirm').onclick = () => {
            onConfirm?.();
            dialog.remove();
        };
        
        dialog.querySelector('.btn-cancel').onclick = () => {
            onCancel?.();
            dialog.remove();
        };
    }
};