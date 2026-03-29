document.addEventListener('DOMContentLoaded', function() {

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
        password.addEventListener('input', function() {
            if (passwordConfirm.value && this.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Lozinke se ne poklapaju');
            } else {
                passwordConfirm.setCustomValidity('');
            }
        });
    }

    // Validacija datuma (rezervacije)
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    if (startDate && endDate) {
        endDate.addEventListener('change', function() {
            if (startDate.value && endDate.value) {
                if (new Date(endDate.value) <= new Date(startDate.value)) {
                    this.setCustomValidity('Datum kraja mora biti posle datuma pocetka');
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    }

});