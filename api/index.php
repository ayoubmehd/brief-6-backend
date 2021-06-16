<?php
require_once __DIR__ . "/../config/router.php";

$router = router("api");

$app = $router["app"];
$app->set_header("Access-Control-Allow-Origin", "*");
$app->set_header("Content-Type", "application/json");
$app->set_header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
$app->set_header("Access-Control-Allow-Headers", "Origin, Content-Type");

echo json_encode($router["action"]);
