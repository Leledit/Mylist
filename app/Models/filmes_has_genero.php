<?php

class filmes_has_genero
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor

    public function UltimoRegistro()
    {
        $this->db->query("SELECT id FROM anime_has_genero order by id DESC LIMIT 1");
        return $this->db->resultados();
    }

    public function buscarPorIdFilme($id)
    {
        $this->db->query("SELECT gen.nome FROM filme_has_genero filGeb INNER JOIN genero gen ON gen.id = filGeb.id_genero WHERE filGeb.id_filme  = :id");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }

    public function exibirIdfilmes($id)
    {
        $this->db->query("SELECT gen.nome , gen.id FROM filme_has_genero filHGen iNNER JOIN genero gen ON gen.id = filHGen.id_genero where filHGen.id_filme = :id");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }

    public function buscIdFilmeGen($id_anime, $id_genero)
    {
        $this->db->query("SELECT id from filme_has_genero where id_filme = :id_anime AND id_genero = :id_genero ");
        $this->db->bind("id_anime", $id_anime);
        $this->db->bind("id_genero", $id_genero);
        return $this->db->resultados();
    }



    public function Cadastrar($dados)
    {
        $this->db->query("INSERT INTO filme_has_genero(id_genero,id_filme) VALUES(:genero, :filmes) ");
        $this->db->bind("genero", $dados['genero']);
        $this->db->bind("filmes", $dados['id']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados


    public function deletar($id)
    {
        $this->db->query("DELETE FROM filme_has_genero WHERE id = :id");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
