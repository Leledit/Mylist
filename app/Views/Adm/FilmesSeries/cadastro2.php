<!-- incluindo o menu superior do usuario-->
<?php include '../app/Views/componente/menu_adm.php'; ?>
<div class="container-fluid">
    <div class="row">
        <!--Nessa coluna sera armazenada a barra de açoes do administrador-->
        <div class="col-xl-3 col-md-4 col-sm-4  adm-bar">
            <?php include '../app/Views/componente/barra-adm.php'; ?>
        </div>
        <!-- Nesta coluna esta sendo armazenada os dados armazenados em banco-->
        <div class="col-xl-9 col-md-8 col-sm-8">
            <div class="row">
                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12"></div>
                <div class="col-xl-10 col-lg-9 col-md-10 col-sm-12">
                    <div class="adm-forme container mx-2 ">
                        <div class="adm-espacing">.</div>
                        <h1 class="mt-2 mb-3">Cadastrando Filmes/Serie(Parte 2)</h1>
                        <div class="container">
                            <h2>Adicionar genero</h2>
                            <form class="d-flex col-6 " method="POST" action="<?= URL ?>/filmesSeries/buscarGenero/<?= $dados['indicacao'] ?>/<?= $dados['indicacao'] == 'editar' ? $dados['idFilme'] : '' ?>">
                                <input class="form-control me-2" type="search" placeholder="Buscar" name="busca">
                                <button class="btn btn-outline-secondary" type="submit" name="enviar">Pesquisar</button>
                            </form>
                        </div>
                        <!--mensagem caso tenha sido feito uma busca vazia-->
                        <div class="mt-4" role="alert">
                            <?= utilities::mensagenAlerta('BuscaGenero') ?>
                        </div>
                        <!--exibindo os resultados da busca-->
                        <div class="container">
                            <?php if ($_SESSION['RESULTBUSC'] == 'not') : ?>
                                <div class="alert alert-danger"> Nenhum resultado Encontrado</div>

                                <?php else :
                                if ($_SESSION['RESULTBUSC'] == 'yes') : ?>
                                    <div class="container">
                                        <form method="POST" name="adiconarGenero" action="<?= URL ?>/generos/AddGenSession/<?= $dados['indicacao'] ?>/<?= $dados['indicacao'] == 'editar' ? $dados['idFilme'] : '' ?>">
                                            <h2>Resultados da Busca</h2>
                                            <div class="row ">
                                                <?php
                                                if (isset($_SESSION['Resultados'])) :
                                                    $qtdResult = sizeof($_SESSION['Resultados']);
                                                    for ($i = 0; $i < $qtdResult; $i++) :
                                                ?>
                                                        <div class="adm-forme-gen-item col-smp-80 col-xl-3 col-md-5 col-sm-5 mb-4 ">
                                                            <label for="<?= $_SESSION['Resultados'][$i]->id ?>"><?= $_SESSION['Resultados'][$i]->nome ?></label>
                                                            <input type="radio" name="generos" value="<?= $_SESSION['Resultados'][$i]->nome . ',' . $_SESSION['Resultados'][$i]->id ?>" id="<?= $_SESSION['Resultados'][$i]->id ?>" />
                                                            <div class="adm-forme-gen-item-visible"></div>
                                                        </div>
                                                <?php endfor;

                                                endif; ?>
                                            </div>
                                            <div class="col"><button class="btn btn-outline-secondary" type="submit" value="Adicionar" name="enviar">Adicionar</button></div>
                                        </form>
                                    </div>
                            <?php
                                endif;
                            endif; ?>
                            <!--mensagem dizendo que foi adicionado o genero ao item-->
                            <div class="mt-4" role="alert">
                                <?= utilities::mensagenAlerta('ADDGenero') ?>
                            </div>
                            <hr>
                            <div class="container">
                                <h2>Generos adicionados</h2>
                                <form method="POST" name="retirarGenero" action="<?= URL ?>/generos/retirarGenSession/<?= $dados['indicacao'] ?>/<?= $dados['indicacao'] == 'editar' ? $dados['idFilme'] : '' ?>">
                                    <div class="row">
                                        <?php

                                        if (isset($_SESSION["generosList"])) :
                                            $qtdRegistros = sizeof($_SESSION["generosList"]);

                                            $ids = array_keys($_SESSION["generosList"]);
                                            foreach ($ids as $id) :
                                        ?>

                                                <div class="adm-forme-gen-item col-smp-80 col-xl-3 col-md-5 col-sm-5 mb-4">
                                                    <label for="<?= $_SESSION["generosList"][$id] ?>"><?= $_SESSION["generosList"][$id] ?></label>
                                                    <input type="radio" name="generos" value="<?= $_SESSION["generosList"][$id] . ' , ' . $id ?>" id="<?= $_SESSION["generosList"][$id] ?>" />
                                                    <div class="adm-forme-gen-item-visible"></div>
                                                </div>
                                                <!--fechamento da class"animes-gen-adds-item"-->

                                        <?php endforeach;

                                        endif; ?>
                                    </div>
                                    <!--fechamento da class"animes-gen-adds-item"-->
                            </div>
                            <div class="col"><button class="btn btn-outline-secondary" type="submit" value="Remover" name="enviar">Remover</button></div>
                            </form>

                        </div>
                        <hr>
                     
                        <div class="row mt-4 ms-3 ">
                            <div class="col "><a class="btn btn-outline-secondary" href="<?= URL ?>/filmesSeries/parteUm/<?= $dados['indicacao'] ?>">Voltar</a></div>
                            <div class="col"></div>
                            <div class="col "><a class="btn btn-outline-success" href="<?= URL ?>/filmesSeries/PartFinal/<?= $dados['indicacao'] ?>/<?= $dados['indicacao'] == 'editar' ? $dados['idFilme'] : '' ?>">Cadastrar</a></div>

                        </div>
                        <div class="adm-espacing">.</div>
                    </div>
                </div><!-- fechamento adm-forme-->
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12"></div>
        </div>
    </div>
</div>
</div>