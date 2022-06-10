<?php

class Lista extends Controller
{


    public function __construct()
    {
        $this->modelImagen = $this->model('imagen');
        $this->modelAnime = $this->model('anime');
        $this->modelFilmes = $this->model('filmes');
    }

    public function index($identificador = null, $id = null)
    {
        $this->limparbuscas();

        //Verificando que tipo de listagem esta sendo feita
        if ($identificador == 'genero') :

            $_SESSION['ListaGen'] = $id;
            //buscando o nome do genero que esta sendo usado para fazer a pesquisa
            $nomeGenero =  $this->modelAnime->buscarNomeGenero($id);
            $_SESSION['ListaGeNome'] =  $nomeGenero;
            //chamando a função resposnavel por listar os dados
            $this->listarDados();
        elseif ($identificador == 'busca') :

            if (isset($_POST['enviar'])) :

                if ($_POST['buscar'] == '') :

                    $_SESSION['buscarfall'] = 1;
                else :
                    //Destruindo a sessao que indica que tem algo errado com a busca
                    unset($_SESSION['buscarfall']);
                    $_SESSION['busca'] = $_POST['buscar'];

                endif;
            endif;
            //chamando a função resposnavel por listar os dados
            $this->listarDados();
        else :
            //chamando a função resposnavel por listar os dados
            $this->listarDados($identificador);
        endif;
    }



    private function limparbuscas()
    {
        /*Função resposavel por apagar todas as sessoes contendo resultados de buscas ou itens de apoio(usados nas configuraçoes das paginas)*/
        /*Isso deve ser feito antes de iniciar uma nova busca*/
        unset($_SESSION['ListaGen']);
        unset($_SESSION['busca']);
        unset($_SESSION['ListaGeNome']);
        unset($_SESSION['buscarfall']);
    }

    private function listarDados($pagina = null)
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

        if (!isset($_SESSION['ListaGen']) && !isset($_SESSION['busca'])) :
            //caso nao tenha sessao

            if ($_SESSION['SEGMENT'] == 'ANIMES') :
                $todosRegistros =  $this->modelAnime->buscarRegistros($registro_pag, $inicion);
                $qtd_registro = $this->modelAnime->retornarQtdRegistro();
                $dados['ResultadosTotais'] = $todosRegistros;
            else :
                $todosRegistros = $this->modelFilmes->buscarRegistros($registro_pag, $inicion);
                $qtd_registro =   $this->modelFilmes->retornarQtdRegistro();
                $dados['ResultadosTotais'] = $todosRegistros;
            endif;



        else :

            //vai entrar aqui quando tiver alguma sessao
            if (isset($_SESSION['ListaGen'])) :

                if ($_SESSION['SEGMENT'] == 'ANIMES') :
                    //se entro aqui quer dizer que vamos
                    $dados['ResultadosTotais'] = $this->modelAnime->buscarGenero($_SESSION['ListaGen'], $registro_pag, $inicion);
                    $qtd_registro =  $this->modelAnime->retornarQtdRegistroBusca($_SESSION['ListaGen']);
                else :

                    $dados['ResultadosTotais'] =  $this->modelFilmes->buscarPorGenero($_SESSION['ListaGen'], $registro_pag, $inicion);
                    $qtd_registro =   $this->modelFilmes->buscarPorGeneroQtd($_SESSION['ListaGen']);
                endif;

            elseif (isset($_SESSION['busca'])) :
                //caso tenhamos uma busca vamos entrar aqui

                //buscando atraves dos animes
                if ($_SESSION['SEGMENT'] == 'ANIMES') :
                    $dados['ResultadosTotais'] = $this->modelAnime->buscar($_SESSION['busca']);
                    $qtd_registro = $this->modelAnime->qtdBusca($_SESSION['busca']);
                else :
                    //buscando atraves dos filmes
                    $dados['ResultadosTotais'] = $this->modelFilmes->buscar($_SESSION['busca'], $registro_pag, $inicion);
                    $qtd_registro = $this->modelFilmes->buscarqtd($_SESSION['busca']);
                endif;
            endif;

        //caso tenha algum parametro 
        endif;

        //agora vamos divir pelo numero de iten na tela, para saber quantas paginas vamos ter
        $qtd_registro = $qtd_registro / $registro_pag;

        //verificando se deu um numero fracionario(quer dizer que temos paginas com poucos itens),se tiver devemos acrentar mais um

        if (is_float($qtd_registro)) :
            $qtd_registro = intval($qtd_registro) + 1;
        endif;

        $dados['qtd_pag'] = $qtd_registro;

        $dados['pag'] = $pag;


        /*Verificamos quantas paginas vamos ter de dados,
       caso o valor de 0 quer dizer que a busca nao retornou nenhum valor*/
        if ($qtd_registro == 0) :
            $_SESSION['buscarfall'] = 2;
        endif;

        $this->view('lista/index', $dados);
    }
}
