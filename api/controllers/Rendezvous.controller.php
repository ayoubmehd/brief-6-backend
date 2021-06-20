<?php

class RendezvousController extends AbstructController
{
    public function index()
    {
        if (!$this->isGet()) return;
        return RendezVous::init()->select()->execute()->result;
    }

    public function create()
    {
        if (!$this->isPost()) {
            http_response_code(405);
            return ["error" => "Not Allowed"];
        }


        RendezVous::init()->insert($this->handle_data())->execute();

        http_response_code(201);
        return ["success" => "RenderVous created successfully"];
    }

    public function update($id)
    {
        if (!$this->isPut()) return;
        RendezVous::init()->update($this->handle_data(), ["id" => $id])->execute();

        http_response_code(200);
        return ["success" => "RenderVous updated successfully"];
    }

    public function delete($id)
    {
        if (!$this->isDelete()) return;

        RendezVous::init()->delete(["id" => $id])->execute();

        http_response_code(202);
        return ["success" => "RenderVous deleted successfully"];
    }

    private function handle_data()
    {
        $dtime = DateTime::createFromFormat("m-d-Y", $this->request("date"));
        return [
            "date" => $dtime->format("Y-m-d"),
            "text" => $this->request("text"),
            "horaire" => $this->request("horaire")
        ];
    }
}
