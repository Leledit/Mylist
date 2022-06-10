<?php

class item extends Controller
{

    public function __construct()
    {

        $this->modelImagen = $this->model('imagen');
        $this->modelGenero = $this->model('genero');
        $this->modelAnime = $this->model('anime');
        $this->modelAnime_has_genero = $this->model('anime_has_genero');
        $this->modelAnime_has_video = $this->model('anime_has_video');
        $this->modelFilmes = $this->model('filmes');
        $this->modelfilmesHgeneros = $this->model('filmes_has_genero');
    }

    /* public function encontrarAnime($nomeAnime)
    {

        var_dump($nomeAnime);
       

        echo 'cai aqui';
    }*/

    public function index($id)
    {

        if (isset($_SESSION['SEGMENT'])) :

            //verificando em qual sessao estamos
            if ($_SESSION['SEGMENT'] == 'ANIMES') :
                //mostrando um anime
                $resultado = [
                    'info' => $this->modelAnime->buscarPorID($id),
                ];
                $resultado['infoGeneros'] = $this->modelAnime_has_genero->buscarPorIdAnime($resultado['info']->id);
                foreach ($this->modelAnime_has_video->buscarPorIdAnime($resultado['info']->id) as $rest) :
                    if ($rest->tipo == 'Opening') :
                        $resultado['VideoOpening'][] = $rest;
                    else :
                        $resultado['VideoClosure'][] = $rest;

                    endif;
                endforeach;
                /*Verificando se existe uma proxima temporada e uma temporada anterior*/

                if ($resultado['info']->anterior_temp != 'ND') :
                    $nomeAnime = $resultado['info']->anterior_temp;
                    $id_anime =  $this->modelAnime->buscarPorNome($nomeAnime);
                    $resultado['anterior_temp_id'] = $id_anime;

                    if ($resultado['anterior_temp_id'] == false) :
                        $resultado['erroConsulta'] = 'ant';
                    else :
                        $resultado['erroConsulta'] = null;
                    endif;

                endif;
                if ($resultado['info']->proxima_temp != 'ND') :
                    $nomeAnime = $resultado['info']->proxima_temp;
                    $id_anime =  $this->modelAnime->buscarPorNome($nomeAnime);
                    $resultado['proxima_temp_id'] = $id_anime;
                    if ($resultado['proxima_temp_id'] == false) :
                        $resultado['erroConsulta'] = 'pro';
                    else :
                        $resultado['erroConsulta'] = null;
                    endif;
                endif;
            else :
                //mostrando um filme
                $resultado = [
                    'info' => $this->modelFilmes->buscarPorID($id),
                    'infoVideos' => null
                ];
                $resultado['infoGeneros'] = $this->modelfilmesHgeneros->buscarPorIdFilme($resultado['info']->id);
            endif;
        endif;

        $resultado['nItem'] = $id;

        $this->view('item/index', $resultado);
    }
}
