<?php

class HomeController extends AbstructController
{

    public function h1($text)
    {
        echo "<h1>$text</h1>";
    }

    public function index()
    {

        $this->h1("The Insert Query");
        echo "<pre>";
        var_dump(RendezVous::init()->insert(["bla" => "wow"])->query);
        echo "</pre>";

        $this->h1("The Select Query");
        echo "<pre>";
        var_dump(RendezVous::init()->select(["bla"])->where(["id" => "id"])->query);
        echo "</pre>";

        $this->h1("The Update Query");
        echo "<pre>";
        var_dump(RendezVous::init()->update(["bla" => "bla"], ["id" => "id"])->query);
        echo "</pre>";

        $this->h1("The Delete Query");
        echo "<pre>";
        var_dump(RendezVous::init()->delete(["id" => "id"])->query);
        echo "</pre>";

        $this->h1("The Insert Query");
        echo "<pre>";
        var_dump(User::init()->insert(["bla" => "wow"])->query);
        echo "</pre>";

        $this->h1("The Select Query");
        echo "<pre>";
        var_dump(User::init()->select(["bla"])->where(["id" => "id"])->query);
        echo "</pre>";

        $this->h1("The Update Query");
        echo "<pre>";
        var_dump(User::init()->update(["bla" => "bla"], ["id" => "id"])->query);
        echo "</pre>";

        $this->h1("The Delete Query");
        echo "<pre>";
        var_dump(User::init()->delete(["id" => "id"])->query);
        echo "</pre>";
    }
}
