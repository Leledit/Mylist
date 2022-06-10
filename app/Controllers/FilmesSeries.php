<?php

class FilmesSeries extends Controller
{

    public function __construct()
    {
        //função que verifica se o usuario é um adm, se nao for ele é redirecionado
        utilities::verifiUsuarioSessao();
        $this->modelAnime = $this->model('anime');
        $this->modelFilmes = $this->model('filmes');
        $this->modelGenero = $this->model('genero');
        $this->modelImagen = $this->model('imagen');
        $this->modelfilmesHgeneros = $this->model('filmes_has_genero');
    }
    public function index($pagina = null)
    {
        $_SESSION['SEGMENT'] = 'FILMESSERIES';
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

        $resultado = $this->modelFilmes->buscarRegistros($registro_pag, $inicion);
        //pegando a quantidade de registro que temos no banco
        $qtd_registro = $this->modelFilmes->retornarQtdRegistro();
        //agora vamos divir pelo numero de iten na tela, para saber quantas paginas vamos ter
        $qtd_registro = $qtd_registro / $registro_pag;

        //verificando se deu um numero fracionario(quer dizer que temos paginas com poucos itens),se tiver devemos acrentar mais um
        if (is_float($qtd_registro)) :
            $qtd_registro = intval($qtd_registro) + 1;
        endif;

        $dados = [
            'filmes' => $resultado,
            'pag' => $pag,
            'qtd_pag' => $qtd_registro,

        ];

        $this->view('Adm/index', $dados);
    }

    public function item($id)
    {
        //buscando o filme selecionado 
        $resultado = [
            'infofilmes' => $this->modelFilmes->buscarPorID($id),
            'infoVideos' => null
        ];
        $resultado['infoGeneros'] = $this->modelfilmesHgeneros->buscarPorIdFilme($resultado['infofilmes']->id);
        $this->view('Adm/item', $resultado);
    }
    public function parteUm($indicacaoPart, $id = null)
    {
        if ($indicacaoPart == 'editar') :

            $resultado = $this->modelFilmes->buscarPorID($id);
            $_SESSION['infoFilmes'] = [
                'nome' => $resultado->nome,
                'sinops' => $resultado->sinops,
                'lancamento' => $resultado->lancamento,
                'duracao' => $resultado->duracao,
            ];
        endif;

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            $valores = [
                'nome' => $formulario['nome'],
                'sinops' => $formulario['Sinops'],
                'lancamento' => $formulario['lancamento'],
                'duracao' => $formulario['duracao'],
                'id_img' => 0,
                'img' => $_FILES,
                'nome_erro' => '',
                'Sinops_erro' => '',
                'lancamento_erro' => '',
                'duracao_erro' => '',
                'img_erro' => '',
                'indicacaoPart' => $indicacaoPart,
            ];

            //adicionando os dados na sessao
            $_SESSION['infoFilmes'] = [
                'nome' => $valores['nome'],
                'sinops' => $valores['sinops'],
                'lancamento' => $valores['lancamento'],
                'duracao' => $valores['duracao'],
            ];
            //verificando o campo nome
            if (Validar::tamanhoPermit($valores['nome'])) :
                $valores["nome_erro"] = "Quantidade de caracteres invalidas";
            else :
                if (Validar::apenasCaracteres($valores['nome'])) :
                    $valores["nome_erro"] = "O campo nome aceita apenas caracteres";
                else :
                    //verificando o campo Sinops
                    if (Validar::tamanhoPermitTextArea($valores['sinops'])) :
                        $valores["Sinops_erro"] = "Quantidade de caracteres invalidas";
                    else :
                        if (Validar::tamanhoPermit($valores['lancamento'])) :
                            $valores["lancamento_erro"] = "Quantidade de caracteres invalidas";
                        else :
                            if (Validar::tamanhoPermit($valores['duracao'])) :
                                $valores["duracao_erro"] = "Quantidade de caracteres invalidas";
                            else :
                                if ($_FILES['imagem']['error']) :
                                    //vai entrar aqui caso nao tenha imagem

                                    $_SESSION['infoFilmes']['img'] = null;
                                else :
                                    //vai entrar aqui caso tenha imagem
                                    $_SESSION['infoFilmes']['img'] = $_FILES;

                                    $tamanho = $_FILES['imagem']['size'];
                                    $tipo = $_FILES['imagem']['type'];
                                    $extensao = strtolower(substr($_FILES['imagem']['name'], -4));
                                    $imagen = $_FILES['imagem'];
                                    $url = 'img/filmes/' . $valores['nome'] . $extensao;
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
                                    if (!in_array($tipo, $tipoValido)) :
                                        $valores['imagem_erro'] = 'Tipo de arquivo invalido!! so aceita imagens';
                                    else :
                                        if (!in_array($extensao, $extensaoValida)) :
                                            $valores['imagem_erro'] = 'Extensao de imagen invalida';
                                        else :
                                            if ($tamanho > 2 * (1024 * 1024)) :
                                                $valores['imagem_erro'] = 'Tamanho invalido, imagem muito grande';
                                            else :

                                                //Movendo a imagem
                                                $imagen = $_SESSION['infoFilmes']['img']['imagem'];
                                                //Agora vamos mover a imagem para a pasta do diretorio
                                                $upload = new Upload();
                                                $upload->imagem($imagen, '\Filmes', $_SESSION["infoFilmes"]['nome']);
                                                $upload->getResultado();
                                            endif; //verificaçoes relacionadas com a imagem
                                        endif; //verificaçoes relacionadas com a imagem 
                                    endif; //verificaçoes relacionadas com a imagem
                                endif; //fechaemento daverificação da existencia da imagem

                                if ($indicacaoPart == 'cadastro') :
                                    utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart);
                                else :

                                    //editando a imagem
                                    if (!$_FILES['imagem']['error']) :

                                        $imagem = $this->modelImagen->buscarPorID($resultado->imgID);
                                        //apagando a imagem antiga;
                                        unlink($imagem->url);
                                       
                                       
                                    var_dump($resultado);
                                  
                                      

                                       
                                        $infosImg =  [
                                            'extencao' => $extensao,
                                            'url' => $url,
                                            'tamanho' => $tamanho,
                                            'id' => $imagem->id,
                                        ];
                                        var_dump($infosImg);
                                  

                                        if ($this->modelImagen->editarDados($infosImg)) :
                                        else :
                                            utilities::redirecionar('filmesSeries/item/' . $id);
                                            utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao alterar os dados da imagen', 'alert alert-fall');
                                        endif;
                                    endif;

                                    //agora vamos alterar os dados do filme
                                    $dados = [
                                        'nome' => $_SESSION['infoFilmes']['nome'],
                                        'sinops' => $_SESSION['infoFilmes']['sinops'],
                                        'duracao' => $_SESSION['infoFilmes']['duracao'],
                                        'lancamento' => $_SESSION['infoFilmes']['lancamento'],
                                        'id' => $id,
                                    ];

                                    if ($this->modelFilmes->atualizarDados($dados)) :
                                        utilities::redirecionar('filmesSeries/item/' . $id);
                                        utilities::mensagenAlerta('Admitem', 'Filme alterado com sucesso');

                                        //destruindo a sessao que armazena o filme
                                   //     unset($_SESSION['infoFilmes']);
                                    else :
                                        utilities::redirecionar('filmesSeries/item/' . $id);
                                        utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao alterar os dados do filme', 'alert alert-fall');
                                    endif;
                                endif;
                             
                           
                            endif; //fechamento do campo duracao
                        endif; //verificação do campo lancamento
                    endif; //verificação do campo sinops
                endif; //verificação do campo nome
            endif; //verificação do campo nome
        else :

            //Caso nao exista o formularios 
            $valores = [
                'nome' => '',
                'sinops' => '',
                'lancamento' => '',
                'duracao' => '',
                'img' => '',
                'nome_erro' => '',
                'Sinops_erro' => '',
                'lancamento_erro' => '',
                'duracao_erro' => '',
                'img_erro' => '',
                'indicacaoPart' => $indicacaoPart,
            ];
        endif;

        // $valores['indicacaoPart']= $indicacaoPart;
        if ($indicacaoPart == 'editar') :
            $valores['id'] = $id;
        endif;
        $valores['indicacao'] = $indicacaoPart;

        $this->view('Adm/FilmesSeries/cadastro', $valores);
    }

    public function parteDois($indicacaoPart, $idfilmes = null)
    {
        $dados = [
            'indicacao' => $indicacaoPart,
        ];

        if ($indicacaoPart == 'editar') :

            //setando o id do filme
            $dados['idFilme'] = $idfilmes;
            if (!isset($_SESSION["generosList"])) :
                //vamos buscar todos os generos vinculados com o anime
                $resultado = $this->modelfilmesHgeneros->exibirIdfilmes($idfilmes);

                foreach ($resultado as $res) :
                    $_SESSION["generosList"][$res->id] = $res->nome;
                endforeach;
            endif;
        endif;

        if (!isset($_SESSION['RESULTBUSC'])) :
            $_SESSION['RESULTBUSC'] = '';
        endif;

        $this->view('Adm/FilmesSeries/cadastro2', $dados);
    }

    public function PartFinal($indicacaoPart, $id = null)
    {
         if (isset($_SESSION["generosList"])) :
            if (!empty($_SESSION["generosList"])) :
                if ($indicacaoPart == 'cadastro') :
                    if ($_SESSION["infoFilmes"]['img'] == null) :
                        //como nao tem imagem o id da imagem vai ser 0
                        $idImg = (int) 0;
                    else :
                        //se tem foto essa vai ser cadastrada 
                        $extensao = strtolower(substr($_SESSION['infoFilmes']['img']['imagem']['name'], -4));
                        $url = 'img/Filmes/' . $_SESSION['infoFilmes']['nome'] . $extensao;

                        //cadastrando o filme
                        $infosImg =  [
                            'extencao' => $extensao,
                            'url' => $url,
                            'tamanho' => $_SESSION['infoFilmes']['img']['imagem']['size'],
                        ];

                        if ($this->modelImagen->Cadastrar($infosImg)) :
                            //vamos pegar o id da img cadastrada
                            $idImg = $this->modelImagen->UltimoRegistro();
                            $idImg = (int) $idImg[0]->id;
                            
                        else :
                            
                            utilities::redirecionar('filmesSeries/');
                            utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao cadastrar a imagem ', 'alert alert-fall');
                        endif;
                    endif;
                    $valores = [
                        'nome' => $_SESSION['infoFilmes']['nome'],
                        'sinops' => $_SESSION['infoFilmes']['sinops'],
                        'lancamento' => $_SESSION['infoFilmes']['lancamento'],
                        'duracao' => $_SESSION['infoFilmes']['duracao'],
                        'id_img' => $idImg,
                    ];

                    if ($this->modelFilmes->Cadastrar($valores)) :

                        //Agora vamos cadastrar os generos vinculados com o anime
                        $id_filme =  $this->modelFilmes->UltimoRegistro();

                        $ids = array_keys($_SESSION["generosList"]);
                        foreach ($ids as $id) :

                            $dados = [
                                'id' => (int)$id_filme[0]->id,
                                'genero' => $id,
                            ];
                            $this->modelfilmesHgeneros->Cadastrar($dados);

                        endforeach;
                        utilities::redirecionar('filmesSeries');
                        utilities::mensagenAlerta('AdmPrincipal', 'Filme cadastrado com sucesso', '');

                    else :
                        utilities::redirecionar('filmesSeries/');
                        utilities::mensagenAlerta('Admitem', 'Erro Desconhecido ao cadastrar o filme', 'alert alert-fall');
                    endif;



                    //destruindo a sessao contendo os dados das categorias
                    unset($_SESSION["infoFilmes"]);

                    //destruindo a sessao que armazena as informaçoes do anime
                    unset($_SESSION["dadosAnime"]);

                    //Destruindo a sessao de busca de generos
                    unset($_SESSION['Resultados']);
                    
                else :

                    //editando a imagem
                    if (isset($_SESSION["generosList"])) :
                        if (!empty($_SESSION["generosList"])) :

                            //vamos buscar todos os generos vinculados com o anime
                            $resultado = $this->modelfilmesHgeneros->exibirIdfilmes($id);

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
                                        'id' => $id,
                                        'genero' => $ids[$i],
                                    ];

                                    if (!$this->modelfilmesHgeneros->Cadastrar($dados)) :
                                        utilities::redirecionar('filmesSeries/item/' . $id);
                                        utilities::mensagenAlerta('Admitem', 'Erro desconhecido ao Cadastrar um genero ', 'alert alert-fall');
                                    endif;
                                endif;
                            endfor;
                            //verificando se algum dado da array do bd  nao esta na sessao, se nao tiver esse deve ser excluido 
                            for ($i = 0; $i < $Tbd; $i++) :
                                if (!in_array($arrarBd[$i], $ids)) :

                                    $id_has = $this->modelfilmesHgeneros->buscIdFilmeGen($id, $arrarBd[$i]);
                                    if (!$this->modelfilmesHgeneros->deletar($id_has[0]->id)) :
                                        utilities::redirecionar('filmesSeries/item/' . $id);
                                        utilities::mensagenAlerta('Admitem', 'Erro desconhecido ao deletar um genero ', 'alert alert-fall');
                                    endif;
                                //aqui vai ser excluido o item
                                endif;

                            endfor;
                            utilities::redirecionar('filmesSeries/item/' . $id);
                            utilities::mensagenAlerta('Admitem', 'Edição realizada com sucesso');

                            unset($_SESSION["generosList"]);
                            unset($_SESSION['Resultados']);
                        else :
                            utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $id);
                            utilities::mensagenAlerta('RemovGenero', 'Para finalizar o cadastro é necessario escolher ao menos uma categoria');
                        endif;
                    else :
                        utilities::redirecionar('filmesSeries/ParteDois/' . $indicacaoPart . '/' . $id);
                        utilities::mensagenAlerta('RemovGenero', 'Para finalizar o cadastro é necessario escolher ao menos uma categoria');
                    endif;
                endif;
            endif;
        endif;
        
    }
    public function buscarGenero($indicacaoPart, $idFilme = null)
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_SANITIZE_STRING);

        if (!empty($busca)) :
            $tabela = 'filmes';
            $resultado = $this->modelGenero->buscar($busca, $tabela);
            if (empty($resultado)) :
                $_SESSION['RESULTBUSC'] = 'not';
            else :
                $_SESSION['RESULTBUSC'] = 'yes';
                $_SESSION['Resultados'] = $resultado;
            endif;
            utilities::redirecionar('FilmesSeries/parteDois/' . $indicacaoPart . '/' . $idFilme);
        else :
            unset($_SESSION['RESULTBUSC']);
            utilities::mensagenAlerta('BuscaGenero', 'Para buscar é necessario prencher o campo Buscar', 'alert alert-fall');
            utilities::redirecionar('FilmesSeries/parteDois/' . $indicacaoPart . '/' . $idFilme);
            if (isset($_SESSION['Resultados'])) :
                unset($_SESSION['Resultados']);
            endif;
        endif;
    }

    public function excluirItem($id)
    {
        //primeiro vamos buscar o id da imagem que tambem deve ser excluida
        $dadosFilme = $this->modelFilmes->buscarIDimg($id);

        
        //agora vamos deletar o registro do banco de dados
        if ($this->modelImagen->deletar($dadosFilme->id)) :
            //apagando a imagem da pasta do servidor
            unlink($dadosFilme->url);
            if ($this->modelFilmes->deletar($id)) :
                utilities::redirecionar('filmesSeries');
                utilities::mensagenAlerta('AdmPrincipal', 'Filme Excluindo  com sucesso', '');
                


            else :
                utilities::redirecionar('filmesSeries');
                utilities::mensagenAlerta('AdmPrincipal', 'Erro ao realizar a exclusao', 'alert alert-danger');
            endif;
        else :
            utilities::redirecionar('filmesSeries');
            utilities::mensagenAlerta('AdmPrincipal', 'Erro ao realizar a exclusao da img do bd', 'alert alert-danger');
        endif;
    }
}
