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
                        <h1 class="mt-2">Cadastrando anime (parte 2)</h1>
                        <form action="<?= URL ?>/Animes/ParteDois/<?= $dados['indicacao'] ?>/<?= $dados["id_anime"] ?>" method="POST" name="cadastroUsu">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qtdEpInput" class="form-label">Qtd Episodios:<span>*</span></label>
                                        <input name="qtdEp" type="number" class="form-control" id="qtdEpInput" aria-describedby="Quantidade de episodios" value="<?= isset($_SESSION["dadosAnime"]['qtdEp']) ? $_SESSION["dadosAnime"]['qtdEp'] : '' ?>">
                                        <div class="form-text"><?= $dados['qtdEp_erro'] ?></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qtdOvaisEpInput" class="form-label">Qtd ovais:<span>*</span></label>
                                        <input name="qtdOvais" type="number" class="form-control" id="qtdOvaisEpInput" aria-describedby="Quantidade de Ovais" value="<?= isset($_SESSION["dadosAnime"]['qtdOvais']) ? $_SESSION["dadosAnime"]['qtdOvais'] : '0' ?>">
                                        <div class="form-text">    <?= $dados['qtdOvais_erro'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="qtdfilmesEpInput" class="form-label">Qtd Filmes:<span>*</span></label>
                                        <input name="qtdFilmes" type="number" class="form-control" id="qtdfilmesEpInput" aria-describedby="Quantidade de filmes" value="<?= isset($_SESSION["dadosAnime"]['qtdFilmes']) ? $_SESSION["dadosAnime"]['qtdFilmes'] : '0' ?>">
                                        <div class="form-text"><?= $dados['qtdFilmes_erro'] ?></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="anoLancamentoEpInput" class="form-label">Lançamento:<span>*</span></label>
                                        <input name="anoLancamento" type="number" class="form-control" id="anoLancamentoEpInput" aria-describedby="Ano de lançamento" value="<?= isset($_SESSION["dadosAnime"]['anoLancamento']) ? $_SESSION["dadosAnime"]['anoLancamento'] : '0' ?>">
                                        <div class="form-text"><?= $dados['anoLancamento_erro'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Situação:<span>*</span></label>
                                <select class="form-select" aria-label="Escolha a situação " name="situacao">
                                    <option value="Ja visto" <?= $_SESSION["dadosAnime"]['situacao'] == 'Ja visto' ? 'selected' : ' ' ?>>Ja visto</option>
                                    <option value="Nao terminado" <?= $_SESSION["dadosAnime"]['situacao'] == 'Nao terminado' ? 'selected' : ' ' ?>>Nao terminado</option>
                                    <option value="nunca visto" <?= $_SESSION["dadosAnime"]['situacao'] == 'nunca visto' ? 'selected' : ' ' ?>>nunca visto</option>
                                    <option value="ND" <?= $_SESSION["dadosAnime"]['situacao'] == 'ND' ? 'selected' : ' ' ?>>ND</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Formato:<span>*</span></label>
                                <select class="form-select" aria-label="Escolha o formato" name="formato">
                                    <option value="Animação japoneza" <?= $_SESSION["dadosAnime"]['Formato'] == 'Animação japoneza' ? 'selected' : ' ' ?>>Animação japoneza</option>
                                    <option value="Animação Coreana" <?= $_SESSION["dadosAnime"]['Formato'] == 'Animação Coreana' ? 'selected' : ' ' ?>>Animação Coreana</option>
                                    <option value="Animação americana" <?= $_SESSION["dadosAnime"]['Formato'] == 'Animação americana' ? 'selected' : ' ' ?>>Animação americana</option>
                                    <option value="Animação europeu" <?= $_SESSION["dadosAnime"]['Formato'] == 'Animação europeu' ? 'selected' : ' ' ?>>Animação europeu</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="temporadaAnteriorEpInput" class="form-label">Temporada anterior:<span>*</span></label>
                                        <input name="tempAnterior" type="text" class="form-control" id="temporadaAnteriorEpInput" aria-describedby="Temporada anterior" value="<?= isset($_SESSION["dadosAnime"]['tempAnterior']) ? $_SESSION["dadosAnime"]['tempAnterior'] : 'ND' ?>">
                                        <div class="form-text"><?= $dados['tempAnterior_erro'] ?></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="proxTempEpInput" class="form-label">Temporada anterior:<span>*</span></label>
                                        <input name="proxTemp" type="text" class="form-control" id="proxTempEpInput" aria-describedby="Proxima temporada" value="<?= isset($_SESSION["dadosAnime"]['proxTemp']) ? $_SESSION["dadosAnime"]['proxTemp'] : 'ND' ?>">
                                        <div class="form-text">   <?= $dados['proxTemp_erro'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 ms-3 ">
                                <div class="col "><a class="btn btn-outline-secondary" href="<?= URL ?>/Animes/parteUm/<?= $dados['indicacao'] ?>">Voltar</a></div>
                                <div class="col"></div>
                                <div class="col"><button class="btn btn-outline-success" type="submit">Proximo</button></div>
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