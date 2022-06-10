<?php

class imagen
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor

    public function UltimoRegistro()
    {

        $this->db->query("SELECT id FROM imagens order by id DESC LIMIT 1");

        return $this->db->resultados();
    }

    public function buscarPorID($id)
    {
        $this->db->query("SELECT * FROM `imagens` WHERE id = :id");
        $this->db->bind("id", $id);
        return $this->db->resultado();
    }

    public function editarDados($dados)
    {

        $this->db->query("UPDATE imagens SET extencao = :extencao, url =  :ur, tamanho = :tamanho  WHERE id = :id");
        $this->db->bind("extencao", $dados['extencao']);
        $this->db->bind("ur", $dados['url']);
        $this->db->bind("tamanho", $dados['tamanho']);
        $this->db->bind("id", $dados['id']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }



    public function Cadastrar($dados)
    {
        $this->db->query("INSERT INTO imagens(extencao,url,tamanho) VALUES(:extencao, :ur , :tamanho) ");
        $this->db->bind("extencao", $dados['extencao']);
        $this->db->bind("ur", $dados['url']);
        $this->db->bind("tamanho", $dados['tamanho']);



        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados


    public function deletar($id)
    {
        $this->db->query("DELETE FROM imagens WHERE id = :id");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
