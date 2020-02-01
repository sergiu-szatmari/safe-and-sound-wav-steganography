document.querySelectorAll('.btn').forEach(button => {

    const filename = button.value;

    button.addEventListener('mouseover', () => {
        button.value = '';
        button.value = 'Download';
        button.classList.add('btn-success');
        button.classList.remove('btn-default');
    });

    button.addEventListener('mouseout', () => {
        button.value = '';
        button.value = filename;
        button.classList.add('btn-default');
        button.classList.remove('btn-success');
    });

    button.addEventListener('click', () => {
        button.value = 'Please wait . . .';
        setTimeout(() => {
            button.value = '';
            button.value = filename;
            button.classList.add('btn-default');
            button.classList.remove('btn-success');
        }, 3000);
    });
});
