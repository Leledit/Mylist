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
                <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>
                <div class="col-xl-8 col-lg-9 col-md-10 col-sm-12">
                    <div class="adm-forme container mx-2 ">
                        <div class="adm-espacing">.</div>
                        <h1 class="mt-2">Cadastrando Serie ou filme (parte 1)</h1>
                        <form action="<?= URL ?>/filmesSeries/parteUm/<?= $dados['indicacaoPart'] ?>/<?= $dados['indicacao'] == 'editar' ? $dados["id"] : '' ?>" method="POST" name="cadastroAnime" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nomeInput" class="form-label">Nome:<span>*</span></label>
                                <input type="text" class="form-control" id="nomeInput" aria-describedby="nome Filme/serie" name="nome" value="<?= isset($_SESSION["infoFilmes"]) ? $_SESSION["infoFilmes"]['nome'] : '' ?>">
                                <div class="form-text"> <?= $dados['nome_erro'] ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="sinops" class="form-label">Sinops<span>*</span></label>
                                <textarea class="form-control" id="sinops" rows="3" name="Sinops"><?= isset($_SESSION["infoFilmes"]) ? $_SESSION["infoFilmes"]['sinops'] : '' ?></textarea>
                                <div class="form-text"> <?= $dados['Sinops_erro'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="dataLancamentoInput" class="form-label">Lançamento:<span>*</span></label>
                                        <input type="text" class="form-control" id="dataLancamentoInput" aria-describedby="Data lançamento" name="lancamento" value="<?= isset($_SESSION["infoFilmes"]['lancamento']) ? $_SESSION["infoFilmes"]['lancamento'] : '' ?>">
                                        <div class="form-text"><?= $dados['lancamento_erro'] ?></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="dataLancamentoInput" class="form-label">Duração:<span>*</span></label>
                                        <input type="text" class="form-control" id="dataLancamentoInput" aria-describedby="Duração anime" name="duracao" value="<?= isset($_SESSION["infoFilmes"]['duracao']) ? $_SESSION["infoFilmes"]['duracao'] : '' ?>">
                                        <div class="form-text"><?= $dados['duracao_erro'] ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupFile01">Adicionar imagem</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="imagem" id="img">
                                <div class="form-text">   <?= $dados['img_erro'] ?></div>
                            </div>
                            <div class="row mt-4 ms-3 ">
                                <div class="col  "><a class="btn btn-outline-secondary" href="<?= URL ?>/FilmesSeries/index">Voltar</a></div>
                                <div class="col"></div>
                                <div class="col"><button class="btn btn-outline-success" type="submit" id="proximo">Proximo</button></div>
                            </div>
                            <div class="adm-espacing">.</div>

                        </form>
                    </div><!-- fechamento adm-forme-->
                </div>
                <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>
            </div>
        </div>
    </div>
</div>