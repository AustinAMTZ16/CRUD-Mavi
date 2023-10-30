document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("LoginClienteForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const email = document.getElementById("email");
        const clave = document.getElementById("clave");
        const cemail = email.value;
        const cclave = clave.value;
        loginUsuario(cemail, cclave);
    });
});

function loginUsuario(email, clave){
    const data = { correoCliente: email, claveCliente: clave};

    fetch('CRUDController.php?action=login', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(result => {
        console.log(result.message);
        // Redireccionar a la página deseada en caso de éxito
        if (result.message === 'Inicio de sesion exitosamente.') {
            // Redireccionar a la página deseada en caso de éxito
            window.location.href = 'crud.html';
        } else {
            console.log(result.message); // Mostrar un mensaje de error en caso de fallo
        }
    })
    .catch(error => console.error('Error al iniciar sesión', error));

}