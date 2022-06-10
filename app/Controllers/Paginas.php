<?php

class Paginas extends Controller
{


    public function __construct()
    {
        $this->modelImagen = $this->model('imagen');
        $this->modelAnime = $this->model('anime');
        $this->modelFilmes = $this->model('filmes');
    }

    /*public function redirecionarBusca($identificador = null, $id = null)
    {
        if ($identificador == 'genero') :
            utilities::redirecionar('lista/');
            $_SESSION['ListaGen'] = $id;
           

        elseif ($identificador == 'null') :
            //se for igual a null vamos destruir todas as sessoes que tem ligaçao com a parte de listagem
            unset($_SESSION['ListaGen']);
            unset($_SESSION['busca']);
            utilities::redirecionar('lista/');
         

        elseif ($identificador = 'busca') :
            if (isset($_POST['enviar'])) :
                if ($_POST['buscar'] == '') :
                    utilities::mensagenAlerta('usuario', 'O campo busca deve ter no minimo tres caracteres', 'alert alert-fall');
                    utilities::redirecionar('');
                else :
                    $_SESSION['busca'] = $_POST['buscar'];
                    utilities::redirecionar('lista/');
                endif;
            endif;
        endif;
        
    
    }*/

    public function index($pagina = null)
    {

        //definindo quantos registros queremos por pagina
        $registro_pag = 20;

        //verificando em qual pagina estamos
        if ($pagina == null) :
            $pag = 1;
        else :
            $pag = $pagina;
        endif;

        //calculando o inico do valores
        $inicion =  $pag - 1;
        $inicion = $inicion * $registro_pag;

        if (isset($_SESSION['SEGMENT'])) :

            //verificando em qual sessao estamos
            if ($_SESSION['SEGMENT'] == 'ANIMES') :

                if ($pag == 1) :
                    //definindo quantos containers vao ter na pagina
                    $qtdContainers = 2;

                    //buscando as ultimas publicaçoes de animes
                    $ultimasPublicacoes = $this->modelAnime->buscarRegistros(8, $inicion);
                    $dados['ultimasPublicacoes'] = $ultimasPublicacoes;

                    //buscando animes no banco de dados(limitanto pela variavel)
                    $todosRegistros =  $this->modelAnime->buscarRegistros($registro_pag, $inicion);
                    $qtd_registro = $this->modelAnime->retornarQtdRegistro();
                    $dados['ResultadosTotais'] = $todosRegistros;

                else :

                    $qtdContainers = 1;
                    $todosRegistros =  $this->modelAnime->buscarRegistros($registro_pag, $inicion);
                    $qtd_registro = $this->modelAnime->retornarQtdRegistro();
                    $dados['ResultadosTotais'] = $todosRegistros;

                endif;

            else :
                //Trabalhando com filmes/Series 

                if ($pag == 1) :
                    //definindo quantos containers vao ter na pagina
                    $qtdContainers = 2;

                    //buscando as ultimas publicaçoes de animes
                    $ultimasPublicacoes =  $this->modelFilmes->buscarRegistros(8, $inicion);
                    $dados['ultimasPublicacoes'] = $ultimasPublicacoes;

                    //buscando animes no banco de dados(limitanto pela variavel)
                    $todosRegistros = $this->modelFilmes->buscarRegistros($registro_pag, $inicion);
                    $qtd_registro =   $this->modelFilmes->retornarQtdRegistro();
                    $dados['ResultadosTotais'] = $todosRegistros;

                else :

                    $qtdContainers = 1;
                    //buscando animes no banco de dados(limitanto pela variavel)
                    $todosRegistros = $this->modelFilmes->buscarRegistros($registro_pag, $inicion);
                    $qtd_registro =   $this->modelFilmes->retornarQtdRegistro();
                    $dados['ResultadosTotais'] = $todosRegistros;

                endif;

                $qtd_registro = 1;

            endif;

            //setando a variavel qtdContainer
            $dados['qtdContainer'] = $qtdContainers;
            $dados['pag'] = $pag;

            //agora vamos divir pelo numero de iten na tela, para saber quantas paginas vamos ter
            $qtd_registro = $qtd_registro / $registro_pag;

            //verificando se deu um numero fracionario(quer dizer que temos paginas com poucos itens),se tiver devemos acrentar mais um
            if (is_float($qtd_registro)) :
                $qtd_registro = intval($qtd_registro) + 1;
            endif;

            $dados['qtd_pag'] = $qtd_registro;

        else :

            $_SESSION['SEGMENT'] = 'ANIMES';
            utilities::redirecionar('');
        endif;

        $this->view('paginas/home', $dados);
    }
    public function definirSesao($sessao)
    {
        if ($sessao == 'animes') :
            $_SESSION['SEGMENT'] = 'ANIMES';
        else :
            $_SESSION['SEGMENT'] = 'FILMESSERIES';
        endif;
        utilities::redirecionar('');
    }
}
