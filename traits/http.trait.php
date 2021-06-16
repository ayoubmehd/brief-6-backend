<?php

trait Http
{
    public function redirect($path)
    {
        header("Location: " . BASE_URL . $path);
    }

    public function requestMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
    public function isGet()
    {
        return $this->requestMethod() === "GET";
    }
    public function isPost()
    {
        return $this->requestMethod() === "POST";
    }
    public function isPut()
    {
        return $this->requestMethod() === "PUT";
    }
    public function isDelete()
    {
        return $this->requestMethod() === "DELETE";
    }

    public function request($prop = "")
    {
        $body = json_decode(file_get_contents("php://input"));
        if ($prop === "") return $body;

        return $body->$prop;
    }
}
