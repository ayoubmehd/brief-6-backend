<?php
require_once __DIR__ . "/../config/router.php";


header('Access-Control-Allow-Origin: http://localhost:8080');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, Accept');

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    echo json_encode(["res" => "Success"]);
    exit;
}

$router = router("api");

$app = $router["app"];
// $app->set_header("Access-Control-Allow-Origin", "http://localhost:8080");
// $app->set_header("Content-Type", "application/json");
// $app->set_header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, HEAD, OPTIONS");
// $app->set_header("Access-Control-Allow-Headers", "Origin, Content-Type, Accept");
// $app->set_header("Keep-Alive", "timeout=20, max=500");

echo json_encode($router["action"]);
