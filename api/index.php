<?php
require_once __DIR__ . "/../config/router.php";

$router = router("api");

$app = $router["app"];
$app->set_header("Access-Control-Allow-Origin", "http://localhost:8080");
$app->set_header("Content-Type", "application/json; charset=UTF-8");
$app->set_header("Access-Control-Allow-Methods", "POST, PUT, DELETE");
$app->set_header("Access-Control-Allow-Headers", "Origin, Content-Type, Accept");

echo json_encode($router["action"]);
