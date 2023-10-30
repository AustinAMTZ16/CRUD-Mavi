document.addEventListener("DOMContentLoaded", function() {
    // Cargar registros al cargar la página
    cargarClientes();

    // Manejar el envío del formulario de agregar
    document.getElementById("addClienteForm").addEventListener("submit", function(e) {
        e.preventDefault();
        agregarCliente();
    });

    document.getElementById("editClienteForm").addEventListener("submit", function(e) {
        e.preventDefault();
        actualizarCliente();
    });

    document.getElementById("buscarClienteForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const idCliente = document.getElementById("idClienteBuscar");
        const idC = idCliente.value;
        leerCLiente(idC);
    });

    document.getElementById("LoginClienteForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const email = document.getElementById("email");
        const clave = document.getElementById("clave");
        const cemail = email.value;
        const cclave = clave.value;
        loginUsuario(cemail, cclave);
    });
});

function cargarClientes() {
    fetch('CRUDController.php')
        .then(response => response.json())
        .then(data => {
            const ClienteTable = document.getElementById("ClienteTable");
            ClienteTable.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos datos

            data.data.forEach(cliente => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${cliente.idCliente}</td>
                    <td>${cliente.nombreCliente}</td>
                    <td>${cliente.apellidoCliente}</td>
                    <td>${cliente.domicilioCliente}</td>
                    <td>${cliente.correoCliente}</td>
                    <td>
                        <button onclick="editarCliente('${cliente.idCliente}', '${cliente.nombreCliente}', '${cliente.apellidoCliente}', '${cliente.domicilioCliente}', '${cliente.correoCliente}')" style="background-color:dodgerblue; color: aliceblue;">Editar</button>
                        
                        <button onclick="eliminarCliente(${cliente.idCliente})" style="background-color:rgb(201, 19, 46); color: aliceblue;">Eliminar</button>
                    </td>
                `;
                ClienteTable.appendChild(row);
            });
        })
        .catch(error => console.error('Error al cargar libros:', error));
}

function agregarCliente() {
    const nombreCliente = document.getElementById("nombreCliente").value;
    const apellidoCliente = document.getElementById("apellidoCliente").value;
    const domicilioCliente = document.getElementById("domicilioCliente").value;
    const correoCliente = document.getElementById("correoCliente").value;

    const data = {
        nombreCliente: nombreCliente,
        apellidoCliente: apellidoCliente,
        domicilioCliente: domicilioCliente,
        correoCliente: correoCliente
    };

    fetch('CRUDController.php?action=crearCliente', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(result => {
            console.log(result.message);
            cargarClientes(); // Recargar la lista de libros después de agregar uno nuevo
        })
        .catch(error => console.error('Error al agregar libro:', error));
}

function actualizarCliente() {
    const idCliente = document.getElementById("eidCliente").value;
    const nombreCliente = document.getElementById("enombreCliente").value;
    const apellidoCliente = document.getElementById("eapellidoCliente").value;
    const domicilioCliente = document.getElementById("edomicilioCliente").value;
    const correoCliente = document.getElementById("ecorreoCliente").value;

    const data = {
        idCliente: idCliente,
        nombreCliente: nombreCliente,
        apellidoCliente: apellidoCliente,
        domicilioCliente: domicilioCliente,
        correoCliente: correoCliente
    };

    fetch('CRUDController.php', {
        method: 'PUT',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(result => {
        console.log(result.message);
        cargarClientes(); // Recargar la lista de libros después de actualizar uno
        // Obtén una referencia al formulario por su ID
        const formulario = document.getElementById("editClienteForm");
        // Oculta el formulario configurando su estilo a "none"
        formulario.style.display = "none";
    })
    .catch(error => console.error('Error al actualizar el libro:', error));
}

function eliminarCliente(idCliente) {
    const data = { idCliente: idCliente };

    fetch('CRUDController.php', {
        method: 'DELETE',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(result => {
        console.log(result.message);
        cargarClientes(); // Recargar la lista de libros después de eliminar uno
    })
    .catch(error => console.error('Error al eliminar el cliente:', error));
}

function leerCLiente(idCliente) {
    fetch(`CRUDController.php?idCliente=${idCliente}`) // Reemplaza 'crud.php' con la ruta correcta al servidor PHP que maneja la lectura de libros por ID
        .then(response => response.json())
        .then(cliente => {

            const ClienteId = document.getElementById("bidCliente");
            const ClienteNombre = document.getElementById("bnombreCliente");
            const ClienteApellido = document.getElementById("bapellidoCliente");
            const ClienteDomicilio = document.getElementById("bdomicilioCliente");
            const ClienteCorreo = document.getElementById("bcorreoCliente");

            ClienteId.textContent = cliente.idCliente;
            ClienteNombre.textContent = cliente.nombreCliente;
            ClienteApellido.textContent = cliente.apellidoCliente;
            ClienteDomicilio.textContent = cliente.domicilioCliente;
            ClienteCorreo.textContent = cliente.correoCliente;

            ClienteDetails.style.display = "block"; // Mostrar el div de detalles
        })
        .catch(error => console.error('Error al cargar los detalles del libro:', error));
}

function editarCliente(idCliente, nombreCliente, apellidoCliente, domicilioCliente, correoCliente) {
    // Obtén el elemento HTML donde deseas mostrar el valor
    const eidCliente = document.getElementById("eidCliente");
    const enombreCliente = document.getElementById("enombreCliente");
    const eapellidoCliente = document.getElementById("eapellidoCliente");
    const edomicilioCliente = document.getElementById("edomicilioCliente");
    const ecorreoCliente = document.getElementById("ecorreoCliente");
    // Establece el contenido del elemento con el valor deseado
    eidCliente.value = idCliente;
    enombreCliente.value = nombreCliente;
    eapellidoCliente.value = apellidoCliente;
    edomicilioCliente.value = domicilioCliente;
    ecorreoCliente.value = correoCliente;

    // Muestra el formulario de edición
    document.getElementById("editClienteForm").style.display = "block";
}

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
        window.location.href = 'index.html';
    })
    .catch(error => console.error('Error al iniciar sesión', error));

}