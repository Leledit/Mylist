<?php

class anime_has_genero
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

    public function buscarPorIdAnime($id)
    {
        $this->db->query("SELECT gen.nome FROM anime_has_genero anGe INNER JOIN genero gen ON gen.id = anGe.id_genero WHERE id_anime = :id");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }

    public function exibirIdAnime($id)
    {
        $this->db->query("SELECT gen.nome , gen.id FROM anime_has_genero anGe INNER JOIN genero gen ON gen.id = anGe.id_genero WHERE id_anime = :id");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }

    public function buscIdAnimeGen($id_anime, $id_genero)
    {
        $this->db->query("SELECT id from anime_has_genero where id_anime = :id_anime AND id_genero = :id_genero ");
        $this->db->bind("id_anime", $id_anime);
        $this->db->bind("id_genero", $id_genero);
        return $this->db->resultados();
    }



    public function Cadastrar($dados)
    {
        $this->db->query("INSERT INTO anime_has_genero(id_anime,id_genero) VALUES(:anime,  :genero) ");
        $this->db->bind("anime", $dados['id']);
        $this->db->bind("genero", $dados['genero']);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados


    public function deletar($id)
    {
        $this->db->query("DELETE FROM anime_has_genero WHERE id = :id");
        $this->db->bind("id", $id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
