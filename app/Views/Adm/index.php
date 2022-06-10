<!-- incluindo o menu superior do usuario-->
<?php include '../app/Views/componente/menu_adm.php'; ?>
<!-- verificando o segmento atual do site-->
<?php
if ($_SESSION['SEGMENT'] == 'ANIMES') :
    $indicadorDados = 'animes';
    $indicadorControler = 'Animes';
else :
    $indicadorDados = 'filmes';
    $indicadorControler = 'FilmesSeries';
endif;
?>
<div class="container-fluid">
    <div class="row">
        <!--Nessa coluna sera armazenada a barra de açoes do administrador-->
        <div class="col-xl-3 col-md-4 col-sm-4  adm-bar">
            <?php include '../app/Views/componente/barra-adm.php'; ?>
        </div>
        <!-- Nesta coluna esta sendo armazenada os dados armazenados em banco-->
        <div class="col-xl-9 col-md-8 col-sm-8">
            <!--Conteudo da parte principal do site-->
            <div class="col">
                <div class="mt-4" role="alert">
                    <?= utilities::mensagenAlerta('AdmPrincipal') ?>
                </div>
                <!--bloco de conteudo-->
                <div class="list-content-adm container ">
                    <div class="adm-add-record row">
                        <div class="col-xl-10 col-md-9 col-sm-8  ">
                            <h4>Todos os titulos</h4>
                        </div>

                        <div class=" col-xl col-md col-sm " id="adm-add-record-add">
                            <a href="<?= URL ?>/<?= $indicadorControler ?>/parteUm/cadastro">Adicionar</a>
                        </div>
                    </div>




                    <?php
                    if (isset($_SESSION['ListaGen'])) :

                    ?>
                        <p>Todos os titulos do genero <span><?php echo $_SESSION['ListaGeNome']->nome ?></span></p>
                    <?php endif; ?>


                    <div class="row">

                        <!-- item da pagina -->
                        <?php
                        foreach ($dados[$indicadorDados] as $dado) :
                        ?>
                            <div class="content-usu-unit col-xl-3 col-lg-4 col-md-5 col-sm-11 ms-md-4 ms-sm-4 ms-xl-0 mx-lg-0">
                                <a href="<?= URL ?>/<?= $indicadorControler ?>/item/<?= $dado->id?>">
                                    <div class="content-usu-unit-img">
                                        <img src="<?= URL ?>/<?= $dado->imgID == 0 ? 'img/padrao.jpg' : $dado->url  ?>" class="">
                                    </div>
                                    <div class="content-usu-unit-name">
                                        <?= utilities::resumirTexto($dado->nome, 6)  ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <div class="content-usu-pag">
                        <p>Paginas </p>
                        <?php
                        if ($dados['pag'] > 3) :
                            $inicio =  $dados['pag'] - 2;
                        ?>
                            <div class="content-usu-pag-item <?= $dados['pag'] == 1 ? 'pag-item-active' : '' ?>">
                                <a href="<?= URL ?>/<?= $indicadorControler ?>/index/">1</a>
                            </div>
                        <?php
                        else :
                            $inicio =  1;
                        endif;

                        if ($dados['pag'] > 4) :
                            echo '<p>...</p>';
                        endif;
                        if ($dados['qtd_pag'] - $dados['pag'] > 2) :
                            $fim =  $dados['pag'] + 2;
                        else :
                            $fim =  $dados['qtd_pag'];
                        endif;
                        $cont = 1;
                        //echo 'inicio: ' . $inicio . ' fim: ' . $fim . ' cont: ' . $cont;
                        for ($i = $inicio; $i <= $fim; $i++) {
                            $valor = $i;
                        ?>
                            <div class="content-usu-pag-item <?= $dados['pag'] == $i ? 'pag-item-active' : '' ?>">
                                <a href="<?= URL ?>/<?= $indicadorControler ?>/index/<?= $valor  ?>"><?= $i ?></a>
                            </div>

                        <?php
                        }
                        if ($dados['qtd_pag'] - $dados['pag'] > 3) :
                            echo '<p>...</p>';
                        endif;
                        if ($dados['qtd_pag'] - $dados['pag'] > 2) :
                        ?>
                            <div class="content-usu-pag-item <?= $dados['pag'] == $dados['qtd_pag'] ? 'pag-item-active' : '' ?>">
                                <a href="<?= URL ?>/<?= $indicadorControler ?>/index/<?= $dados['qtd_pag'] ?>"><?= $dados['qtd_pag'] ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!--fechamento do Segundo bloco de conteudo-->
            </div>
            <!--fechamento do container que armazena o conteudo do site-->


        </div>
    </div>
</div>