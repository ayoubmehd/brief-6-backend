<?php

class UserController extends AbstructController
{
    public function index()
    {
        http_response_code(404);
        return ["error" => "Not Found"];
    }

    public function identify($ref)
    {
        if (!$this->isPost()) return;

        $query = User::init()->select()->where(["reference" => $ref])->execute();

        if (count($query->result) > 0) {
            http_response_code(200);
            return $query->result[0];
        }

        http_response_code(404);
        return ["error" => "Not Found"];
    }

    public function register()
    {
        if (!$this->isPost()) return;

        User::init()->insert($this->handle_data())->execute();

        http_response_code(201);
        return ["message" => "User created successfully"];
    }

    private function handle_data()
    {
        return [
            "reference" => $this->generate_reference(),
            "nom" => $this->request("nom"),
            "prenom" => $this->request("prenom"),
            "age" => $this->request("age"),
            "email" => $this->request("email"),
            "tele" => $this->request("tele"),
        ];
    }

    private function generate_reference()
    {

        if (function_exists("random_bytes")) {
            return bin2hex(random_bytes(10));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            return bin2hex(openssl_random_pseudo_bytes(10));
        }

        return uniqid() . "-" . uniqid() . "-" . uniqid() . "-" . uniqid();
    }
}
