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
            <!--Conteudo da parte principal do site-->
            <div class="row">
                <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12"></div>
                <div class="col-xl-8 col-lg-9 col-md-10 col-sm-12">
                    <div class="adm-forme container mx-2 ">
                        <div class="adm-espacing">.</div>
                        <h1 class="mt-2">Cadastrando anime (parte 1)</h1>
                        <form action="<?= URL ?>/Animes/parteUm/<?= $dados['indicacao'] ?>/<?= $dados['indicacao'] == 'editar' ? $dados["id_anime"] : '' ?> " method="POST" name="cadastroAnime" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nomeInput" class="form-label">Nome:<span>*</span></label>
                                <input name="nome" type="text" class="form-control" id="nomeInput" aria-describedby="nome anime" value="<?= isset($_SESSION["dadosAnime"]['nome']) ? $_SESSION["dadosAnime"]['nome'] : '' ?>">
                                <div class="form-text"><?= $dados["nome_erro"] ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="sinops" class="form-label">Sinops<span>*</span></label>
                                <textarea class="form-control" id="sinops" rows="3" name="Sinops"><?= isset($_SESSION["dadosAnime"]['sinops']) ? $_SESSION["dadosAnime"]['sinops'] : '' ?></textarea>
                                <div class="form-text"> <?= $dados["Sinops_erro"] ?></div>
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupFile01">Adicionar imagem</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="imagen" id="img-anime">
                            </div>
                            <div class="row mt-4 ms-3 ">
                                <div class="col  "><a class="btn btn-outline-secondary" href="<?= URL ?>/Animes/index">Voltar</a></div>
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
