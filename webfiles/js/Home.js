const hideIdx       = 1;
const extractIdx    = 2;
const selectElement = document.querySelector('select');
const messageInput  = document.querySelector('#upload-form-message');

selectElement.addEventListener('change', () => {

    switch (selectElement.selectedIndex) {
        case hideIdx:
            messageInput.required = true;
            break;

        case extractIdx:
            messageInput.required = false;
            break;
    }
});
