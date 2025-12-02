<?php
// api.php - Manejador principal de la API REST

// --- Encabezados para CORS y formato JSON ---
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Manejar la solicitud pre-vuelo (preflight) de CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204); // No Content
    exit();
}

// --- Incluir el archivo de conexión a la BD ---
require_once 'db.php';

// --- Lógica para enrutar la solicitud ---
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($method) {
    case 'GET':
        handleGet($conn, $id);
        break;
    case 'POST':
        handlePost($conn);
        break;
    case 'PUT':
        handlePut($conn, $id);
        break;
    case 'DELETE':
        handleDelete($conn, $id);
        break;
    default:
        http_response_code(405); // Método no permitido
        echo json_encode(['message' => 'Método no permitido']);
        break;
}

// --- Funciones manejadoras para cada método HTTP ---

function handleGet($conn, $id) {
    if ($id) {
        // Obtener una sola nota
        $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode($result->fetch_assoc());
        } else {
            http_response_code(404); // No encontrado
            echo json_encode(['message' => 'Nota no encontrada']);
        }
        $stmt->close();
    } else {
        // Obtener todas las notas
        $result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
        $notes = [];
        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
        echo json_encode($notes);
    }
}

function handlePost($conn) {
    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->title) || empty($data->author)) {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(['message' => 'El título y el autor son obligatorios']);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO notes (title, author, body, classification) VALUES (?, ?, ?, ?)");
    $stmt->bind_param(
        "ssss",
        $data->title,
        $data->author,
        $data->body,
        $data->classification
    );

    if ($stmt->execute()) {
        http_response_code(201); // Creado
        echo json_encode(['message' => 'Nota creada exitosamente', 'id' => $conn->insert_id]);
    } else {
        http_response_code(500); // Error del servidor
        echo json_encode(['message' => 'Error al crear la nota']);
    }
    $stmt->close();
}

function handlePut($conn, $id) {
    if (!$id) {
        http_response_code(400);
        echo json_encode(['message' => 'ID de nota no proporcionado']);
        return;
    }

    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->title) || empty($data->author)) {
        http_response_code(400);
        echo json_encode(['message' => 'El título y el autor son obligatorios']);
        return;
    }

    $stmt = $conn->prepare("UPDATE notes SET title = ?, author = ?, body = ?, classification = ? WHERE id = ?");
    $stmt->bind_param(
        "ssssi",
        $data->title,
        $data->author,
        $data->body,
        $data->classification,
        $id
    );

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['message' => 'Nota actualizada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Nota no encontrada o sin cambios']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error al actualizar la nota']);
    }
    $stmt->close();
}

function handleDelete($conn, $id) {
    if (!$id) {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(['message' => 'ID de nota no proporcionado']);
        return;
    }

    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['message' => 'Nota eliminada exitosamente']);
        } else {
            http_response_code(404); // No encontrado
            echo json_encode(['message' => 'Nota no encontrada']);
        }
    } else {
        http_response_code(500); // Error del servidor
        echo json_encode(['message' => 'Error al eliminar la nota']);
    }
    $stmt->close();
}

// Cerrar la conexión al final del script
$conn->close();
?>
