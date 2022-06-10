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
            <div class="list-content-adm container ">
                <div class="adm-add-record">
                    <div class="col-xl-12 col-md-12 col-sm-12  ">
                        <h4>Todas as <?= $_SESSION['identifVideo'] ?></h4>

                        <div class="row">
                            <?php if (isset($dados) == null) : ?>
                                <p>Opss! Nao existem nenhuma Encerramento disponivel</p>
                            <?php else : ?>
                                <?php foreach ($dados as $dado) : ?>
                                    <div class="content-video col-xl-5 col-md-12 col-sm-12 ms-xl-5 ">
                                        <h1><a href="<?= URL ?>/Videos/editar/Opening/<?= $dado->id?>"><?= $dado->identificador ?></a></h1>
                                        <iframe src="<?= $dado->url_video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>