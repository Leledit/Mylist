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
                        <div class="mt-4" role="alert">
                            <?= utilities::mensagenAlerta('AdmVideo') ?>
                        </div>
                        <div class="adm-espacing">.</div>
                        <h1 class="mt-2"><?= $dados['acaoPag'] == 'Cadastro'? 'Cadastrando': $dados['acaoPag']?> Video (<?= $_SESSION['identifVideo'] ?>)</h1>
                        <form action="<?= URL ?>/Videos/<?= $dados['acaoPag']?>/<?= $_SESSION['identifVideo'] == 'Opening' ? 'Opening' :'Closure' ?>/<?= $dados['acaoPag'] == 'Cadastro'?  $dados['id_anime']  : $dados['id_video'] ?>" method="POST" name="cadastroVideo" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="identificadorInput" class="form-label">Identificador:<span>*</span></label>
                                <input  name="identificador" type="text" class="form-control" id="identificadorInput" aria-describedby="Identificação video" value="<?= $dados['nome_anime'] ?>">
                                
                            </div>
                            <div class="mb-3">
                                <label for="tipoInput" class="form-label">Tipo:</label>
                                <input name="tipo" type="text" class="form-control" id="tipoInput" aria-describedby="tipo de video" value="<?= $_SESSION['identifVideo'] ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="UrlInput" class="form-label">Url:<span>*</span></label>
                                <input name="url" type="text" class="form-control" id="UrlInput" aria-describedby="URL do video" value="https://www.youtube.com/embed/">
                                <div class="form-text">
                                    <?= $dados["url_erro"] ?>
                                </div>
                            </div>
                            

                            <div class="row mt-4 ms-3 ">
                                <div class="col "><a class="btn btn-outline-secondary" href="<?= URL ?>/Animes/item/<?= $dados['id_anime'] ?>">Voltar</a></div>
                                <div class="col"></div>
                                <div class="col"><button class="btn btn-outline-success" type="submit">Cadastro</button></div>
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