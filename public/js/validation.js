// Validacija email-a
document.addEventListener('DOMContentLoaded', function() {
     const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const invalidInputs = form.querySelectorAll(':invalid');
            if (invalidInputs.length > 0) {
                e.preventDefault();
                const firstInvalid = invalidInputs[0];
                firstInvalid.reportValidity(); // Prikazuje browser poruku
                firstInvalid.focus();
            }
        });
        });
    // Email validacija
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.setCustomValidity('Unesite ispravnu email adresu');
        });
        input.addEventListener('input', function() {
            this.setCustomValidity('');
        });
    });

    // Password validacija (minimum 8 karaktera)
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        input.setAttribute('minlength', '8');
        input.addEventListener('invalid', function(e) {
            if (this.validity.tooShort) {
                e.preventDefault();
                this.setCustomValidity('Lozinka mora imati najmanje 8 karaktera');
            }
        });
        input.addEventListener('input', function() {
            this.setCustomValidity('');
        });
    });

    // Provera da li se lozinke poklapaju (registracija)
    const passwordConfirm = document.getElementById('password_confirmation');
    const password = document.getElementById('password');
    
    if (passwordConfirm && password) {
        passwordConfirm.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Lozinke se ne poklapaju');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validacija brojeva (cena)
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            if (this.validity.rangeUnderflow) {
                e.preventDefault();
                this.setCustomValidity('Vrednost mora biti veća od 0');
            }
        });
        input.addEventListener('input', function() {
            this.setCustomValidity('');
        });
    });

    // Validacija datuma (rezervacije)
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (startDate && endDate) {
        endDate.addEventListener('change', function() {
            if (startDate.value && endDate.value) {
                if (new Date(endDate.value) <= new Date(startDate.value)) {
                    this.setCustomValidity('Datum kraja mora biti posle datuma početka');
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    }
});
