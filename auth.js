document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    
    // Aquí debes validar las credenciales (esto es solo un ejemplo)
    var validUsername = "usuario";
    var validPassword = "contrasena";
    
    if (username === validUsername && password === validPassword) {
        window.location.href = 'pagina_inicio.html';
    } else {
        document.getElementById('errorMessage').textContent = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
});
