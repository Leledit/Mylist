<?php

class Generos extends Controller
{


    public function __construct()
    {
        //função que verifica se o usuario é um adm, se nao for ele é redirecionado
        // utilities::verifiUsuarioSessao();
        $this->modelImagen = $this->model('imagen');
        $this->modelGenero = $this->model('genero');
    }
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

        if ($_SESSION['SEGMENT'] == 'ANIMES') :

            //buscando todas as categorias relacionadas com animes
            $categoria = 'Animes';
        else :
            $categoria = 'Filmes';
        endif;
        $qtd_registro = $this->modelGenero->exibirQtd($categoria);
        $generos =  $this->modelGenero->exibir($categoria, $registro_pag, $inicion);

        //agora vamos divir pelo numero de iten na tela, para saber quantas paginas vamos ter
        $qtd_registro = $qtd_registro / $registro_pag;

        //verificando se deu um numero fracionario(quer dizer que temos paginas com poucos itens),se tiver devemos acrentar mais um

        if (is_float($qtd_registro)) :
            $qtd_registro = intval($qtd_registro) + 1;
        endif;
        $dados = [
            'generos' => $generos,
            'pag' => $pag,
            'qtd_pag' => $qtd_registro,
        ];

        if (isset($_SESSION['usu_nivel'])) :
            if ($_SESSION['usu_nivel'] == 1) :
                $this->view('Adm/generos', $dados);
            else :
                $this->view('Usuario/generos', $dados);
            endif;
        else :
            $this->view('Usuario/generos', $dados);
        endif;
    }

    public function generos()
    {
        $this->view('Adm/Animes/generos');
    }

    public function verGenero($id)
    {
        $genero = $this->modelGenero->exibirID($id);
     
        $this->view('adm/verGenero', $genero);
    }


    public function deletarGnero($id, $id_img)
    {
        $resultado = $this->modelImagen->buscarPorID($id_img);
        $url = $resultado->url;
        if ($this->modelGenero->deletar($id)) :
            if ($this->modelImagen->deletar($id_img)) :
                unlink($url);
                utilities::mensagenAlerta('MainGenero', 'Genero excluido com sucesso');
                utilities::redirecionar('Generos/');
            else :
                utilities::mensagenAlerta('MainGenero', 'Erro ao deletar a imagen', 'alert alert-danger');
            endif;
        else :
            utilities::mensagenAlerta('MainGenero', 'Erro ao deletar o genero', 'alert alert-danger');
        endif;
        utilities::redirecionar('Generos/');
    }
    public function ManipulacaoGenero($acao, $id = null)
    {
        if ($acao != 'Cadastro') :
            $resultado = $this->modelGenero->exibirID($id);
            $dados['nome'] = $resultado[0]->nome;
        endif;

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $dados = [
                "nome_erro" => '',
            ];
            $dados['nome'] = $formulario["nomeG"];
            if ($_SESSION['SEGMENT'] == 'ANIMES') :
                $dados['categoria'] = 'Animes';
            else :
                $dados['categoria'] = 'Filmes';
            endif;

            if (Validar::tamanhoPermit($formulario["nomeG"])) :
                $dados["nome_erro"] = "O campo nome nao pode estar vazio";
            else :

                if (Validar::apenasCaracteres($formulario["nomeG"])) :
                    $dados["nome_erro"] = "O campo nome so aceita caracteres";
                else :
                    if (empty($_FILES['imagenG']['error'])) :

                        //verificando em qual sessao do site estamos
                        if ($_SESSION['SEGMENT'] == 'FILMESSERIES') :
                            $destino = 'Generos\Filmes';
                            $indicacaoSegement = 'Filmes';
                        else :
                            $destino = 'Generos\Animes';
                            $indicacaoSegement = 'Animes';
                        endif;

                        $teste = $this->modelGenero->buscarNome($formulario['nomeG'], $indicacaoSegement);

                        if ($teste) :
                            utilities::mensagenAlerta('cadastroG', 'Ja possui uma categoria cadastrada com ess nome', 'alert alert-danger');
                        else :
                            if ($acao != 'Cadastro') :
                                //antes de fazer o upload da nova imagem, vamos apagar a antiga ok
                                unlink($resultado[0]->url);
                            endif;
                            //fazendo o upload ada imagem para a sua pasta no servidor
                            $upload = new Upload;
                            $upload->imagem($_FILES['imagenG'], $destino, $formulario["nomeG"]);

                            if ($upload->getResultado()) :

                                $extencao_arquivo = strtolower(substr($_FILES['imagenG']['name'], -4));
                                $tamanho = $_FILES['imagenG']['size'];
                                $infoImg = [
                                    'url' => 'img/Generos/' . $indicacaoSegement . '/' . $formulario["nomeG"] . $extencao_arquivo,
                                    'extencao' => $extencao_arquivo,
                                    'tamanho' => $tamanho,
                                ];

                                if ($acao == 'Cadastro') :
                                    //Depois de mover a imagem vamos fazes os cadastros no bd
                                    if ($this->modelImagen->Cadastrar($infoImg)) :

                                        $idImg = $this->modelImagen->UltimoRegistro();

                                        //agora vamos cadastrar o generos
                                        if ($this->modelGenero->Cadastrar($dados, $idImg)) :
                                            utilities::mensagenAlerta('MainGenero', 'Categoria cadastrada com sucesso');
                                            utilities::redirecionar('Generos/');
                                        else :
                                            utilities::mensagenAlerta('MainGenero', 'erro ao cadastrar a categoria', 'alert alert-danger');
                                        endif;
                                    else :
                                        utilities::mensagenAlerta('MainGenero', 'erro ao gravar a imagem', 'alert alert-danger');
                                    endif;
                                else :
                                    //vai parar aqui caso for edição

                                    //vamos editar as informaçoes da imagem
                                    $infoImg['id'] = $resultado[0]->id_img;
                                    if (!$this->modelImagen->editarDados($infoImg)) :
                                        utilities::mensagenAlerta('MainGenero', 'erro ao alterar as informaçoes da imagen', 'alert alert-danger');
                                    endif;

                                    //agora vamos editar as infomaçoes sobre o genero
                                    if ($this->modelGenero->atualizar($dados['nome'], $resultado[0]->id)) :
                                        utilities::mensagenAlerta('MainGenero', 'Categoria Editada com sucesso');
                                        utilities::redirecionar('Generos/');
                                    else :
                                        utilities::mensagenAlerta('MainGenero', 'erro ao alterar as informaçoes da imagen', 'alert alert-danger');
                                    endif;
                                endif;
                            else :
                                utilities::mensagenAlerta('MainGenero', $upload->getErro(), 'alert alert-danger');
                            endif;
                        endif;
                    else :
                        utilities::mensagenAlerta('MainGenero', 'É necessario selecionar um arquivo para proceguir com o cadastro', 'alert alert-danger');
                    endif;
                endif;
            endif;
        else :
            $dados = [
                "nome" => '',
                "nome_erro" => '',
            ];
        endif;
        $dados['acao'] = $acao;
        if ($acao != 'Cadastro') :
            $dados['nome'] = $resultado[0]->nome;
            $dados['id'] = $id;
        endif;
        $this->view('Adm/ManipulacaoGenero', $dados);
    }

    public function AddGenSession($indicacaoPart, $idAnime = null)
    {
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (!isset($formulario['generos'])) :
            utilities::mensagenAlerta('ADDGenero', 'é necessario selecionar um genero para poder adicionar o mesmo', 'alert alert-danger');
            if ($_SESSION['SEGMENT'] == 'ANIMES') :
                utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
            else :
                utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $idAnime);
            endif;

        else :

            $generoEscolhido = $formulario['generos'];
            $pedaços = explode(',', $generoEscolhido);

            //verificando se ja tem uma sessao para o generos
            if (!isset($_SESSION["generosList"])) :
                $_SESSION["generosList"] = array();
            endif;

            //verifica se esse genero ja foi adicionado
            if (isset($_SESSION["generosList"][$pedaços[1]])) :
                utilities::mensagenAlerta('ADDGenero', 'o genero ' . $pedaços[0] . ' ja foi adicionado', 'alert alert-danger');

                if ($_SESSION['SEGMENT'] == 'ANIMES') :
                    utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
                else :
                    utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $idAnime);
                endif;


            else :
                $_SESSION["generosList"][$pedaços[1]] = $pedaços[0];
                utilities::mensagenAlerta('ADDGenero', 'Genero adicionado com sucesso', '');

                if ($_SESSION['SEGMENT'] == 'ANIMES') :
                    utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
                else :
                    utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $idAnime);
                endif;
            endif;
        endif;
    }

    public function retirarGenSession($indicacaoPart, $idAnime = null)
    {
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (!isset($formulario['generos'])) :

            utilities::mensagenAlerta('RemovGenero', 'é necessario selecionar um genero para poder Remover o mesmo', 'alert alert-danger');
            if ($_SESSION['SEGMENT'] == 'ANIMES') :
                utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
            else :
                utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $idAnime);
            endif;

        else :
            $generoEscolhido = $formulario['generos'];
            $pedaços = explode(',', $generoEscolhido);

            $id = (int) $pedaços[1];

            unset($_SESSION["generosList"][$id]);
            utilities::mensagenAlerta('RemovGenero', 'Genero retirado com sucesso', '');
            if ($_SESSION['SEGMENT'] == 'ANIMES') :
                utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
            else :
                utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $idAnime);
            endif;
        endif;
    }
}

