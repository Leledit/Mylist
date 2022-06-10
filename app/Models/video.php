<?php

class video
{

    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor
    
    public function editar($url,$id){
        $this->db->query("UPDATE videos SET url_video = :url_video WHERE id = :id");
        $this->db->bind("url_video",$url);
        $this->db->bind("id",$id);
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }

    

    public function Cadastrar($dados)
    {
        $this->db->query("INSERT INTO videos(url_video,identificador,tipo)
        VALUE(:url_video,:identificador,:tipo)");
       
        $this->db->bind("url_video", $dados['url']);
        $this->db->bind("identificador", $dados['identificador']);
        $this->db->bind("tipo", $dados['tipo']);
    
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    } //fechamento da função de armazenagem dos dados

    public function UltimoRegistro()
    {
        $this->db->query("SELECT id FROM videos order by id DESC LIMIT 1");
        return $this->db->resultados();
    }

    public function vincularVideo($anime,$video){
        $this->db->query("INSERT INTO anime_has_video(id_anime,id_video)VALUE(:anime,:video)");
        $this->db->bind(":anime",$anime);
        $this->db->bind(":video",$video);
        
        if ($this->db->executa()) :
            return true;
        else :
            return false;
        endif;
    }
}
