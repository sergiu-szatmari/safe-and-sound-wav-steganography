setTimeout(() => {
    document.querySelectorAll('.btn').forEach(button => {
        button.classList.remove('hidden');
        button.classList.add('visible');
        button.style.animation = '2s show ease-in-out';
        button.addEventListener('animationend', () => {
            button.style.animation = '';
        });
    });
}, 2000);
