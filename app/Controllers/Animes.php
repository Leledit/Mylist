<?php

class Animes extends Controller
{
    public function __construct()
    {
        //função que verifica se o usuario é um adm, se nao for ele é redirecionado
        utilities::verifiUsuarioSessao();
        $this->modelImagen = $this->model('imagen');
        $this->modelGenero = $this->model('genero');
        $this->modelAnime = $this->model('anime');
        $this->modelAnime_has_genero = $this->model('anime_has_genero');
        $this->modelAnime_has_video = $this->model('anime_has_video');
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

        $_SESSION['SEGMENT'] = 'ANIMES';

        $resultado = $this->modelAnime->buscarRegistros($registro_pag, $inicion);
        //pegando a quantidade de registro que temos no banco
        $qtd_registro = $this->modelAnime->retornarQtdRegistro();
        //agora vamos divir pelo numero de iten na tela, para saber quantas paginas vamos ter
        $qtd_registro = $qtd_registro / $registro_pag;

        //verificando se deu um numero fracionario(quer dizer que temos paginas com poucos itens),se tiver devemos acrentar mais um

        if (is_float($qtd_registro)) :
            $qtd_registro = intval($qtd_registro) + 1;
        endif;

        $dados = [
            'animes' => $resultado,
            'pag' => $pag,
            'qtd_pag' => $qtd_registro,

        ];
        $this->view('Adm/index', $dados);
    }
    public function item($id)
    {
        //buscando o anime com base no id que foi passado
        $resultado = [
            'infoAnime' => $this->modelAnime->buscarPorID($id),

        ];
        $resultado['infoGeneros'] = $this->modelAnime_has_genero->buscarPorIdAnime($resultado['infoAnime']->id);
        
        foreach($this->modelAnime_has_video->buscarPorIdAnime($resultado['infoAnime']->id) as $rest):
            if($rest->tipo == 'Opening'):
                $resultado['VideoOpening'][] = $rest;
            else:
                $resultado['VideoClosure'][] = $rest;
                
            endif;
        endforeach;

       
       
        $_SESSION['idItem'] = $id;
        $this->view('Adm/item', $resultado);
    }

   
    public function parteUm($indicacaoPart, $idAnime = null)
    {

        if ($indicacaoPart == 'editar') :
            $infoAnimes = $this->modelAnime->buscarPorID($idAnime);
            $_SESSION["dadosAnime"] = [
                'nome' => $infoAnimes->nome,
                'sinops' => $infoAnimes->sinops,
            ];

        endif;

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $valores = [
                "nome" => trim($formulario["nome"]),
                "sinops" => trim($formulario["Sinops"]),
                "nome_erro" => '',
                "Sinops_erro" => '',
                "imagem_erro" => '',
                "indicacao" => $indicacaoPart,
            ];
            $_SESSION["dadosAnime"] = [
                'nome' => $valores['nome'],
                'sinops' =>  $valores['sinops'],
            ];

            //verificando o campo nome
            if (Validar::tamanhoPermit($_SESSION["dadosAnime"]['nome'])) :
                $valores["nome_erro"] = "Quantidade de caracteres invalidas";
            else :
                if (Validar::apenasCaracteres($_SESSION["dadosAnime"]['nome'])) :
                    $valores["nome_erro"] = "O campo nome aceita apenas caracteres";
                else :
                    //verificando o campo Sinops
                    if (Validar::tamanhoPermitTextArea($_SESSION["dadosAnime"]['sinops'])) :
                        $valores["Sinops_erro"] = "Quantidade de caracteres invalidas";
                    else :
                        //é necessario verificar se a imagem é valida,caso tiver uma
                        if ($_FILES['imagen']['error']) :
                            //se nao tem imagem podemos criar a sessao e proceguir para o proximo formulario
                            $_SESSION["dadosAnime"]['foto'] = null;
                            if ($indicacaoPart == 'cadastro') :
                                utilities::redirecionar('Animes/ParteDois/' . $indicacaoPart);
                            else :
                                $dados = [
                                    'nome' => $_SESSION["dadosAnime"]['nome'],
                                    'sinops' => $_SESSION["dadosAnime"]['sinops'],
                                    'id' => (int) $idAnime,
                                ];
                                if ($this->modelAnime->alterarDados($dados, 1)) :
                                    utilities::redirecionar('Animes/item/' . $idAnime);
                                    utilities::mensagenAlerta('Admitem', 'Edição realizada com sucesso');
                                else :
                                    utilities::redirecionar('Animes/item/' . $idAnime);
                                    utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao alterar os dados do anime', 'alert alert-fall');
                                endif;
                            endif;
                        else :
                            //se tem imagem deve ser feito algumas verificaçoes antes de pegar 
                            $tamanho = $_FILES['imagen']['size'];
                            $tipo = $_FILES['imagen']['type'];
                            $extensao = strtolower(substr($_FILES['imagen']['name'], -4));
                            $imagen = $_FILES['imagen'];
                            $url = 'img/Animes/' . $_SESSION["dadosAnime"]['nome'] . $extensao;
                            $extensaoValida = [
                                '.png',
                                '.PNG',
                                '.jPG',
                                '.jpg',
                                '.jpeg',
                                '.JPEG',
                            ];
                            $tipoValido = [
                                'image/png',
                                'image/PNG',
                                'image/JPG',
                                'image/jpg',
                                'image/jpeg',
                            ];
                            //caso a açao seja editar, deve ser excluido a imagen que ja esta na pasta do servidor
                            if ($indicacaoPart == 'editar') :

                                unlink($infoAnimes->url);
                            endif;
                            if (!in_array($tipo, $tipoValido)) :
                                $valores['imagem_erro'] = 'Tipo de arquivo invalido!! so aceita imagens';
                            else :
                                if (!in_array($extensao, $extensaoValida)) :
                                    $valores['imagem_erro'] = 'Extensao de imagen invalida';
                                else :
                                    if ($tamanho > 2 * (1024 * 1024)) :
                                        $valores['imagem_erro'] = 'Tamanho invalido, imagem muito grande';
                                    else :
                                        //tudo ok com a imagem, posso inserir os dados dela na sessao
                                        $_SESSION["dadosAnime"]['foto'] = $imagen;

                                        //Agora vamos mover a imagem para a pasta do diretorio
                                        $upload = new Upload();
                                        $upload->imagem($imagen, '\Animes', $_SESSION["dadosAnime"]['nome']);
                                        $upload->getResultado();

                                        if ($indicacaoPart == 'cadastro') :
                                            utilities::redirecionar('Animes/ParteDois/' . $indicacaoPart);
                                        else :
                                            //verificando se existe alguma imagem cadastrada no bd para esse anime
                                            $infosImg =  [
                                                'extencao' => $extensao,
                                                'url' => $url,
                                                'tamanho' => $_SESSION["dadosAnime"]['foto']['size'],
                                            ];

                                            if ($infoAnimes->imgID == 0) :
                                                if ($this->modelImagen->Cadastrar($infosImg)) :
                                                    //vamos pegar o id da img cadastrada
                                                    $idImg = $this->modelImagen->UltimoRegistro();
                                                    $idImg = (int) $idImg[0]->id;
                                                endif;
                                            else :

                                                //caso ja tenha registro da imagen, vamos alterar os seus dados
                                                $infosImg['id'] = (int) $infoAnimes->imgID;

                                                $idImg = (int) $infoAnimes->imgID;

                                                if ($this->modelImagen->editarDados($infosImg)) :
                                                //agora vamos alterar os dados do anime
                                                else :
                                                    utilities::redirecionar('Animes/item/' . $idAnime);
                                                    utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao alterar os dados da imagen', 'alert alert-fall');
                                                endif;
                                            endif;

                                            $dados = [
                                                'nome' => $_SESSION["dadosAnime"]['nome'],
                                                'sinops' => $_SESSION["dadosAnime"]['sinops'],
                                                'id' => (int) $idAnime,
                                                'id_img' => $idImg,
                                            ];
                                            if ($this->modelAnime->alterarDados($dados, 1)) :
                                                utilities::redirecionar('Animes/item/' . $idAnime);
                                                utilities::mensagenAlerta('Admitem', 'Edição realizada com sucesso');

                                                //destruindo a sessao que armazena as informaçoes do anime
                                                unset($_SESSION["dadosAnime"]);

                                            else :
                                                utilities::redirecionar('Animes/item/' . $idAnime);
                                                utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao alterar os dados do anime', 'alert alert-fall');
                                            endif;

                                        endif; //verificação da açao de cadastro ou edição
                                    endif;
                                endif;
                            endif;

                        endif;
                    endif; // qtd caracteres do camp sinops
                endif; //fechamento da validação de caracteres do nome
            endif; //qtd caracteres do camp nome
        else :
            $valores = [
                "nome_erro" => '',
                "Sinops_erro" => '',
                "imagem_erro" => '',
                "indicacao" => $indicacaoPart,
            ];
        endif;
        if ($indicacaoPart == "editar") :
            $valores["id_anime"] = $idAnime;
        endif;
        $this->view('Adm/Animes/cadastro', $valores);
    }

    public function ParteDois($indicacaoPart, $idAnime = null)
    {
        if ($indicacaoPart == 'editar') :

            $infoAnimes = $this->modelAnime->buscarPorID($idAnime);
            $_SESSION["dadosAnime"]['qtdEp'] = $infoAnimes->qtd_episodios;
            $_SESSION["dadosAnime"]['qtdFilmes'] = $infoAnimes->filmes;
            $_SESSION["dadosAnime"]['Formato'] = $infoAnimes->formato;
            $_SESSION["dadosAnime"]['anoLancamento'] = $infoAnimes->lancamento;
            $_SESSION["dadosAnime"]['situacao'] = $infoAnimes->estado;
            $_SESSION["dadosAnime"]['tempAnterior'] =  $infoAnimes->anterior_temp;
            $_SESSION["dadosAnime"]['proxTemp'] = $infoAnimes->proxima_temp;
            $_SESSION["dadosAnime"]['qtdOvais'] = $infoAnimes->qtd_oval;
        else :
            $_SESSION["dadosAnime"]['Formato'] = 'Animação japoneza';
            $_SESSION["dadosAnime"]['situacao'] = 'ND';
        endif;
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $valores = [
                'qtdEp_erro' => '',
                'qtdFilmes_erro' => '',
                'Formato_erro' => '',
                'anoLancamento_erro' => '',
                'situacao_erro' => '',
                'tempAnterior_erro' => '',
                'proxTemp_erro' => '',
                'qtdOvais_erro' => '',
                "indicacao" => $indicacaoPart,
            ];
            $_SESSION["dadosAnime"]['qtdEp'] = trim($formulario['qtdEp']);
            $_SESSION["dadosAnime"]['qtdFilmes'] = trim($formulario['qtdFilmes']);
            $_SESSION["dadosAnime"]['Formato'] = $formulario['formato'];
            $_SESSION["dadosAnime"]['anoLancamento'] = trim($formulario['anoLancamento']);
            $_SESSION["dadosAnime"]['situacao'] = $formulario['situacao'];
            $_SESSION["dadosAnime"]['tempAnterior'] =  trim($formulario['tempAnterior']);
            $_SESSION["dadosAnime"]['proxTemp'] = trim($formulario['proxTemp']);
            $_SESSION["dadosAnime"]['qtdOvais'] = trim($formulario['qtdOvais']);

            //iniciando as validaçoes
            if (Validar::apenasNumeros($_SESSION["dadosAnime"]['qtdEp'])) :
                $valores['qtdEp_erro'] = 'So é aceito numeros';
            else :
                if (!Validar::qtdintNumero($_SESSION["dadosAnime"]['qtdEp'], 5)) :
                    $valores['qtdEp_erro'] = 'so é aceito numero com menos de 4 algorismos ';
                else :
                    if (Validar::apenasNumeros($_SESSION["dadosAnime"]['qtdFilmes'])) :
                        $valores['qtdFilmes_erro'] = 'So é aceito numeros';
                    else :
                        if (Validar::apenasNumeros($_SESSION["dadosAnime"]['qtdFilmes'])) :
                            $valores['qtdOvais_erro'] = 'So é aceito numeros';
                        else :
                            if (!Validar::qtdintNumero($_SESSION["dadosAnime"]['qtdFilmes'], 2)) :
                                $valores['qtdFilmes_erro'] = 'so é aceito numero com menos de 2 algorismos';
                            else :
                                if (Validar::apenasCaracteres($_SESSION["dadosAnime"]['tempAnterior'])) :
                                    $valores['tempAnterior_erro'] = 'So é aceito Caracteres';
                                else :
                                    if (Validar::tamanhoPermit($_SESSION["dadosAnime"]['tempAnterior'])) :
                                        $valores['tempAnterior_erro'] = 'Numero de caracteres invalidos ';
                                    else :
                                        if (Validar::apenasCaracteres($_SESSION["dadosAnime"]['proxTemp'])) :
                                            $valores['proxTemp_erro'] = 'So é aceito Caracteres';
                                        else :
                                            if (Validar::tamanhoPermit($_SESSION["dadosAnime"]['proxTemp'])) :
                                                $valores['proxTemp_erro'] = 'Numero de caracteres invalidos ';
                                            else :
                                                if ($indicacaoPart == 'editar') :

                                                    //vamos editar as infomaçoes do anime
                                                    $dados = [
                                                        'eps' => $_SESSION["dadosAnime"]['qtdEp'],
                                                        'filmes' => $_SESSION["dadosAnime"]['qtdFilmes'],
                                                        'formato' => $_SESSION["dadosAnime"]['Formato'],
                                                        'lancamento' => $_SESSION["dadosAnime"]['anoLancamento'],
                                                        'situacao' => $_SESSION["dadosAnime"]['situacao'],
                                                        'tempAnterior' => $_SESSION["dadosAnime"]['tempAnterior'],
                                                        'proxTemp' => $_SESSION["dadosAnime"]['proxTemp'],
                                                        'ovais' => $_SESSION["dadosAnime"]['qtdOvais'],
                                                        'id' => (int) $idAnime,
                                                    ];
                                                    if ($this->modelAnime->alterarDados($dados, 2)) :
                                                        utilities::redirecionar('Animes/item/' . $idAnime);
                                                        utilities::mensagenAlerta('Admitem', 'Edição realizada com sucesso');

                                                        //destruindo a sessao que armazena as informaçoes do anime
                                                        unset($_SESSION["dadosAnime"]);
                                                    else :
                                                        utilities::redirecionar('Animes/item/' . $idAnime);
                                                        utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao alterar os dados do anime', 'alert alert-fall');
                                                    endif;
                                                else :
                                                    utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart);
                                                endif;
                                            endif;
                                        endif;
                                    endif; //campo tempAnterior(qtd caracteres)
                                endif; //campo tempAnterior(String)
                            endif;
                        endif;
                    endif;
                endif;
            endif; // campo qtdEp(int)
        else :
            $valores = [
                'qtdEp_erro' => '',
                'qtdFilmes_erro' => '',
                'Formato_erro' => '',
                'anoLancamento_erro' => '',
                'situacao_erro' => '',
                'tempAnterior_erro' => '',
                'proxTemp_erro' => '',
                'qtdOvais_erro' => '',
                "indicacao" => $indicacaoPart,
            ];
        endif;
        $valores["id_anime"] = $idAnime;
        $this->view('Adm/Animes/cadastro2', $valores);
    }
    public function ParteTres($indicacaoPart, $idAnime = null)
    {
        if (!isset($_SESSION['RESULTBUSC'])) :
            $_SESSION['RESULTBUSC'] = '';
        endif;
        if ($indicacaoPart != 'cadastro') :
            if (!isset($_SESSION["generosList"])) :
                //vamos buscar todos os generos vinculados com o anime
                $resultado = $this->modelAnime_has_genero->exibirIdAnime($idAnime);

                foreach ($resultado as $res) :
                    $_SESSION["generosList"][$res->id] = $res->nome;
                endforeach;
            endif;
        endif;
        $dados = [
            'indicacao' => $indicacaoPart,
            'id_anime' => $idAnime,
        ];
        $this->view('Adm/Animes/cadastro3', $dados);
    }
    public function PartFinal($indicacaoPart, $idAnime = null)
    {
        if ($indicacaoPart == 'cadastro') :
            if (isset($_SESSION["generosList"])) :
                if (!empty($_SESSION["generosList"])) :
                    if ($_SESSION["dadosAnime"]['foto'] == null) :
                        //como nao tem imagem o id da imagem vai ser 0
                        $idImg = (int) 0;
                    else :
                        //se tem foto essa vai ser cadastrada 
                        $extensao = strtolower(substr($_SESSION["dadosAnime"]['foto']['name'], -4));
                        $url = 'img/Animes/' . $_SESSION["dadosAnime"]['nome'] . $extensao;
                        $dados = [
                            'extencao' => $extensao,
                            'url' => $url,
                            'tamanho' => $_SESSION["dadosAnime"]['foto']['size'],
                            
                        ];
                        if ($this->modelImagen->Cadastrar($dados)) :
                            //vamos pegar o id da img cadastrada
                            $idImg = $this->modelImagen->UltimoRegistro();
                            $idImg = (int) $idImg[0]->id;
                        else :
                            utilities::redirecionar('Animes/index');
                            utilities::mensagenAlerta('AdmPrincipal', 'Erro ao cadastrar a imagem do anime', 'alert alert-fall');
                        endif;
                    endif;
                    $dados = [
                        'id_imagem' => $idImg,
                        'qtd_episodios' => (int)$_SESSION["dadosAnime"]['qtdEp'],
                        'filmes' => (int) $_SESSION["dadosAnime"]['qtdFilmes'],
                        'ano_lancamento' => $_SESSION["dadosAnime"]['anoLancamento'],
                        'nome' => $_SESSION["dadosAnime"]['nome'],
                        'sinops' => $_SESSION["dadosAnime"]['sinops'],
                        'proxima_temp' => $_SESSION["dadosAnime"]['proxTemp'],
                        'anterior_temp' => $_SESSION["dadosAnime"]['tempAnterior'],
                        'estado' => $_SESSION["dadosAnime"]['situacao'],
                        'formato' => $_SESSION['dadosAnime']['Formato'],
                        'qtdOvais' =>  (int)$_SESSION["dadosAnime"]['qtdOvais'],
                    ];
                    if ($this->modelAnime->Cadastrar($dados)) :

                        //Agora vamos cadastrar os generos vinculados com o anime
                        $id_anime = $this->modelAnime->UltimoRegistro();

                        $ids = array_keys($_SESSION["generosList"]);
                        foreach ($ids as $id) :

                            $dados = [
                                'id' => (int)$id_anime[0]->id,
                                'genero' => $id,
                            ];
                            $this->modelAnime_has_genero->Cadastrar($dados);
                        endforeach;
                        utilities::redirecionar('Animes/index');
                        utilities::mensagenAlerta('AdmPrincipal', 'Anime cadastrado com sucesso', '');
                    else :
                        utilities::redirecionar('Animes/index');
                        utilities::mensagenAlerta('AdmPrincipal', 'Erro ao cadastrar o anime', 'alert alert-fall');
                    endif;

                    //destruindo a sessao contendo os dados das categorias
                    unset($_SESSION["generosList"]);

                    //destruindo a sessao que armazena as informaçoes do anime
                    unset($_SESSION["dadosAnime"]);

                    //Destruindo a sessao de busca de generos
                    unset($_SESSION['Resultados']);

                else :
                    utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart);
                    utilities::mensagenAlerta('RemovGenero', 'Para finalizar o cadastro é necessario escolher ao menos uma categoria');
                endif;
            else :
                utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart);
                utilities::mensagenAlerta('RemovGenero', 'Para finalizar o cadastro é necessario escolher ao menos uma categoria');
            endif;
        else :
            if (isset($_SESSION["generosList"])) :
                if (!empty($_SESSION["generosList"])) :
                    //vamos buscar todos os generos vinculados com o anime
                    $resultado = $this->modelAnime_has_genero->exibirIdAnime($idAnime);

                    //agora vamos pegar o tamanho das nossas arrays
                    $Tbd = sizeof($resultado);
                    $Tsesion = sizeof($_SESSION["generosList"]);
                    $voltas = 0;

                    //pegando os ids(ids)do array
                    $ids = array_keys($_SESSION["generosList"]);
                    //pegando os dados do banco e jogando em uma array de numeros
                    for ($i = 0; $i < $Tbd; $i++) :
                        $arrarBd[$i] = (int) $resultado[$i]->id;
                    endfor;

                    //verificando se algum dado da array $_SESSION nao esta no banco, se nao tiver esse dever ser adicionado
                    for ($i = 0; $i < $Tsesion; $i++) :
                        if (!in_array($ids[$i], $arrarBd)) :
                            $dados = [
                                'id' => $idAnime,
                                'genero' => $ids[$i],
                            ];
                            if (!$this->modelAnime_has_genero->Cadastrar($dados)) :
                                utilities::redirecionar('Animes/item/' . $idAnime);
                                utilities::mensagenAlerta('Admitem', 'Erro desconhecido ao Cadastrar um genero ', 'alert alert-fall');
                            endif;
                        endif;
                    endfor;

                    //verificando se algum dado da array do bd  nao esta na sessao, se nao tiver esse deve ser excluido 
                    for ($i = 0; $i < $Tbd; $i++) :
                        if (!in_array($arrarBd[$i], $ids)) :

                            $id_has = $this->modelAnime_has_genero->buscIdAnimeGen($idAnime, $arrarBd[$i]);
                            if (!$this->modelAnime_has_genero->deletar($id_has[0]->id)) :
                                utilities::redirecionar('Animes/item/' . $idAnime);
                                utilities::mensagenAlerta('Admitem', 'Erro desconhecido ao deletar um genero ', 'alert alert-fall');
                            endif;

                        endif;

                    endfor;

                    utilities::redirecionar('Animes/item/' . $idAnime);
                    utilities::mensagenAlerta('Admitem', 'Edição realizada com sucesso');

                    unset($_SESSION["generosList"]);
                    unset($_SESSION['Resultados']);
                else :
                    utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
                    utilities::mensagenAlerta('RemovGenero', 'Para finalizar o cadastro é necessario escolher ao menos uma categoria');
                endif;
            else :
                utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
                utilities::mensagenAlerta('RemovGenero', 'Para finalizar o cadastro é necessario escolher ao menos uma categoria');
            endif;

        endif;
    }

    public function buscarGenero($indicacaoPart, $idAnime = null)
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_SANITIZE_STRING);

        $indicacao = 'Animes';
        if (!empty($busca)) :

            $resultado = $this->modelGenero->buscar($busca, $indicacao);

            if (empty($resultado)) :
                $_SESSION['RESULTBUSC'] = 'not';
            else :
                $_SESSION['RESULTBUSC'] = 'yes';
                $_SESSION['Resultados'] = $resultado;
            endif;
            utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
        else :
            unset($_SESSION['RESULTBUSC']);
            utilities::mensagenAlerta('BuscaGenero', 'Para buscar é necessario prencher o campo Buscar', 'alert alert-danger');
            utilities::redirecionar('Animes/ParteTres/' . $indicacaoPart . '/' . $idAnime);
            if (isset($_SESSION['Resultados'])) :
                unset($_SESSION['Resultados']);
            endif;
        endif;
    }
    public function openigenceramentos()
    {
        $this->view('Adm/Animes/OpeningEnceramentos');
    }
    public function excluirItem($id)
    {
        //primeiro vamos buscar o id da imagem que deve ser excluido
        $dadosImg = $this->modelAnime->buscarInfoImg($id);
        if ($this->modelImagen->deletar($dadosImg->id)) :
            //agora vamos apagar a imagem da pasta do servidor
            unlink($dadosImg->url);
            if ($this->modelAnime->deletar($id)) :
                utilities::redirecionar('Animes');
                utilities::mensagenAlerta('AdmPrincipal', 'Anime Excluindo  com sucesso', '');
            else :
                utilities::redirecionar('Animes');
                utilities::mensagenAlerta('AdmPrincipal', 'Erro ao realizar a exclusao', 'alert alert-danger');
            endif;
        else :
            utilities::redirecionar('Animes');
            utilities::mensagenAlerta('AdmPrincipal', 'Erro ao realizar a exclusao da imagem do anime', 'alert alert-danger');
        endif;
    }
}
