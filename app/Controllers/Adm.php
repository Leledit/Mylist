<?php

class Adm extends Controller
{
    public function __construct()
    {
        //função que verifica se o usuario é um adm, se nao for ele é redirecionado
        utilities::verifiUsuarioSessao();
        //intanciando os model que seram usados
        $this->modelImagen = $this->model('imagen');
        $this->modelGenero = $this->model('genero');
        $this->modelAnime = $this->model('anime');
        $this->modelFilmes = $this->model('filmes');
        $this->modelGenero = $this->model('genero');
    }
    public function index()
    {
        $this->view('Adm/Animes/index');
    }
    public function redirecionarBusca($id = null, $identificador = null)
    {


        if ($identificador == 'genero') :
            $_SESSION['FiltroList'] = 'genero';
            $_SESSION['FiltroListId'] = $id;
        elseif ($identificador == 'all') :
            $_SESSION['FiltroList'] = null;
        elseif ($identificador == 'busc') :
            $_SESSION['FiltroList'] = 'busc';
            $_SESSION['FiltroListId'] = $id;
        endif;

        echo $identificador;

        utilities::redirecionar('adm/filtros/');
    }
    private function limparSesion()
    {
        unset($_SESSION['FiltroList']);
        unset($_SESSION['parametroBusck']);
        unset($_SESSION['FiltroListBusc']);
    }

    public function filtros($id = null, $identificador = null)
    {
        $this->limparSesion();

        if ($identificador == 'all') :
            $_SESSION['FiltroList'] = 'all';
        elseif($identificador == 'busc'):
            $_SESSION['FiltroList'] = 'busc';
        elseif($identificador == 'genero'):
            $_SESSION['FiltroList'] = 'genero';
        endif;

        if ($identificador != 'all') :

            $pag = 1;
            $inicion =  $pag - 1;
            //verificando que tipo de busca nos temos
            if ($identificador == 'genero') :
                //Caso tenhamos uma busca por genero(direto da pagina)
                $registro_pag = 100;

                $inicion = $inicion * $registro_pag;
                $resultado = $this->modelAnime->buscarGenero($id, $registro_pag, $inicion);
                $qtd_registro = $this->modelAnime->retornarQtdRegistroBusca($id);

            elseif ($_SESSION['FiltroList'] = 'busc') :
                //Aqui foi feita uma busca atraves do sistema de busca
                $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if (isset($formulario)) :
                    //pegando o que foi digitado no campo de busca e salvando na sessao
                    $_SESSION['FiltroListBusc'] = $formulario['busca'];
                    $registro_pag = intval($formulario['Limite']);
             

                    if ($formulario['indicadorBusca'] == 'Anime') :

                        $resultado = $this->modelAnime->buscar($formulario['busca'], $registro_pag, $inicion);
                       // $qtd_registro = $this->modelAnime->qtdBusca($formulario['busca']);
                        if ($_SESSION['SEGMENT'] != 'ANIMES') :
                            utilities::trocarSession();
                        endif;

                    elseif ($formulario['indicadorBusca'] == 'Filme') :
                        $resultado = $this->modelFilmes->buscar($formulario['busca'], $registro_pag, $inicion);
                      //  $qtd_registro = $this->modelFilmes->buscarqtd($formulario['busca']);
                        if ($_SESSION['SEGMENT'] == 'ANIMES') :
                            utilities::trocarSession();
                        endif;

                    elseif ($formulario['indicadorBusca'] = 'generos') :
                        if ($_SESSION['SEGMENT'] == 'ANIMES') :
                            $segment = "Animes";
                        else :
                            $segment = 'Filmes';
                        endif;
                        $resultado = $this->modelGenero->buscar($formulario['busca'], $segment);
                       // $qtd_registro = intval($formulario['Limite']);



                    endif; //fechamento da verificação da indicação da busca
                    $_SESSION['parametroBusck'] = $formulario['indicadorBusca'];
                endif;
            endif;
            $dados = [
                'valor' => $resultado,
                'pag' => $pag,
                


            ];

        else :
            $dados = [''];
        endif;

        $this->view('Adm/filtros', $dados);
    }
}
