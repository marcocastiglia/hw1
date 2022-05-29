function checkEmail(email) {
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(email).toLowerCase())) {
        const p = document.querySelector('#center .errore');
        p.textContent = 'Email non valida.';
        return 0;
    } else {
        return 1;
    }
}

function checkUsername(username) {
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(username)) {
        const p = document.querySelector('#center .errore');
        p.textContent = 'Username non valido.';
        return 0;
    } else {
        return 1;
    }    
}

function checkPassword() {
    if(form.password.value.length <= 8) {
        const p = document.querySelector('#center .errore');
        p.textContent = 'La password non ha una lunghezza sufficiente.';
        return 0;
    } else if(/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]$/.test(form.password.value)) {
        const p = document.querySelector('#center .errore');
        p.textContent = 'La password non contiene tutti i caratteri speciali richiesti.';
        return 0;
    } else {
        return 1;
    }
}


function check(event) {
    if(form.name.value.length > 0 &&
        form.surname.value.length > 0 &&
        checkEmail(form.email.value) &&
        form.email.value.length > 0 &&
        checkUsername(form.username.value) &&
        form.username.value.length > 0 &&
        checkPassword()) {

            const p = document.querySelector('#center .errore');
            p.textContent = 'Registrazione andata a buon fine.';
            p.classList.remove('errore');

            console.log('Signup success.')           
    }
    else if(form.name.value.length === 0 ||
        form.surname.value.length === 0 ||
        form.email.value.length === 0 ||
        form.username.value.length === 0 ||
        form.password.value.length === 0){
        const p = document.querySelector('#center .errore');
            p.textContent = 'Completa il form.';

            console.log('Siamo entrati.')
            event.preventDefault();
    }
    else {
        event.preventDefault();
    }
}

const form = document.forms['signup_form'];
form.addEventListener('submit', check);