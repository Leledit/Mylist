<?php

class anime_has_video
{
    private $db;


    public function __construct()
    {

        $this->db = new Database();
    } //fechamento do metodo contrutor

    public function buscarPorIdAnime($id)
    {
        $this->db->query("SELECT vid.url_video, vid.identificador, vid.tipo, anvid.id_anime FROM anime_has_video anVid INNER JOIN videos vid ON vid.id = anVid.id_video WHERE id_anime = :id");
        $this->db->bind("id", $id);
        return $this->db->resultados();
    }
    public function buscariDVideo($idVideo){
        $this->db->query("SELECT id_anime FROM anime_has_video where id_video = :id ");
        $this->db->bind("id",$idVideo);
        return $this->db->resultado();
    }
    public function buscar($tipo)
    {
        $this->db->query("SELECT vid.url_video, vid.identificador, vid.tipo, anvid.id_anime ,vid.id FROM anime_has_video anVid INNER JOIN videos vid ON vid.id = anVid.id_video WHERE vid.tipo = :tipo");
        $this->db->bind("tipo", $tipo);
        return $this->db->resultados();
    }
}
