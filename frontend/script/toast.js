
export function showToast(message, type = 'success') {
    const toastBox = document.getElementById('toastBox') || createToastBox();

    const toast = document.createElement('div');
    toast.classList.add('toast', type);

    toast.innerHTML = `
        <i class="fa-solid ${getIcon(type)}"></i>
        <span>${message}</span>
    `;

    toastBox.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 4000);
}

function getIcon(type) {
    switch(type) {
        case 'success': return 'fa-circle-check';
        case 'error': return 'fa-circle-xmark';
        case 'warning': return 'fa-circle-exclamation';
        default: return 'fa-circle-info';
    }
}

function createToastBox() {
    const box = document.createElement('div');
    box.id = 'toastBox';
    document.body.appendChild(box);
    return box;
}
