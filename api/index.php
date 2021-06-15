<?php
require_once __DIR__ . "/../config/router.php";

echo json_encode(router("api"));
