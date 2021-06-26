<?php

class RendezvousController extends AbstructController
{
    public function index($ref)
    {
        if (!$this->isGet()) return;
        return RendezVous::init()->select(["id", "date", "text", "horaire"])
            ->where(["ref_user" => $ref])->execute()->result;
    }

    public function create()
    {
        if (!$this->isPost()) return;

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

    public function get_aviable_hrours()
    {
        if (!$this->isPost()) return;

        $date = $this->format_date($this->request("date"));
        $statement = "'" . implode("', '", $this->hours()) . "'";

        $result = RendezVous::init()->select(["horaire"])->where(["date" => $date->format("Y-m-d")])
            ->in("horaire", $statement)->group_by("horaire")->execute()->result;

        $existing_dates = array_map(function ($res) {
            return $res["horaire"];
        }, $result);

        return array_values(array_filter($this->hours(), function ($elm) use ($existing_dates) {
            return !in_array($elm, $existing_dates);
        }));
    }

    private function handle_data()
    {
        $dtime = $this->format_date($this->request("date"));

        return [
            "date" => $dtime->format("Y-m-d"),
            "text" => $this->request("text"),
            "horaire" => $this->request("horaire"),
            "ref_user" => $this->request("ref_user")
        ];
    }

    private function format_date($date)
    {
        return DateTime::createFromFormat("Y-m-d", $date);
    }

    private function hours()
    {
        return [
            "08:00:00",
            "09:00:00",
            "10:00:00",
            "11:00:00",
            "12:00:00",
            "13:00:00",
            "14:00:00",
            "15:00:00",
            "17:00:00",
            "18:00:00"
        ];
    }
}
