<?php
// Habilita la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Encabezado JSON
header('Content-Type: application/json');

// Mensaje para confirmar que se ejecuta el script
error_log("get_articles.php: Script started");

// Incluye la conexión a la base de datos
include '../db_connection.php';

// Verifica si la conexión falló
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Realiza la consulta SQL
$query = "SELECT * FROM Articles";
$result = $conn->query($query);

// Verifica si la consulta falló
if (!$result) {
    error_log("Query failed: " . $conn->error);
    echo json_encode(['error' => 'Query failed']);
    exit;
}

// Inicializa el array de artículos
$articles = [];

// Procesa los resultados de la consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}

// Devuelve un mensaje si no hay artículos
if (empty($articles)) {
    error_log("No articles found");
    echo json_encode(['message' => 'No articles found']);
    exit;
}

// Devuelve los datos en formato JSON
echo json_encode($articles);
error_log("get_articles.php: JSON response sent");

// Cierra la conexión
$conn->close();
?>