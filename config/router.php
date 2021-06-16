<?php

$action = "";
$ctr = "";
$params  = explode("/", ltrim($_SERVER["REQUEST_URI"], "/"));
// var_dump(explode("/", ltrim($_SERVER["REQUEST_URI"], "/")));

require_once "globals.php";

function router($folder = "")
{
    global $ctr, $action, $params;

    if ($folder === "api") {
        array_shift($params);
    }

    if (!isset($params[0]) || $params[0] === "") {
        $ctr = "home";
    } else {
        $ctr = $params[0];
    }


    if (!isset($params[1]) || $params[1] === "") {
        $action = "index";
    } else {
        $action = $params[1];
    }

    $ctr = ucfirst($ctr);
    $file = BASE_PATH . $folder . "/controllers/" . $ctr . ".controller.php";
    if (file_exists($file)) {
        require_once $file;
        $ctrClass = $ctr . "Controller";
        if (class_exists($ctrClass)) {
            $app = new $ctrClass();
        }
        if (method_exists($app, $action)) {
            return [
                "app" => $app,
                "action" => $app->$action(...array_slice($params, 2, sizeof($params) - 1))
            ];
        }
    }
}
