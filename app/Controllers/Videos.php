<?php

class Videos extends Controller
{


    public function __construct()
    {
        //função que verifica se o usuario é um adm, se nao for ele é redirecionado
        utilities::verifiUsuarioSessao();
        $this->modelAnime = $this->model('anime');
        $this->modelFilmes = $this->model('filmes');
        $this->modelVideo = $this->model('video');
        $this->modelAnime_has_video = $this->model('anime_has_video');
    }

    public function index($identificador = null)
    {
        //Limpando a sessao
        $this->limparSesion();


        foreach ($this->modelAnime_has_video->buscar($identificador) as $rest) :
            if ($rest->tipo == 'Opening') :
                $resultado['VideoOpening'][] = $rest;
            else :
                $resultado['VideoClosure'][] = $rest;
            endif;
        endforeach;

        if ($identificador == 'Opening') :
            if (isset($resultado)) :
                $Videos = $resultado['VideoOpening'];
            else:
                $Videos =null;
            endif;
            $_SESSION['identifVideo'] = 'Opening';
        else :
            if (isset($resultado)) :
                $Videos = $resultado['VideoClosure'];
            else:
                $Videos =null;
            endif;
            $_SESSION['identifVideo'] = 'Closure';
        endif;
        $this->view('Adm/Videos/index', $Videos);
    }

    public function editar($tipo, $idVideo)
    {
        if ($tipo == 'Opening') :
            $_SESSION['identifVideo'] = 'Opening';
        else :
            $_SESSION['identifVideo'] = 'Closure';
        endif;

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :

            $this->alterarDados($formulario['url'], $idVideo);
        else :

            $idAnime = $this->modelAnime_has_video->buscariDVideo($idVideo);

            $resultado = $this->modelAnime->buscarPorID($idAnime->id_anime);
            $nomeAnime = $resultado->nome;
            $Valores = [
                'nome_anime' => $nomeAnime,
                'id_video' => $idVideo,
                'id_anime' => $idAnime->id_anime,
                'url_erro' => '',
                'acaoPag' => 'editar',
            ];

            $this->view('Adm/Videos/manipulacao', $Valores);
        endif;
    }

    private function alterarDados($url, $id_video)
    {
        if ($this->modelVideo->editar($url, $id_video)) :
            utilities::redirecionar('Animes/');
        endif;
    }

    public function cadastro($tipo, $idAnime)
    {
        //ajustes iniciais
        //Limpando a sessao
        $this->limparSesion();
        //pegando as informaçoes do anime(baseado no id)
        $resultado = $this->modelAnime->buscarPorID($idAnime);
        $nomeAnime = $resultado->nome;
        $Valores = [
            'nome_anime' => $nomeAnime,
            'id_anime' => $idAnime,
            'identificador_erro' => '',
            'url_erro' => '',
            'acaoPag' => 'Cadastro',
        ];

        if ($tipo == 'Opening') :
            $_SESSION['identifVideo'] = 'Opening';
        elseif ($tipo == 'Closure') :
            $_SESSION['identifVideo'] = 'Closure';
        endif;


        //iniciando o cadastro
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            //guardando os dados em um objeto
            $dados = [
                'identificador' => $formulario['identificador'],
                'url' => $formulario['url'],
                'tipo' => $_SESSION['identifVideo'],
            ];

            var_dump($dados);

            //Cadastrando o video
            if ($this->modelVideo->Cadastrar($dados)) :
                $ultimoRegistro = $this->modelVideo->UltimoRegistro();

                if ($this->modelVideo->vincularVideo($idAnime, $ultimoRegistro[0]->id)) :
                    //Redirecionando para a tela incial de cadastro
                    utilities::redirecionar('Animes/item/' . $idAnime);
                    utilities::mensagenAlerta('AdmVideo', 'Cadastro efetuado com sucesso', '');
                else :
                    //Redirecionando para a tela incial de cadastro
                    utilities::redirecionar('Videos/cadastro/' . $_SESSION['identifVideo'] . '/' . $idAnime);
                    utilities::mensagenAlerta('AdmVideo', 'Erro desconhecido ao vincular o video com o anime', 'alert alert-fall');

                endif;
            else :
                //Redirecionando para a tela incial de cadastro
                utilities::redirecionar('Videos/cadastro/' . $_SESSION['identifVideo'] . '/' . $idAnime);
                utilities::mensagenAlerta('AdmVideo', 'Erro desconhecido ao cadastrar o video', 'alert alert-fall');
            endif;





        else :
            $Valores += [
                'identificador_erro' => '',
                'url_erro' => '',

            ];

        endif;



        $this->view('Adm/Videos/manipulacao', $Valores);
    }


    private function limparSesion()
    {
        if (isset($_SESSION['identifVideo']) != null) :
            unset($_SESSION['identifVideo']);
        endif;
    }
}
