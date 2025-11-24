// Regex pour validation

const passwordRegex = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?~]).{8,32}$/;

// Validation en temps réel
document.getElementById('keyPassword').addEventListener('input', function (e) {
    const password = e.target.value;
    console.log(password);
    const errorDiv = document.getElementById('passwordError');
    const validDiv = document.getElementById('passwordSuccess');


    if (passwordRegex.test(password)) {
        errorDiv.style.display = 'none';
        validDiv.style.display = 'block';
    } else {
        errorDiv.style.display = 'block';
    
    }
});

// Validation à la soumission
document.getElementById('passwordForm').addEventListener('click', function (e) {
    const password = document.getElementById('keyPassword').value;

    if (!passwordRegex.test(password)) {
        e.preventDefault();
        alert('Veuillez corriger votre mot de passe.');

    }
});

