<?php 
    include_once './Database.php';
    include_once './ClienteMode.php';

    // Realiza la conexión a la base de datos
    $database = new Database();
    $db = $database->conectar();

    // Inicializa el objeto Book
    $cliente = new Cliente($db);

    // Manejar solicitudes AJAX para CRUD
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['idCliente'])) {
            // Muestra los detalles de un cliente específico
            $cliente->idCliente = $_GET['idCliente'];
            $cliente->leerCliente();
            echo json_encode($cliente);
        }else{
            // Muestra una lista de todos los clientes
            $stmt = $cliente->leerClientes();
            $num = $stmt->rowCount();
            if ($num > 0) {
                $clientes_arr = array();
                $clientes_arr_arr['data'] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $clientes_arr_item = array(
                        'idCliente' => $idCliente,
                        'nombreCliente' => $nombreCliente,
                        'apellidoCliente' => $apellidoCliente,
                        'domicilioCliente' => $domicilioCliente,
                        'correoCliente' => $correoCliente
                    );
                    array_push($clientes_arr_arr['data'], $clientes_arr_item);
                }

                echo json_encode($clientes_arr_arr);
            } else {
                echo json_encode(array('message' => 'No se encontraron clientes.'));
            }
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $data = json_decode(file_get_contents("php://input"));
            
            if ($action === 'crearCliente') {
                $cliente->nombreCliente = $data->nombreCliente;
                $cliente->apellidoCliente = $data->apellidoCliente;
                $cliente->domicilioCliente = $data->domicilioCliente;
                $cliente->correoCliente = $data->correoCliente;
                // Crear un nuevo cliente
                $result = $cliente->crearCliente();
                if ($result) {
                    echo json_encode(array('message' => 'Cliente creado exitosamente.'));
                } else {
                    echo json_encode(array('message' => 'Error al crear el cliente.'));
                }

            }elseif($action === 'login'){

                $cliente->correoCliente = $data->correoCliente;
                $cliente->claveCliente = $data->claveCliente;

                $result = $cliente->loginUsuario($data->correoCliente, $data->claveCliente);
                if ($result) {
                    echo json_encode(array('message' => 'Inicio de sesion exitosamente.'));
                } else {
                    echo json_encode(array('message' => 'Error al inicio de sesion.'));
                }
            }
            else {
                // Manejar otros casos
                echo json_encode(array('message' => 'Acción POST desconocida.'));
            }
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input"));
        $cliente->idCliente = $data->idCliente;
        $cliente->nombreCliente = $data->nombreCliente;
        $cliente->apellidoCliente = $data->apellidoCliente;
        $cliente->domicilioCliente = $data->domicilioCliente;
        $cliente->correoCliente = $data->correoCliente;

        if ($cliente->actualizarCliente()) {
            echo json_encode(array('message' => 'Cliente actualizado exitosamente.'));
        } else {
            echo json_encode(array('message' => 'Error al actualizar el cliente.'));
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"));
        $cliente->idCliente = $data->idCliente;

        if ($cliente->eliminarCliente()) {
            echo json_encode(array('message' => 'Cliente eliminado exitosamente.'));
        } else {
            echo json_encode(array('message' => 'Error al eliminar el cliente.'));
        }
    }
    else {
        echo json_encode(array('message' => 'Solicitud no válida.'));
    }
?>