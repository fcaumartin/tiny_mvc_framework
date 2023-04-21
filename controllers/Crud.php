<?php

class Crud extends controller
{
    public function index()
    {
        $liste = $this->db->result("select * from client ");
        $this->load("header");
        $this->load("crud/index", [
            "liste" => $liste
        ]);
        $this->load("footer");
    }

    public function create()
    {
        if ($this->is_post()) {
            $this->db->insert("client", $this->post());
            $this->session->message = "ajout effectué";
            $this->redirect(url("crud/index"));
        } else {
            $this->load("header");
            $this->load("crud/create");
            $this->load("footer");
        }
    }

    public function update($id)
    {
        if ($this->is_post()) {
            $this->db->update("client", $this->post(), "id", $id);
            $this->redirect(url("crud/index"));
        } else {
            $data["elt"] = $this->db->row("select * from client where id=?", $id);
            $this->load("header");
            $this->load("crud/update", $data);
            $this->load("footer");
        }
    }

    public function delete($id)
    {
        if ($this->is_post()) {
            $this->db->delete("client", "id", $id);
            $this->redirect(url("crud/index"));
        } else {
            $data["elt"] = $this->db->row("select * from client where id=?", $id);
            $this->load("header");
            $this->load("crud/delete", $data);
            $this->load("footer");
        }
    }
}
