<?php

class Test extends Controller
{
    public function index()
    {
        $liste = $this->db->result("select * from client");
        $data["message"] = "message depuis le controleur...";
        $this->load("header");
        $this->load("index", [
            "liste" => $liste,
            "message" => "cool",
        ]);
        $this->load("footer");
    }

    public function test1()
    {
        $data["cli_nom"] = "toto";
        $data["cli_prenom"] = "titi";
        $this->db->insert("client", [
            "nom" => "toto",
            "prenom" => "titi"
        ]);
        $this->redirect(url("crud/index"));
    }
}
